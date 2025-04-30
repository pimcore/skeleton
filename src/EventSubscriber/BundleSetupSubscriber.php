<?php

declare(strict_types=1);

/**
 * This source file is available under the terms of the
 * Pimcore Open Core License (POCL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 *  @copyright  Copyright (c) Pimcore GmbH (https://www.pimcore.com)
 *  @license    Pimcore Open Core License (POCL)
 */

namespace App\EventSubscriber;

use Pimcore\Bundle\AdminBundle\PimcoreAdminBundle;
use Pimcore\Bundle\InstallBundle\Event\BundleSetupEvent;
use Pimcore\Bundle\InstallBundle\Event\InstallEvents;
use Pimcore\Bundle\QuillBundle\PimcoreQuillBundle;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class BundleSetupSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [
            InstallEvents::EVENT_BUNDLE_SETUP => [
                ['bundleSetup'],
            ],
        ];
    }

    public function bundleSetup(BundleSetupEvent $event): void
    {
        // add required PimcoreAdminBundle
        if (class_exists(PimcoreAdminBundle::class)) {
            $event->addRequiredBundle(
                'PimcoreAdminBundle',
                PimcoreAdminBundle::class,
                true
            );
        }
        if (class_exists(PimcoreQuillBundle::class)) {
            $event->addRequiredBundle(
                'PimcoreQuillBundle',
                PimcoreQuillBundle::class,
                true
            );
        }
    }
}
