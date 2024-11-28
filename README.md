# Pimcore Project Skeleton (Torq IT fork)

Forked from https://github.com/pimcore/skeleton.

## Setup

### Prerequisites:
- A Linux based system (or Windows Subsystem for Linux (WSL) if you are on Windows - see https://learn.microsoft.com/en-us/windows/wsl/install for more information)
- Docker Desktop (https://www.docker.com/products/docker-desktop/)

### Setup instructions
1. Clone the repository
2. Update the `origin` remote to point to your client-specific repository: `git remote origin set-url origin <new repository URL>`
3. Update the name of your main branch, e.g. `git branch -m main`
4. Update the `name` property in `composer.json` to match your project's name
5. Update the `.env` property `APP_NAME` to match your project's name
6. Update the `.env.` properties ending in `_EXTERNAL` with unused port values (i.e. those that don't conflict with other apps you may be running)
7. Under the `.secrets` directory:
  1. Create a file called `kernel-secret` and add a random 32-character string to it.
  2. Do NOT commit any of the files in this directory to your repository (they should already be gitignored).
8. Run `docker compose up -d` to build the Docker images and run the containers
9. By default, go to `localhost:8400` in your browser to access the Pimcore admin (port is controlled by the `WEB_EXTERNAL_PORT` environment variable). Use username `admin` and password `pimcore` to log in.

## Getting updates
We recommend forking this repository and using it as an upstream remote in order to get the latest updates and improvements. To do that, run the following commands:
1. If using SSH for Git, run `git remote add upstream git@github.com:TorqIT/shopware-skeleton.git`; otherwise, run `git remote add upstream https://github.com/TorqIT/shopware-skeleton.git`
2. To fetch and merge updates from the skeleton, run `git fetch upstream`, then `git merge upstream/2024.x`.
