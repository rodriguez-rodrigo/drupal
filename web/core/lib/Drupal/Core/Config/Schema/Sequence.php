<?php

namespace Drupal\Core\Config\Schema;

/**
 * Defines a configuration element of type Sequence.
 *
 * This object may contain any number and type of nested elements that share
 * a common definition in the 'sequence' property of the configuration schema.
 *
 * Read https://www.drupal.org/node/1905070 for more details about configuration
 * schema, types and type resolution.
 *
 * Note that sequences implement the typed data ComplexDataInterface (via the
 * parent ArrayElement) rather than the ListInterface. This is because sequences
 * may have named keys, which is not supported by ListInterface. From the typed
 * data API perspective sequences are handled as ordered mappings without
 * metadata about existing properties.
 */
class Sequence extends ArrayElement {

  /**
   * {@inheritdoc}
   */
  protected function getElementDefinition($key) {
    $value = $this->value[$key] ?? NULL;
    // @todo Remove BC layer for sequence with hyphen in front. https://www.drupal.org/node/2444979
    $definition = [];
    if (isset($this->definition['sequence'][0])) {
      $definition = $this->definition['sequence'][0];
      $bc_sequence_location = $this->getPropertyPath();
      @trigger_error("The definition for the '$bc_sequence_location' sequence declares the type of its items in a way that is deprecated in drupal:8.0.0 and is removed from drupal:11.0.0. See https://www.drupal.org/node/2442603", E_USER_DEPRECATED);
    }
    elseif ($this->definition['sequence']) {
      $definition = $this->definition['sequence'];
    }
    return $this->buildDataDefinition($definition, $value, $key);
  }

}
