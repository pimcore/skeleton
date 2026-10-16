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
    private bool $databaseUrlOverridden = false;

    private string|false $originalDatabaseUrl = false;

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->useTestDatabase();

        // The profiler is only available in the dev environment, so boot that one instead of the test environment.
        self::bootKernel(['environment' => 'dev', 'debug' => true]);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        $this->restoreDatabaseUrl();
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

    /**
     * The dev environment does not apply the test database override of config/packages/test, so point the
     * default connection at the test database explicitly instead of the development one.
     */
    private function useTestDatabase(): void
    {
        $dsn = $_SERVER['PIMCORE_TEST_DB_DSN'] ?? $_ENV['PIMCORE_TEST_DB_DSN'] ?? getenv('PIMCORE_TEST_DB_DSN');
        if (!is_string($dsn) || '' === $dsn) {
            return;
        }

        $this->originalDatabaseUrl = getenv('DATABASE_URL');
        $this->databaseUrlOverridden = true;

        $_SERVER['DATABASE_URL'] = $_ENV['DATABASE_URL'] = $dsn;
        putenv('DATABASE_URL=' . $dsn);
    }

    private function restoreDatabaseUrl(): void
    {
        if (!$this->databaseUrlOverridden) {
            return;
        }

        if (false === $this->originalDatabaseUrl) {
            unset($_SERVER['DATABASE_URL'], $_ENV['DATABASE_URL']);
            putenv('DATABASE_URL');
        } else {
            $_SERVER['DATABASE_URL'] = $_ENV['DATABASE_URL'] = $this->originalDatabaseUrl;
            putenv('DATABASE_URL=' . $this->originalDatabaseUrl);
        }

        $this->databaseUrlOverridden = false;
    }
}
