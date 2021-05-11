# Pimcore Project Skeleton 

This skeleton should be used by experienced Pimcore developers for starting a new project from the ground up. 
If you are new to Pimcore, it's better to start with our demo package, listed below 😉

## Getting started
```bash
COMPOSER_MEMORY_LIMIT=-1 composer create-project pimcore/skeleton my-project
cd ./my-project
./vendor/bin/pimcore-install
```

- Point your virtual host to `my-project/public` 
- Open https://your-host/admin in your browser
- Done! 😎

## Docker

You can also use Docker to setup a new Pimcore Installation:

```bash
COMPOSER_MEMORY_LIMIT=-1 composer create-project pimcore/skeleton my-project
cd ./my-project
docker-compose run --rm php vendor/bin/pimcore-install --mysql-host-socket=db --mysql-username=pimcore --mysql-password=pimcore --mysql-database=pimcore
docker-compose run --rm php chown -R www-data:www-data var/*
docker-compose up -d
```
You can now navigate your browser to https://localhost or https://localhost/admin.
The default docker-compose comes with PHP 8.0 on debian-buster and mariadb 10.5.

## Other demo/skeleton packages
- [Pimcore Basic Demo](https://github.com/pimcore/demo)
