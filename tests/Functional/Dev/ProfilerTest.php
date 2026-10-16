<?php
declare(strict_types=1);

namespace App\Tests\Functional\Dev;

use App\Kernel;
use Pimcore\Test\KernelTestCase;
use Symfony\Bundle\WebProfilerBundle\EventListener\WebDebugToolbarListener;
use Symfony\Component\HttpFoundation\Request;

/**
 * Covers the shipped dev-environment profiler defaults (config/packages/dev, config/routes/dev).
 */
class ProfilerTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    protected function setUp(): void
    {
        parent::setUp();

        // The profiler is only available in the dev environment, so boot that one instead of the test environment.
        self::bootKernel(['environment' => 'dev', 'debug' => true]);
    }

    public function testPhpinfoRouteIsNotMatched(): void
    {
        $match = self::$kernel->getContainer()->get('router')->match('/_profiler/phpinfo');

        // The URL must fall through to the profiler's token route instead of reaching the phpinfo action.
        self::assertNotSame('_profiler_phpinfo', $match['_route']);
        self::assertSame('_profiler', $match['_route']);
        self::assertSame('phpinfo', $match['token']);
    }

    public function testPhpinfoIsNotServed(): void
    {
        $response = self::$kernel->handle(Request::create('/_profiler/phpinfo'));
        $content = (string) $response->getContent();

        // The profiler's token route answers instead, reporting an unknown token.
        self::assertStringNotContainsString('PHP Version', $content);
        self::assertStringNotContainsString('PHP Credits', $content);
        self::assertStringContainsString('phpinfo', $content);
    }

    public function testProfilerRoutesStillWork(): void
    {
        $router = self::$kernel->getContainer()->get('router');

        // Only phpinfo is blocked: the profiler itself and its links to the phpinfo route keep working.
        self::assertSame('_profiler_search_results', $router->match('/_profiler/abc123/search/results')['_route']);
        self::assertSame('/_profiler/phpinfo', $router->generate('_profiler_phpinfo'));
    }

    public function testToolbarIsDisabledByDefault(): void
    {
        $container = self::$kernel->getContainer();

        // The parameter is only registered while the toolbar (or redirect interception) is enabled.
        $enabled = $container->hasParameter('web_profiler.debug_toolbar.mode')
            && WebDebugToolbarListener::ENABLED === $container->getParameter('web_profiler.debug_toolbar.mode');

        self::assertFalse($enabled);
    }
}
