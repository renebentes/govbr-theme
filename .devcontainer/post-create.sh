#!/usr/bin/env bash
set -e

USERNAME="vscode"
BASE_DIR=$(pwd)/govbr
WEB_DIR=/var/www/html
TEMPLATE_PATH=${WEB_DIR}/templates/govbr
JOOMLA_CLI=${WEB_DIR}/cli/joomla.php

sudo chmod a+x "${BASE_DIR}"

composer update
npm install

# Wait for the web server to be available
while [ $(curl -sk "http://localhost:8080" -o /dev/null -w "%{http_code}") -ne 200 ]; do
    sleep 5
done

sudo vendor/bin/phing

sudo chown -R ${USERNAME}:www-data ${WEB_DIR}

${JOOMLA_CLI} extension:discover
${JOOMLA_CLI} extension:discover:install

sudo su -c "${JOOMLA_CLI} config:set debug=true"
sudo su -c "${JOOMLA_CLI} config:set error_reporting=maximum"

echo "Please, go to http://localhost:8080/administrator/index.php?option=com_templates&view=styles to enable the template as default."
echo "Done!"
