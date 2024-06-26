<?php

declare(strict_types=1);

namespace Drupal\Tests\comment\Functional;

use Drupal\comment\Entity\Comment;
use Drupal\field\Entity\FieldConfig;
use Drupal\field\Entity\FieldStorageConfig;

/**
 * Tests that comments behave correctly when the node is changed.
 *
 * @group comment
 */
class CommentNodeChangesTest extends CommentTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * Tests that comments are deleted with the node.
   */
  public function testNodeDeletion(): void {
    $this->drupalLogin($this->webUser);
    $comment = $this->postComment($this->node, $this->randomMachineName(), $this->randomMachineName());
    $this->assertInstanceOf(Comment::class, $comment);
    $this->node->delete();
    $this->assertNull(Comment::load($comment->id()), 'The comment could not be loaded after the node was deleted.');
    // Make sure the comment field storage and all its fields are deleted when
    // the node type is deleted.
    $this->assertNotNull(FieldStorageConfig::load('node.comment'), 'Comment field storage exists');
    $this->assertNotNull(FieldConfig::load('node.article.comment'), 'Comment field exists');
    // Delete the node type.
    $this->node->get('type')->entity->delete();
    $this->assertNull(FieldStorageConfig::load('node.comment'), 'Comment field storage deleted');
    $this->assertNull(FieldConfig::load('node.article.comment'), 'Comment field deleted');
  }

}
