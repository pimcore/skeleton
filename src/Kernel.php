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

use Pimcore\Bundle\AdminBundle\PimcoreAdminBundle;
use Pimcore\Bundle\ApplicationLoggerBundle\PimcoreApplicationLoggerBundle;
use Pimcore\Bundle\CustomReportsBundle\PimcoreCustomReportsBundle;
use Pimcore\Bundle\GlossaryBundle\PimcoreGlossaryBundle;
use Pimcore\Bundle\SeoBundle\PimcoreSeoBundle;
use Pimcore\Bundle\SimpleBackendSearchBundle\PimcoreSimpleBackendSearchBundle;
use Pimcore\Bundle\StaticRoutesBundle\PimcoreStaticRoutesBundle;
use Pimcore\Bundle\TinymceBundle\PimcoreTinymceBundle;
use Pimcore\Bundle\UuidBundle\PimcoreUuidBundle;
use Pimcore\Bundle\WordExportBundle\PimcoreWordExportBundle;
use Pimcore\Bundle\XliffBundle\PimcoreXliffBundle;
use Pimcore\HttpKernel\BundleCollection\BundleCollection;
use Pimcore\Kernel as PimcoreKernel;
use TorqIT\FolderCreatorBundle\FolderCreatorBundle;
use TorqIT\RoleCreatorBundle\RoleCreatorBundle;
use CoreShop\Bundle\MessengerBundle\CoreShopMessengerBundle;

class Kernel extends PimcoreKernel
{
    /**
     * Adds bundles to register to the bundle collection. The collection is able
     * to handle priorities and environment specific bundles.
     *
     */
    public function registerBundlesToCollection(BundleCollection $collection): void
    {
        $collection->addBundle(new PimcoreAdminBundle(), 60);
        // Official Pimcore bundles
        $collection->addBundle(new PimcoreApplicationLoggerBundle());
        $collection->addBundle(new PimcoreCustomReportsBundle());
        $collection->addBundle(new PimcoreGlossaryBundle());
        $collection->addBundle(new PimcoreSeoBundle());
        $collection->addBundle(new PimcoreSimpleBackendSearchBundle());
        $collection->addBundle(new PimcoreStaticRoutesBundle());
        $collection->addBundle(new PimcoreTinymceBundle());
        $collection->addBundle(new PimcoreUuidBundle());
        $collection->addBundle(new PimcoreXliffBundle());
        $collection->addBundle(new PimcoreWordExportBundle());
        // Custom bundles
        $collection->addBundle(new FolderCreatorBundle());
        $collection->addBundle(new RoleCreatorBundle());
        $collection->addBundle(new CoreShopMessengerBundle());
    }
}
