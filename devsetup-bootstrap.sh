#!/usr/bin/env bash

echo "**** Running direnv allow"

which direnv >/dev/null
if [ $? == "1" ]; then
   echo "ERROR: 'direnv' is not installed. For Installation Guide see https://direnv.net/docs/installation.html"
   exit 3
fi
direnv allow

echo "**** Creating custom composer docker image"

COMPOSER_REPO_URL="https://repo.packagist.com/krankikom/"
COMPOSER_AUTH_TOKEN="c8a7ecca281bc7a6682a01fc5cb406a73aabf86ed5ffa81285049e650b41"
COMPOSER_AUTH_ENVVAR="{\"http-basic\": {\"repo.packagist.com\": {\"username\": \"krankikom\", \"password\": \"$COMPOSER_AUTH_TOKEN\"}}}"

DOCKERFILE_TMPDIR=`mktemp -d`
DOCKERFILE="$DOCKERFILE_TMPDIR/Dockerfile"
cat >$DOCKERFILE <<EOT
FROM composer
RUN docker-php-ext-install mysqli pdo pdo_mysql
EOT

docker build -t composer-pdo $DOCKERFILE_TMPDIR

echo "**** Running composer install"
TMP_ENVFILE=$(mktemp)

cat <<EOT >> $TMP_ENVFILE
COMPOSER_AUTH=$COMPOSER_AUTH_ENVVAR
EOT

docker run --rm -it --env-file $TMP_ENVFILE -v ${PWD}:/app --user $(id -u):$(id -g) composer-pdo install -v --ignore-platform-reqs --no-scripts

if [ -f ./vendor/krankikom/pimcore-jetpakk/devsetup/devsetup-bootstrap.sh ]; then
	./vendor/krankikom/pimcore-jetpakk/devsetup/devsetup-bootstrap.sh
fi