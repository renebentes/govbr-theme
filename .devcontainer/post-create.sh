#!/usr/bin/env bash
set -euo pipefail
shopt -s globstar nullglob

USERNAME="vscode"
BASE_DIR=$(pwd)
WEB_DIR=/var/www/html
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
sudo ln -snf "${BASE_DIR}/govbr" "${WEB_DIR}/templates/govbr"
sudo ln -snf "${BASE_DIR}/govbr/media" "${WEB_DIR}/media/templates/site/govbr"

sudo mkdir -p "${WEB_DIR}/plugins/console"
sudo ln -snf "${BASE_DIR}/cli" "${WEB_DIR}/plugins/console/govbr"

language_files=(
    "${BASE_DIR}"/cli/language/**/*.ini
    "${BASE_DIR}"/govbr/language/**/*.ini
)

for language_file in "${language_files[@]}"; do
    target_dir="${WEB_DIR}/language"
    clean_path="${language_file#*/language/}"
    lang_code=$(dirname "${clean_path}")

    if [[ "$language_file" == *"/cli/language/"* ]]; then
        target_dir="${WEB_DIR}/administrator/language"
    fi

    sudo mkdir -p "${target_dir}/${lang_code}"
    sudo ln -sf "${language_file}" "${target_dir}/${clean_path}"
done
echo "✅ Symbolic links added."

echo "--> Installing the GovBR extensions..."
sudo php "${JOOMLA_CLI}" extension:discover
sudo php "${JOOMLA_CLI}" extension:discover:install
echo "✅ GovBR extensions installed."

echo "--> Configuring the GovBR template..."
# sudo php "${JOOMLA_CLI}" govbr:template:configure
echo "✅ GovBR template configured."

echo "--> Applying development settings..."
sudo php "${JOOMLA_CLI}" config:set debug=true
sudo php "${JOOMLA_CLI}" config:set error_reporting=maximum
echo "✅ Development settings applied."

echo "--> Setting group ownership and permissions..."
sudo chmod a+x "${BASE_DIR}"
sudo chown -R "${USERNAME}":www-data "${WEB_DIR}"
sudo chmod -R g+rws "${WEB_DIR}"
echo "✅ Permissions applied."

echo "✅ Done!"
