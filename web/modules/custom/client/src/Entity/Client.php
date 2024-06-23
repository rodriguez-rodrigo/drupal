<?php
declare(strict_types=1);

namespace Drupal\client\Entity;

use Drupal\Core\Entity\ContentEntityBase;
use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityStorageInterface;
use Drupal\Core\Entity\EntityTypeInterface;
use Drupal\Core\Field\BaseFieldDefinition;

/**
 * Defined the Client entity.
 *
 * @ingroup client
 *
 * @ContentEntityType(
 *   id = "client",
 *   label = @Translation("Client"),
 *   base_table = "client",
 *   entity_keys = {
 *     "id" = "id",
 *     "uuid" = "uuid",
 *   },
 *   handlers = {
 *     "access" = "Drupal\client\ClientAccessControlHandler",
 *     "views_data" = "Drupal\client\ClientViewsData",
 *     "form" = {
 *       "add" = "Drupal\client\Form\ClientForm",
 *       "edit" = "Drupal\client\Form\ClientForm",
 *       "delete" = "Drupal\client\Form\ClientDeleteForm",
 *     }
 *   },
 *   links = {
 *     "canonical" = "/clients/{client}",
 *     "delete-form" = "/clients/{client}/delete",
 *     "edit-form" = "/clients/{client}/edit",
 *     "create-form" = "/clients/create",
 *   },
 *   field_ui_base_route = "entity.client.settings",
 * )
 */
class Client extends ContentEntityBase implements ContentEntityInterface
{
  public static function baseFieldDefinitions(EntityTypeInterface $entity_type): array
  {
    $fields = parent::baseFieldDefinitions($entity_type);

    $fields['user_id'] = BaseFieldDefinition::create('entity_reference')
      ->setLabel(t('User'))
      ->setDescription(t('The user that create the client.'))
      ->setSetting('target_type', 'user')
      ->setSetting('handler', 'default');

    $fields['id'] = BaseFieldDefinition::create('integer')
      ->setLabel(t('ID'))
      ->setDescription(t('The ID of the Client entity.'))
      ->setReadOnly(TRUE);

    $fields['uuid'] = BaseFieldDefinition::create('uuid')
      ->setLabel(t('UUID'))
      ->setDescription(t('The UUID of the Client entity.'))
      ->setReadOnly(TRUE);

    $fields['created'] = BaseFieldDefinition::create('created')
      ->setLabel(t('Created'))
      ->setDescription(t('The time that the entity was created.'))
      ->setReadOnly(TRUE);

    $fields['changed'] = BaseFieldDefinition::create('changed')
      ->setLabel(t('Changed'))
      ->setDescription(t('The time that the entity was last updated.'));

    return $fields;
  }

  /**
   * {@inheritdoc}
   *
   * Makesure the current user owner of the entity.
   */
  public static function preCreate(EntityStorageInterface $storage, array &$values)
  {
    parent::preCreate($storage, $values);
    $values += array(
      'user_id' => \Drupal::currentUser()->id(),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getOwner()
  {
    return $this->get('user_id')->entity;
  }

  /**
   * {@inheritdoc}
   */
  public function getOwnerId()
  {
    return $this->get('user_id')->target_id;
  }
}
