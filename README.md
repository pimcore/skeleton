# Pimcore 5 Project Skeleton 

This skeleton should be used by experienced Pimcore developers for starting a new project from the ground up. 
If you are new to Pimcore, it's better to start with one of our demo packages, listed below 😉

## Getting started 
```bash
COMPOSER_MEMORY_LIMIT=-1 composer create-project pimcore/skeleton my-project
cd ./my-project
./vendor/bin/pimcore-install
```

- Point your virtual host to `my-project/web` 
- Open https://your-host/admin in your browser
- Done! 😎


## Other demo/skeleton packages
- [Pimcore Basic Demo (PHP-Templates)](https://github.com/pimcore/demo-basic)
- [Pimcore Basic Demo (Twig-Templates)](https://github.com/pimcore/demo-basic-twig)
- [Pimcore Advanced Demo](https://github.com/pimcore/demo-ecommerce) 
- [Pimcore Skeleton](https://github.com/pimcore/skeleton)
