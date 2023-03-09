<?php

/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace App;

use Pimcore\HttpKernel\BundleCollection\BundleCollection;
use Pimcore\Kernel as PimcoreKernel;

class Kernel extends PimcoreKernel
{
    /**
     * Adds bundles to register to the bundle collection. The collection is able
     * to handle priorities and environment specific bundles.
     *
     * @param BundleCollection $collection
     */
    public function registerBundlesToCollection(BundleCollection $collection): void
    {
        if (class_exists('\\AppBundle\\AppBundle')) {
            $collection->addBundle(new \AppBundle\AppBundle);
        }
    }
}
