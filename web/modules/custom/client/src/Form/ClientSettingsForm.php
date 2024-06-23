<?php
declare(strict_types=1);

namespace Drupal\client\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class ClientSettingsForm extends FormBase
{
  public function getFormId(): string
  {
    return 'client_settings';
  }

  public function submitForm(array &$form, FormStateInterface $form_state)
  {
    // TODO: Implement submitForm() method.
  }

  public function buildForm(array $form, FormStateInterface $form_state): array
  {
    $form['client_settings']['#markup'] = 'Settings form for client entities. Manage field settings here.';

    return $form;
  }

}
