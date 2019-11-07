# Docker-Compose for Pimcore 6
Simple and easy Docker-Compose configuration for Pimcore 6.

Docker-Compose consists of following images:
 - Redis
 - MariaDB 10.1
 - httpd (Apache 2.4) & PHP-FPM with PHP7.1 and all Pimcore required dependencies (LibreOffice, FFMPEG, Image Libraries, etc)
 - PHP-FPM with PHP7.0 and all Pimcore required dependencies (LibreOffice, Image Libraries, etc) (except FFMPEG)
 
## Getting Started

### Requirements
* git
* docker
* docker-compose

### Checkout Repo
```bash
git clone https://github.com/pimcore/skeleton.git
cd skeleton/
 ```

### Run Containers
```bash
# initialize and startup containers
docker-compose up
```

### Install Vendor Packages 
```bash
# get shell in running container
docker exec -it pimcore-php bash

# Install vendor packages
composer install

#increase the memory_limit to >= 512MB as required by pimcore-install
echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;
service apache2 reload

#run installer
./vendor/bin/pimcore-install --mysql-host-socket=db --mysql-username=pimcore --mysql-password=pimcore --mysql-database=pimcore 
 ```

### Use
After the installer is finished, you can open in your Browser:
* Frontend: http://localhost:2000
* Backend: http://localhost:2000/admin

### Common Errors 

#### File permissions 
On some machines docker has problems with the relative symlinked (static) files. Run those commands in your `pimcore-php` container 

```bash 
docker-compose exec php bash 
chown www-data: . -R 
```

This could take a while because of the amount of files inside the directory (especially because of the `vendor` folder). There is no guarantee that those commands on all machines and operating systems. 


