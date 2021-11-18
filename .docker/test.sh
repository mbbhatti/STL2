#!/usr/bin/env bash

.docker/installComposer.sh
export SENTRY_DSN=https://foo@smfhq.com/4
export SENTRY_ENVIRONMENT=test
export DATABASE_URL=mysql://app:password@acud2testmariadb:3306/acud2test?serverVersion=5.7
php composer.phar install

cp .docker/additional_php.ini $PHP_INI_DIR/conf.d/

mkdir -p /var/upload || true
mkdir -p /var/test || true

cat <<ENV_FILE > .env.test
KERNEL_CLASS='App\Kernel'
APP_SECRET=""
SYMFONY_DEPRECATIONS_HELPER=999999
APP_ENV="test"
APP_SECRET=""
DATABASE_URL="mysql://app:password@acud2testmariadb:3306/acud2test?serverVersion=5.7"
BASE_PATH="/public/"
API_PASSWORD_HASH='\$2y\$13\$4I5LTCU1zUfp8bP9Vy/DX..AJx/hjVVYhvtsBpNa7myqHCy2D8Amy'
ADMIN_PASSWORD_HASH='\$2y\$13\$1MPOnxuPSRxSeVVyojfj5.qNWwB4863lDWvQi7aS4CpLm8QkzqG6a'

ENV_FILE

until $(mysql -hacud2testmariadb -uapp -ppassword acud2test < .docker/testsetup.sql); do
    echo "Waiting for the database..."
    sleep 2
done
mysql -hacud2testmariadb -uapp -ppassword acud2test < structure.sql

vendor/bin/phpunit --log-junit var/test/junit.xml --testdox $@
