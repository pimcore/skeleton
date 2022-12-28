<?php

use Pimcore\Bootstrap;
use Pimcore\Tool;
use Symfony\Component\HttpFoundation\Request;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

Bootstrap::setProjectRoot();
Bootstrap::bootstrap();

return function (Request $request, array $context) {

    // set current request as property on tool as there's no
    // request stack available yet
    Tool::setCurrentRequest($request);

    /** @var \Pimcore\Kernel $kernel */
    $kernel = \Pimcore\Bootstrap::kernel();

    // reset current request - will be read from request stack from now on
    Tool::setCurrentRequest(null);

    return $kernel;
};
