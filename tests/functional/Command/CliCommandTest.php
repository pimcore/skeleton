<?php
declare(strict_types=1);

namespace App\Tests\Functional\Command;

use App\Kernel;
use Pimcore\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CliCommandTest extends KernelTestCase
{
    private CommandTester $cmd;

    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    protected function setUp(): void
    {
        // First, let tests believe that the process is executed as a console application.
        define('PIMCORE_CONSOLE', true);

        parent::setUp();

        $application = new Application(self::bootKernel());
        $this->cmd = new CommandTester($application->find('list'));
    }

    public function testPimcoreCommandsAppearInListing(): void
    {
        $this->cmd->execute([]);

        self::assertStringContainsString('pimcore:', $this->cmd->getDisplay());
    }
}
