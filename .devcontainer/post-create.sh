#!/usr/bin/env bash
set -e

USERNAME="vscode"
BASE_DIR=$(pwd)/govbr
WEB_DIR=/var/www/html
TEMPLATE_PATH=${WEB_DIR}/templates/govbr
JOOMLA_CLI=${WEB_DIR}/cli/joomla.php

sudo chmod a+x "${BASE_DIR}"

echo "--> Installing Composer and NPM dependencies..."
composer install
npm install
echo "✅ Dependencies installed."

echo "--> Waiting for the web server to be available"
while [ $(curl -sk "http://localhost:8080" -o /dev/null -w "%{http_code}") -ne 200 ]; do
    sleep 1
done
echo "✅ Web server is available."

echo "--> Building the template and running Phing build tasks..."
npm run build
vendor/bin/phing
echo "✅ Build completed."

echo "--> Installing and enabling the GovBR template..."
sudo su -c "${JOOMLA_CLI} extension:install --path=./build/govbr.tar.gz"
echo "✅ GovBR template installed."

echo "--> Applying development settings..."
sudo su -c "${JOOMLA_CLI} config:set debug=true"
sudo su -c "${JOOMLA_CLI} config:set error_reporting=maximum"
echo "✅ Development settings applied."

echo "--> Setting group ownership and permissions..."
sudo chown -R ${USERNAME}:www-data ${WEB_DIR}
sudo chmod -R g+rws ${WEB_DIR}

echo "Please, go to http://localhost:8080/administrator/index.php?option=com_templates&view=styles to enable the template as default."
echo "✅ Done!"
