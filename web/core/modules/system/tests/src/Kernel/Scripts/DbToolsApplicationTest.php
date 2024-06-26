<?php

declare(strict_types=1);

namespace Drupal\Tests\system\Kernel\Scripts;

use Drupal\Core\Command\DbToolsApplication;
use Drupal\KernelTests\KernelTestBase;

/**
 * Test that the DbToolsApplication works correctly.
 *
 * The way console application's run it is impossible to test. For now we only
 * test that we are registering the correct commands.
 *
 * @group console
 */
class DbToolsApplicationTest extends KernelTestBase {

  /**
   * Tests that the dump command is correctly registered.
   */
  public function testDumpCommandRegistration(): void {
    $application = new DbToolsApplication();
    $command = $application->find('dump');
    $this->assertInstanceOf('\Drupal\Core\Command\DbDumpCommand', $command);
    $this->assertSame(\Drupal::VERSION, $application->getVersion());
  }

  /**
   * Tests that the dump command is correctly registered.
   */
  public function testImportCommandRegistration(): void {
    $application = new DbToolsApplication();
    $command = $application->find('import');
    $this->assertInstanceOf('\Drupal\Core\Command\DbImportCommand', $command);
  }

}
