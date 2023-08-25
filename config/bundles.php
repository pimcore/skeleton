<?php

return [
    //Twig\Extra\TwigExtraBundle\TwigExtraBundle::class => ['all' => true],
];

use Pimcore\Bundle\DataImporterBundle\PimcoreDataImporterBundle;
// ...

return [
    // ...
    // make sure PimcoreDataHubBundle is added before to that list
    // ...
    PimcoreDataImporterBundle::class => ['all' => true],
    // ...
];