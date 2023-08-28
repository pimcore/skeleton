<?php

use Pimcore\Bundle\DataImporterBundle\PimcoreDataImporterBundle;
use Pimcore\Bundle\DataHubBundle\PimcoreDataHubBundle;
use Pimcore\Bundle\ApplicationLoggerBundle\PimcoreApplicationLoggerBundle;
return [
    //Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],

    PimcoreDataImporterBundle::class => ['all' => true],
    PimcoreDataHubBundle::class => ['all' => true],
    PimcoreApplicationLoggerBundle::class => ['all' => true],
];
