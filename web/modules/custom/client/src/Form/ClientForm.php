<?php
declare(strict_types=1);

namespace Drupal\client\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Entity\ContentEntityFormInterface;
use Drupal\Core\Entity\EntityStorageException;
use Drupal\Core\Form\FormStateInterface;

class ClientForm extends ContentEntityForm implements ContentEntityFormInterface
{

  /**
   * @throws EntityStorageException
   */
  public function save(array $form, FormStateInterface $form_state): void
  {
    $form_state->setRedirect('entity.client.collection');
    $entity = $this->getEntity();
    $entity->save();
  }
}
