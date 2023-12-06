#!/bin/bash

if [[ -f .env ]]; then
    echo "Pull master branch"
    git pull origin master

    echo "composer install"
    php yii2 composer install --no-interaction --prefer-dist --optimize-autoloader --ignore-platform-reqs

    echo "Start migration"
    php yii migrate --interactive=0
    echo "Fixture set"
    php yii fixture "*" --interactive=0
    echo "Login details: Username/Password"
else
    echo "The .env file does not exist. Please create a .env file before running composer install and migration."
fi