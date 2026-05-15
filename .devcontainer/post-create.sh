#!/usr/bin/env bash
set -e

USERNAME="vscode"
BASE_DIR=$(pwd)/govbr
WEB_DIR=/var/www/html
TEMPLATE_PATH="${WEB_DIR}/templates/govbr"
JOOMLA_CLI="${WEB_DIR}/cli/joomla.php"

echo "--> Waiting for MariaDB server to be available..."
while ! mariadb-admin ping -h"db" --skip-ssl -u root -p"$JOOMLA_DB_PASSWORD" --silent; do
    sleep 1
done
echo "✅ MariaDB server is ready."

echo "--> Installing Composer and NPM dependencies..."
composer install
npm install
echo "✅ Dependencies installed."

echo "--> Installing Joomla using the official package downloaded..."
sudo php "${WEB_DIR}/installation/joomla.php" install \
    --site-name="${JOOMLA_SITE_NAME}" \
    --admin-user="${JOOMLA_ADMIN_USER}" \
    --admin-username="${JOOMLA_ADMIN_USERNAME}" \
    --admin-password="${JOOMLA_ADMIN_PASSWORD}" \
    --admin-email="${JOOMLA_ADMIN_EMAIL}" \
    --db-type="mysqli" \
    --db-host="db" \
    --db-name="${JOOMLA_DB_NAME}" \
    --db-user="${JOOMLA_DB_USER}" \
    --db-pass="${JOOMLA_DB_PASSWORD}" \
    --db-prefix="gov_" \
    --db-encryption="0" \
    --public-folder=""
echo "✅ Joomla installed."

echo "--> Building the template..."
npm run build
echo "✅ Build completed."

echo "--> Adding symbolic links for files and directories..."
sudo ln -snf "${BASE_DIR}" "${WEB_DIR}/templates/govbr"
sudo ln -snf "${BASE_DIR}/media" "${WEB_DIR}/media/templates/site/govbr"

for relative_path in $(find "${BASE_DIR}/language/" -type f); do
    clean_path="${relative_path#${BASE_DIR}/language/}"
    lang_code=$(dirname "${clean_path}")
    sudo mkdir -p "${WEB_DIR}/language/${lang_code}"
    sudo ln -sf "${BASE_DIR}/language/${clean_path}" "$WEB_DIR/language/${clean_path}"
done
echo "✅ Symbolic links added."

echo "--> Installing the GovBR template..."
sudo php "${JOOMLA_CLI}" extension:discover
sudo php "${JOOMLA_CLI}" extension:discover:install
echo "✅ GovBR template installed."

echo "--> Applying development settings..."
sudo php "${JOOMLA_CLI}" config:set debug=true
sudo php "${JOOMLA_CLI}" config:set error_reporting=maximum
echo "✅ Development settings applied."

echo "--> Applying Apache settings..."
echo "<Directory $(pwd)/govbr>
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>" | sudo tee -a /etc/apache2/apache2.conf
service apache2 start
echo "✅ Apache configured."

echo "--> Setting group ownership and permissions..."
sudo chmod a+x "${BASE_DIR}"
sudo chown -R "${USERNAME}":www-data "${WEB_DIR}"
sudo chmod -R g+rws "${WEB_DIR}"
echo "✅ Permissions applied."

echo "Please, go to http://localhost:8080/administrator/index.php?option=com_templates&view=styles to enable the template as default."
echo "✅ Done!"
