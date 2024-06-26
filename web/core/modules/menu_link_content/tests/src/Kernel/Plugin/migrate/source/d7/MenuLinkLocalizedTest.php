<?php

declare(strict_types=1);

namespace Drupal\Tests\menu_link_content\Kernel\Plugin\migrate\source\d7;

use Drupal\Tests\migrate\Kernel\MigrateSqlSourceTestBase;

// cspell:ignore mlid plid tsid

/**
 * Tests menu link localized translation source plugin.
 *
 * @covers \Drupal\menu_link_content\Plugin\migrate\source\d7\MenuLinkLocalized
 * @group menu_link_content
 */
class MenuLinkLocalizedTest extends MigrateSqlSourceTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['menu_link_content', 'migrate_drupal'];

  /**
   * {@inheritdoc}
   */
  public static function providerSource() {
    $tests = [];
    $tests[0]['source_data']['menu_links'] = [
      [
        'menu_name' => 'menu-test-menu',
        'mlid' => 130,
        'plid' => 469,
        'link_path' => 'http://google.com',
        'router_path' => '',
        'link_title' => 'Google',
        'options' => 'a:1:{s:10:"attributes";a:1:{s:5:"title";s:11:"en - Google";}}',
        'module' => 'menu',
        'hidden' => 0,
        'external' => 1,
        'has_children' => 0,
        'expanded' => 0,
        'weight' => 0,
        'depth' => 2,
        'customized' => 1,
        'p1' => '469',
        'p2' => '467',
        'p3' => '0',
        'p4' => '0',
        'p5' => '0',
        'p6' => '0',
        'p7' => '0',
        'p8' => '0',
        'p9' => '0',
        'updated' => '0',
        'language' => 'en',
        'i18n_tsid' => '2',
        'skip_source_translation' => TRUE,
      ],
      [
        'menu_name' => 'menu-test-menu',
        'mlid' => 131,
        'plid' => 469,
        'link_path' => 'http://google.com',
        'router_path' => '',
        'link_title' => 'fr - Google',
        'options' => 'a:1:{s:10:"attributes";a:1:{s:5:"title";s:23:"fr - Google description";}}',
        'module' => 'menu',
        'hidden' => 0,
        'external' => 1,
        'has_children' => 0,
        'expanded' => 0,
        'weight' => 0,
        'depth' => 2,
        'customized' => 1,
        'p1' => '469',
        'p2' => '467',
        'p3' => '0',
        'p4' => '0',
        'p5' => '0',
        'p6' => '0',
        'p7' => '0',
        'p8' => '0',
        'p9' => '0',
        'updated' => '0',
        'language' => 'fr',
        'i18n_tsid' => '2',
        'skip_source_translation' => TRUE,
      ],
      [
        'menu_name' => 'menu-test-menu',
        'mlid' => 132,
        'plid' => 469,
        'link_path' => 'https://duckduckgo.com/',
        'router_path' => '',
        'link_title' => 'DuckDuckGo',
        'options' => 'a:1:{s:10:"attributes";a:1:{s:5:"title";s:21:"DuckDuckGo";}}',
        'module' => 'menu',
        'hidden' => 0,
        'external' => 1,
        'has_children' => 0,
        'expanded' => 0,
        'weight' => 0,
        'depth' => 2,
        'customized' => 1,
        'p1' => '469',
        'p2' => '467',
        'p3' => '0',
        'p4' => '0',
        'p5' => '0',
        'p6' => '0',
        'p7' => '0',
        'p8' => '0',
        'p9' => '0',
        'updated' => '0',
        'language' => 'und',
        'i18n_tsid' => '0',
        'skip_source_translation' => TRUE,
      ],
      [
        'menu_name' => 'menu-test-menu',
        'mlid' => 139,
        'plid' => 138,
        'link_path' => 'admin/modules',
        'router_path' => 'admin/modules',
        'link_title' => 'Test 2',
        'options' => 'a:1:{s:10:"attributes";a:1:{s:5:"title";s:9:"Test link";}}',
        'module' => 'menu',
        'hidden' => 0,
        'external' => 0,
        'has_children' => 0,
        'expanded' => 0,
        'weight' => 12,
        'depth' => 2,
        'customized' => 1,
        'p1' => '138',
        'p2' => '139',
        'p3' => '0',
        'p4' => '0',
        'p5' => '0',
        'p6' => '0',
        'p7' => '0',
        'p8' => '0',
        'p9' => '0',
        'updated' => '0',
        'language' => 'und',
        'i18n_tsid' => '0',
        'skip_source_translation' => TRUE,
      ],
    ];

    $tests[0]['expected_data'] = [
      [
        'menu_name' => 'menu-test-menu',
        'mlid' => 130,
        'plid' => 469,
        'link_path' => 'http://google.com',
        'router_path' => '',
        'link_title' => 'Google',
        'description' => 'en - Google',
        'module' => 'menu',
        'hidden' => 0,
        'enabled' => TRUE,
        'external' => 1,
        'has_children' => 0,
        'expanded' => 0,
        'weight' => 0,
        'depth' => 2,
        'customized' => 1,
        'p1' => '469',
        'p2' => '467',
        'p3' => '0',
        'p4' => '0',
        'p5' => '0',
        'p6' => '0',
        'p7' => '0',
        'p8' => '0',
        'p9' => '0',
        'updated' => '0',
        'language' => 'en',
        'i18n_tsid' => '2',
        'skip_source_translation' => FALSE,
      ],
      [
        'menu_name' => 'menu-test-menu',
        'mlid' => 130,
        'plid' => 469,
        'link_path' => 'http://google.com',
        'router_path' => '',
        'link_title' => 'fr - Google',
        'description' => 'fr - Google description',
        'module' => 'menu',
        'hidden' => 0,
        'enabled' => TRUE,
        'external' => 1,
        'has_children' => 0,
        'expanded' => 0,
        'weight' => 0,
        'depth' => 2,
        'customized' => 1,
        'p1' => '469',
        'p2' => '467',
        'p3' => '0',
        'p4' => '0',
        'p5' => '0',
        'p6' => '0',
        'p7' => '0',
        'p8' => '0',
        'p9' => '0',
        'updated' => '0',
        'language' => 'fr',
        'i18n_tsid' => '2',
        'skip_source_translation' => TRUE,
      ],
    ];

    return $tests;
  }

}
