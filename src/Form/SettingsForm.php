<?php

namespace Drupal\os2web_events\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;


/**
 * Configure os2web_borgerdk settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * Name of the config.
   *
   * @var string
   */
  public static $configName = 'os2web_events.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'os2web_events_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [SettingsForm::$configName];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $old_events_handle = $this->config(SettingsForm::$configName)
      ->get('old_events_handle');
    $form['old_events_handle'] = array(
      '#type' => 'radios',
      '#title' => t('Old events should be'),
      '#default_value' => isset($old_events_handle) ? $old_events_handle : 0,
      '#options' => array(
        0 => t('Unpublished'),
        1 =>t('Deleted'),
      ),
    );

    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $values = $form_state->getValues();

    $config = $this->config(SettingsForm::$configName);
    foreach ($values as $key => $value) {
      $config->set($key, $value);
    }
    $config->save();

    parent::submitForm($form, $form_state);
  }

}
