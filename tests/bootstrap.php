<?php

// define project root which will be used throughout the bootstrapping process
define('PIMCORE_PROJECT_ROOT', dirname(__DIR__));

const PROJECT_ROOT = PIMCORE_PROJECT_ROOT;

// set the used pimcore/symfony environment
putenv('APP_ENV=test');
$_ENV['APP_ENV'] = 'test';

require_once PIMCORE_PROJECT_ROOT . '/vendor/autoload.php';

\Pimcore\Bootstrap::setProjectRoot();
\Pimcore\Bootstrap::bootstrap();
