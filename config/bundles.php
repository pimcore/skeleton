<?php

use Pimcore\Bundle\DataImporterBundle\PimcoreDataImporterBundle;
use Pimcore\Bundle\DataHubBundle\PimcoreDataHubBundle;
return [
    //Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],

    PimcoreDataImporterBundle::class => ['all' => true],
    PimcoreDataHubBundle::class => ['all' => true],
];
