<?php
declare(strict_types=1);

namespace Drupal\client\Form;

use Drupal\Core\Entity\ContentEntityDeleteForm;
use Drupal\Core\Entity\EntityMalformedException;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;

class ClientDeleteForm extends ContentEntityDeleteForm
{
  public function getQuestion(): TranslatableMarkup
  {
    return $this->t('Are you sure you want to delete %name?', ['%name' => $this->entity->label()]);
  }
}
