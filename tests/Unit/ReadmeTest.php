<?php

namespace App\Tests\Unit;

use Codeception\Test\Unit;

/**
 * This is a tongue-in-cheek test created to validate codeception functionality.
 */
class ReadmeTest extends Unit
{
    private const README_PATH = PROJECT_ROOT . '/README.md';
    private string $readme;

    protected function setUp(): void
    {
        parent::setUp();
        $this->readme = file_get_contents(self::README_PATH);
    }

    public function testReadmeIsWrittenWithLove(): void
    {
        self::assertStringContainsString('Jetpakk', $this->readme);
    }

    public function testReadmeContainsInstructionsForBootstrapping(): void
    {
        self::assertStringContainsString('devsetup-bootstrap.sh', $this->readme);
    }
}
