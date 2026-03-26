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

namespace App\Installer;

use Pimcore\Bundle\CustomReportsBundle\PimcoreCustomReportsBundle;
use Pimcore\Bundle\GenericDataIndexBundle\PimcoreGenericDataIndexBundle;
use Pimcore\Bundle\GenericExecutionEngineBundle\PimcoreGenericExecutionEngineBundle;
use Pimcore\Bundle\InstallBundle\EnvVarDefinition\ConfigParameter;
use Pimcore\Bundle\InstallBundle\EnvVarDefinition\Definitions\AmqpMessengerEnvVarDefinition;
use Pimcore\Bundle\InstallBundle\EnvVarDefinition\Definitions\DatabaseEnvVarDefinition;
use Pimcore\Bundle\InstallBundle\EnvVarDefinition\Definitions\MercureEnvVarDefinition;
use Pimcore\Bundle\InstallBundle\EnvVarDefinition\Definitions\OpenSearchEnvVarDefinition;
use Pimcore\Bundle\InstallBundle\EnvVarDefinition\Definitions\ProductRegistrationEnvVarDefinition;
use Pimcore\Bundle\InstallBundle\EnvVarDefinition\Definitions\SimpleEnvVarDefinition;
use Pimcore\Bundle\InstallBundle\EnvVarDefinition\ParameterType;
use Pimcore\Bundle\InstallBundle\Profile\DataSource\DataSourceInterface;
use Pimcore\Bundle\InstallBundle\Profile\InstallProfileInterface;
use Pimcore\Bundle\QuillBundle\PimcoreQuillBundle;
use Pimcore\Bundle\StudioBackendBundle\PimcoreStudioBackendBundle;
use Pimcore\Bundle\StudioUiBundle\PimcoreStudioUiBundle;

final readonly class SkeletonProfile implements InstallProfileInterface
{
    private const string SECTION_NAME = 'pimcore/skeleton';

    public function getName(): string
    {
        return 'skeleton';
    }

    public function getDescription(): string
    {
        return 'Pimcore Skeleton - minimal clean install';
    }

    public function getBundles(): array
    {
        return [
            PimcoreGenericExecutionEngineBundle::class,
            PimcoreCustomReportsBundle::class,
            PimcoreGenericDataIndexBundle::class,
            PimcoreStudioBackendBundle::class,
            PimcoreStudioUiBundle::class,
            PimcoreQuillBundle::class,
        ];
    }

    public function getEnvVarDefinitions(): array
    {
        return [
            new DatabaseEnvVarDefinition(),
            new OpenSearchEnvVarDefinition(),
            new AmqpMessengerEnvVarDefinition(),
            new MercureEnvVarDefinition(),
            new ProductRegistrationEnvVarDefinition(),
            new SimpleEnvVarDefinition(
                key: 'application-secret',
                label: 'Application Secret',
                sectionName: self::SECTION_NAME,
                parameters: [
                    new ConfigParameter(
                        envVarName: 'APPLICATION_SECRET',
                        label: 'Application Secret',
                        type: ParameterType::Secret,
                        description: 'Symfony framework secret for CSRF tokens and session security',
                    ),
                ],
            ),
        ];
    }

    public function getDataSource(): ?DataSourceInterface
    {
        return null;
    }

    public function getPostInstallCommands(): array
    {
        return [];
    }
}
