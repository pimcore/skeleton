# Pimcore Project Skeleton (Torq IT fork)

Forked from https://github.com/pimcore/skeleton.

## Setup

### Prerequisites:

-   A Linux based system (or Windows Subsystem for Linux (WSL) if you are on Windows - see https://learn.microsoft.com/en-us/windows/wsl/install for more information)
-   Docker Desktop (https://www.docker.com/products/docker-desktop/)

### Setup instructions

1. Clone the repository
1. Update the `origin` remote to point to your client-specific repository: `git remote set-url origin <new repository URL>`
1. Update the name of your main branch, e.g. `git branch -m main`
1. Update the `name` property in `composer.json` to match your project's name
1. Update the `.env` property `APP_NAME` to match your project's name
1. Update the `.env.` properties ending in `_EXTERNAL` with unused port values (i.e. those that don't conflict with other apps you may be running)
1. Under the `.secrets` directory:
    1. Create a file called `kernel-secret` and add a random 32-character string to it.
    1. Create a file called `pimcore-product-key` and add your Pimcore product key to it.
    1. Create a file called `pimcore-instance-identifier` and add your Pimcore instance ID to it.
    1. Create a file called `pimcore-encryption-secret` and add an encryption secret to it generated using https://github.com/defuse/php-encryption.
    1. Do NOT commit any of the files in this directory to your repository (they should already be gitignored).
1. Run `docker compose up -d` to build the Docker images and run the containers
1. By default, go to `localhost:8400` in your browser to access the Pimcore admin (port is controlled by the `WEB_EXTERNAL_PORT` environment variable). Use username `admin` and password `pimcore` to log in.
1. To run commands in the container, run `docker compose exec --user www-data -it php bash -l`, then run your Symfony/Pimcore `bin/console` commands in the resulting shell.

## Getting updates

We recommend forking this repository and using it as an upstream remote in order to get the latest updates and improvements. To do that, run the following commands:

1. If using SSH for Git, run `git remote add upstream git@github.com:TorqIT/pimcore-skeleton.git`; otherwise, run `git remote add upstream https://github.com/TorqIT/pimcore-skeleton.git`
1. To fetch and merge updates from the skeleton, run `git fetch upstream`, then `git merge upstream/2025.x`.

## Contributing to the skeleton

1. Clone the repository
1. Get the secrets from your password manager (should be named "Pimcore skeleton secrets"), download the ZIP, extract and add the contents to your local repository's `.secrets` folder
1. Create a branch for your work and open a Pull Request
