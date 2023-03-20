<?php

// define project root which will be used throughout the bootstrapping process
define('PIMCORE_PROJECT_ROOT', dirname(__DIR__));

const PROJECT_ROOT = PIMCORE_PROJECT_ROOT;

// set the used pimcore/symfony environment
foreach (['APP_ENV' => 'test', 'PIMCORE_SKIP_DOTENV_FILE' => true] as $name => $value) {
    putenv("{$name}={$value}");
    $_ENV[$name] = $_SERVER[$name] = $value;
}
require_once PIMCORE_PROJECT_ROOT . '/vendor/autoload.php';

\Pimcore\Bootstrap::setProjectRoot();
\Pimcore\Bootstrap::bootstrap();
