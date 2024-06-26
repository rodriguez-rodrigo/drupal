<?php

declare(strict_types=1);

namespace Drupal\KernelTests\Core\Database;

/**
 * Tests serializing and unserializing a query.
 *
 * @group Database
 */
class SerializeQueryTest extends DatabaseTestBase {

  /**
   * Confirms that a query can be serialized and unserialized.
   */
  public function testSerializeQuery(): void {
    $query = $this->connection->select('test');
    $query->addField('test', 'age');
    $query->condition('name', 'Ringo');
    // If this doesn't work, it will throw an exception, so no need for an
    // assertion.
    $query = unserialize(serialize($query));
    $results = $query->execute()->fetchCol();
    $this->assertEquals(28, $results[0], 'Query properly executed after unserialization.');
  }

}
