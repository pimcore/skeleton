#!/usr/bin/env bash
if [ "$USER" != "gitpod" ]; then
    echo "Please only run this script on gitpod. In fact you should never need to launch this manually"
    exit 1
fi
if [ "$GITPOD_REPO_ROOT" == "/workspace/pimcore-skeleton" ]; then
    echo "Skipping gitpod-init.sh"
    exit 2
fi
echo "*** Creating public/assets|bundles|var & vendor & node_modules"
mkdir -p public/var
mkdir -p public/assets
mkdir -p public/bundles
mkdir -p vendor
mkdir -p node_modules
echo "*** Dockerfile generation"
./docker-build.sh -o
echo "*** Direnv"
direnv allow 
echo "*** Docker build"
echo "*** Changing grp"
sudo chgrp -R www-data var/
sudo chgrp -R www-data public/var/
sudo chgrp -R www-data public/assets/      
sudo chgrp -R www-data public/bundles/
sudo chgrp -R www-data vendor      
sudo chgrp -R www-data node_modules      
sudo chgrp -R www-data config      
echo "*** Changing g+rw"
sudo chmod -R g+rw var
sudo chmod -R g+rw public/var
sudo chmod -R g+rw public/assets
sudo chmod -R g+rw public/bundles
sudo chmod -R g+rw vendor
sudo chmod -R g+rw node_modules
sudo chmod -R g+rw config
echo "*** Changing o+rw for var"
sudo chmod -R o+rw var
echo "*** Elasticsearch data perms"
mkdir -p /workspace/elasticsearch-data/
sudo chown 1000 /workspace/elasticsearch-data/
sudo chgrp gitpod /workspace/elasticsearch-data/
sudo chmod 775 /workspace/elasticsearch-data/
echo "*** Docker-compose build "
DOCKER_BUILDKIT=0 COMPOSE_PARALLEL_LIMIT=1 docker-compose build
echo "*** Docker pull"
DOCKER_BUILDKIT=0 COMPOSE_PARALLEL_LIMIT=1 docker-compose pull

