<?php

declare(strict_types=1);

namespace Drupal\Tests\views\Unit\Plugin\argument_default;

use Drupal\Tests\UnitTestCase;
use Drupal\views\Plugin\views\argument_default\QueryParameter;
use Symfony\Component\HttpFoundation\Request;

/**
 * @coversDefaultClass \Drupal\views\Plugin\views\argument_default\QueryParameter
 * @group views
 */
class QueryParameterTest extends UnitTestCase {

  /**
   * Tests the getArgument() method.
   *
   * @covers ::getArgument
   * @dataProvider providerGetArgument
   */
  public function testGetArgument($options, Request $request, $expected): void {
    $view = $this->getMockBuilder('Drupal\views\ViewExecutable')
      ->disableOriginalConstructor()
      ->onlyMethods([])
      ->getMock();
    $view->setRequest($request);
    $display_plugin = $this->getMockBuilder('Drupal\views\Plugin\views\display\DisplayPluginBase')
      ->disableOriginalConstructor()
      ->getMock();

    $raw = new QueryParameter([], 'query_parameter', []);
    $raw->init($view, $display_plugin, $options);
    $this->assertEquals($expected, $raw->getArgument());
  }

  /**
   * Provides data for testGetArgument().
   *
   * @return array
   *   An array of test data, with the following entries:
   *   - first entry: the options for the plugin.
   *   - second entry: the request object to test with.
   *   - third entry: the expected default argument value.
   */
  public static function providerGetArgument() {
    $data = [];

    $data[] = [
      ['query_param' => 'test'],
      new Request(['test' => 'data']),
      'data',
    ];

    $data[] = [
      ['query_param' => 'test', 'multiple' => 'and'],
      new Request(['test' => ['data1', 'data2']]),
      'data1,data2',
    ];

    $data[] = [
      ['query_param' => 'test', 'multiple' => 'or'],
      new Request(['test' => ['data1', 'data2']]),
      'data1+data2',
    ];

    $data[] = [
      ['query_param' => 'test', 'fallback' => 'foo'],
      new Request([]),
      'foo',
    ];

    $data[] = [
      ['query_param' => 'test[tier1][tier2][tier3]'],
      new Request(['test' => ['tier1' => ['tier2' => ['tier3' => 'foo']]]]),
      'foo',
    ];

    $data[] = [
      ['query_param' => 'test[tier1][tier2]'],
      new Request(['test' => ['tier1' => ['tier2' => ['foo', 'bar']]]]),
      'foo,bar',
    ];

    $data[] = [
      ['query_param' => 'test[tier1][tier2]'],
      new Request(['test' => 'foo']),
      NULL,
    ];

    return $data;
  }

}
