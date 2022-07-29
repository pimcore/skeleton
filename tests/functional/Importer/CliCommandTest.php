<?php

declare(strict_types=1);

namespace App\Tests\Functional\Importer;

use App\Kernel;
use Doctrine\Persistence\ObjectManager;
use Pimcore\Test\KernelTestCase;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class CliCommandTest extends KernelTestCase
{
    private ObjectManager $manager;
    private CommandTester $cmd;

    protected static function getKernelClass()
    {
        return Kernel::class;
    }

    protected function setUp(): void
    {
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
