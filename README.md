# Pimcore Web - based on Krankikom Jetpakk Pimcore Skeleton


## Getting started

### Clone this repo
`git clone git@bitbucket.org:krankikom-gmbh/wbd-pimcore-web.git`

### Run bootstrap

This will install composer dependencies, and run the pimcore install process
```bash
./devsetup-bootstrap.sh
```
Once done, please shut it down `docker-compose down`.

### Bring up web

Once the installation is done, you can run `./devsetup.sh up`


### Doing stuff

`./devsetup.sh` has quite a few options (and displays a help when called without parameters).

To name a few:

- up: starts the web
- down: stops the web
- shell: gives you a bash shell in the php container
- migrate: runs migrations in php container
- classes-rebuild: rebuild pimcore classes


### Prerequisites 

* Docker Desktop >= 20.10.3
* virtioFS activated in Docker Desktop (please validate, should be default)
* For virtioFS you will need macOS Ventura or later
* direnv (see https://direnv.net) - please install, setup and read/understand what it does!
