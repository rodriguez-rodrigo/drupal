<?php

namespace Drupal\text\Plugin\migrate\field\d6;

use Drupal\migrate\Plugin\MigrationInterface;
use Drupal\migrate\Row;
use Drupal\migrate_drupal\Attribute\MigrateField;
use Drupal\migrate_drupal\Plugin\migrate\field\FieldPluginBase;

// cspell:ignore optionwidgets
/**
 * MigrateField Plugin for Drupal 6 text fields.
 */
#[MigrateField(
  id: 'd6_text',
  core: [6],
  type_map: [
    'text' => 'text',
    'text_long' => 'text_long',
    'text_with_summary' => 'text_with_summary',
  ],
  source_module: 'text',
  destination_module: 'text',
)]
class TextField extends FieldPluginBase {

  /**
   * {@inheritdoc}
   */
  public function getFieldWidgetMap() {
    return [
      'text_textfield' => 'text_textfield',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldFormatterMap() {
    return [
      'default' => 'text_default',
      'trimmed' => 'text_trimmed',
      'plain' => 'basic_string',
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function defineValueProcessPipeline(MigrationInterface $migration, $field_name, $field_info) {
    $widget_type = $field_info['widget_type'] ?? $field_info['widget']['type'];

    if ($widget_type == 'optionwidgets_onoff') {
      $process = [
        'value' => [
          'plugin' => 'static_map',
          'source' => 'value',
          'default_value' => 0,
        ],
      ];

      $checked_value = explode("\n", $field_info['global_settings']['allowed_values'])[1];
      if (str_contains($checked_value, '|')) {
        $checked_value = substr($checked_value, 0, strpos($checked_value, '|'));
      }
      $process['value']['map'][$checked_value] = 1;
    }
    else {
      // See \Drupal\migrate_drupal\Plugin\migrate\source\d6\User::baseFields(),
      // signature_format for an example of the YAML that represents this
      // process array.
      $process = [
        'value' => 'value',
        'format' => [
          [
            'plugin' => 'static_map',
            'bypass' => TRUE,
            'source' => 'format',
            'map' => [0 => NULL],
          ],
          [
            'plugin' => 'skip_on_empty',
            'method' => 'process',
          ],
          [
            'plugin' => 'migration_lookup',
            'migration' => [
              'd6_filter_format',
              'd7_filter_format',
            ],
            'source' => 'format',
          ],
        ],
      ];
    }

    $process = [
      'plugin' => 'sub_process',
      'source' => $field_name,
      'process' => $process,
    ];
    $migration->setProcessOfProperty($field_name, $process);
  }

  /**
   * {@inheritdoc}
   */
  public function getFieldType(Row $row) {
    $widget_type = $row->getSourceProperty('widget_type');
    $settings = $row->getSourceProperty('global_settings');

    if ($widget_type == 'text_textfield') {
      $field_type = $settings['text_processing'] ? 'text' : 'string';
      if (empty($settings['max_length']) || $settings['max_length'] > 255) {
        $field_type .= '_long';
      }
      return $field_type;
    }

    if ($widget_type == 'text_textarea') {
      $field_type = $settings['text_processing'] ? 'text_long' : 'string_long';
      return $field_type;
    }

    switch ($widget_type) {
      case 'optionwidgets_buttons':
      case 'optionwidgets_select':
        return 'list_string';

      case 'optionwidgets_onoff':
        return 'boolean';

      default:
        return parent::getFieldType($row);
    }
  }

}
