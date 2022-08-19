#!/usr/bin/env bash

rsync -rvzhu \
--exclude=".phpintel" \
--exclude="rsync.sh" \
--exclude="resources/assets" \
--exclude="public/uploads" \
--exclude="node_modules" \
--exclude="linters" \
--exclude="tests" \
--exclude=".editorconfig" \
--exclude="vendor" \
--exclude=".gitattributes" \
--exclude=".gitignore" \
--exclude="webpack.mix.js" \
--exclude="package.json" \
--exclude="package-lock.json" \
--exclude="readme.md" \
--exclude="docker-compose.yml" \
--exclude="composer.lock" \
--exclude=".DS_Store" \
--exclude="storage" \
--exclude="storage.zip" \
--exclude="mysql-workbench-community.deb" \
"$(pwd)"/* ultron@192.168.70.86:/var/www/sistema-padrao/
