<?php

/**
 * This source file is available under the terms of the
 * Pimcore Open Core License (POCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (https://www.pimcore.com)
 *  @license    Pimcore Open Core License (POCL)
 */

namespace App;

use Pimcore\Bundle\AdminBundle\PimcoreAdminBundle;
use Pimcore\Bundle\QuillBundle\PimcoreQuillBundle;
use Pimcore\HttpKernel\BundleCollection\BundleCollection;
use Pimcore\Kernel as PimcoreKernel;

class Kernel extends PimcoreKernel
{
    /**
     * Adds bundles to register to the bundle collection. The collection is able
     * to handle priorities and environment-specific bundles.
     */
    public function registerBundlesToCollection(BundleCollection $collection): void
    {
        if (class_exists(PimcoreAdminBundle::class)) {
            $collection->addBundle(new PimcoreAdminBundle(), 60);
        }
        if (class_exists(PimcoreQuillBundle::class)) {
            $collection->addBundle(new PimcoreQuillBundle());
        }
    }
}
