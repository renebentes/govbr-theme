#!/usr/bin/env bash
set -e

USERNAME="vscode"
BASE_DIR=$(pwd)/src
WEB_DIR=/var/www/html
TEMPLATE_PATH=${WEB_DIR}/templates/govbr
JOOMLA_CLI=${WEB_DIR}/cli/joomla.php

sudo chmod a+x "${BASE_DIR}"

composer install
sudo vendor/bin/phing

if [ -e ${TEMPLATE_PATH} ]; then
    sudo chown -R ${USERNAME}:www-data ${WEB_DIR}

    ${JOOMLA_CLI} extension:discover
    ${JOOMLA_CLI} extension:discover:install
fi

sudo su -c "${JOOMLA_CLI} config:set debug=true"
sudo su -c "${JOOMLA_CLI} config:set error_reporting=maximum"

echo "Done!"

