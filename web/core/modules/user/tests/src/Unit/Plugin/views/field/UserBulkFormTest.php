<?php

declare(strict_types=1);

namespace Drupal\Tests\user\Unit\Plugin\views\field;

use Drupal\Core\DependencyInjection\ContainerBuilder;
use Drupal\Core\Entity\EntityRepositoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Routing\ResettableStackedRouteMatchInterface;
use Drupal\Tests\UnitTestCase;
use Drupal\user\Plugin\views\field\UserBulkForm;

/**
 * @coversDefaultClass \Drupal\user\Plugin\views\field\UserBulkForm
 * @group user
 */
class UserBulkFormTest extends UnitTestCase {

  /**
   * {@inheritdoc}
   */
  protected function tearDown(): void {
    parent::tearDown();
    $container = new ContainerBuilder();
    \Drupal::setContainer($container);
  }

  /**
   * Tests the constructor assignment of actions.
   */
  public function testConstructor(): void {
    $actions = [];

    for ($i = 1; $i <= 2; $i++) {
      $action = $this->createMock('\Drupal\system\ActionConfigEntityInterface');
      $action->expects($this->any())
        ->method('getType')
        ->willReturn('user');
      $actions[$i] = $action;
    }

    $action = $this->createMock('\Drupal\system\ActionConfigEntityInterface');
    $action->expects($this->any())
      ->method('getType')
      ->willReturn('node');
    $actions[] = $action;

    $entity_storage = $this->createMock('Drupal\Core\Entity\EntityStorageInterface');
    $entity_storage->expects($this->any())
      ->method('loadMultiple')
      ->willReturn($actions);

    $entity_type_manager = $this->createMock(EntityTypeManagerInterface::class);
    $entity_type_manager->expects($this->once())
      ->method('getStorage')
      ->with('action')
      ->willReturn($entity_storage);

    $entity_repository = $this->createMock(EntityRepositoryInterface::class);

    $language_manager = $this->createMock('Drupal\Core\Language\LanguageManagerInterface');

    $messenger = $this->createMock('Drupal\Core\Messenger\MessengerInterface');

    $route_match = $this->createMock(ResettableStackedRouteMatchInterface::class);

    $views_data = $this->getMockBuilder('Drupal\views\ViewsData')
      ->disableOriginalConstructor()
      ->getMock();
    $views_data->expects($this->any())
      ->method('get')
      ->with('users')
      ->willReturn(['table' => ['entity type' => 'user']]);
    $container = new ContainerBuilder();
    $container->set('views.views_data', $views_data);
    $container->set('string_translation', $this->getStringTranslationStub());
    \Drupal::setContainer($container);

    $storage = $this->createMock('Drupal\views\ViewEntityInterface');
    $storage->expects($this->any())
      ->method('get')
      ->with('base_table')
      ->willReturn('users');

    $executable = $this->getMockBuilder('Drupal\views\ViewExecutable')
      ->disableOriginalConstructor()
      ->getMock();
    $executable->storage = $storage;

    $display = $this->getMockBuilder('Drupal\views\Plugin\views\display\DisplayPluginBase')
      ->disableOriginalConstructor()
      ->getMock();

    $definition['title'] = '';
    $options = [];

    $user_bulk_form = new UserBulkForm([], 'user_bulk_form', $definition, $entity_type_manager, $language_manager, $messenger, $entity_repository, $route_match);
    $user_bulk_form->init($executable, $display, $options);

    $reflected_actions = (new \ReflectionObject($user_bulk_form))->getProperty('actions');
    $this->assertEquals(array_slice($actions, 0, -1, TRUE), $reflected_actions->getValue($user_bulk_form));
  }

}
