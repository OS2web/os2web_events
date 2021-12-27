<?php

namespace Drupal\os2web_events_kulturnaut\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\taxonomy\Entity\Term;

/**
 * Configure os2web_borgerdk settings for this site.
 */
class SettingsForm extends ConfigFormBase {

  /**
   * Name of the config.
   *
   * @var string
   */
  public static $configName = 'os2web_events_kulturnaut.settings';

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'os2web_events_kulturnaut_settings';
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
    $possible_events_versions = $this->config(SettingsForm::$configName)
      ->get('event_versions');

    $form['event_versions'] = [
      '#type' => 'textfield',
      '#title' => t('Possible event versions'),
      '#description' => t('Comma-separated list of possible event versions'),
      '#default_value' => $possible_events_versions,
    ];

    // Import settings.
    $form['event_versions'] = [
      '#type' => 'textfield',
      '#title' => t('Possible event versions'),
      '#description' => t('Comma-separated list of possible event versions'),
      '#default_value' => $possible_events_versions,
    ];

    if (!empty($possible_events_versions)) {
      $versions_array = explode(',', $possible_events_versions);
      $form['events_import_mapping_sections_details'] = [
        '#type' => 'details',
        '#title' => t('Section mappings'),
        '#open' => TRUE,
      ];
      $form['events_import_mapping_category_details'] = [
        '#type' => 'details',
        '#title' => t('Category mappings'),
        '#open' => TRUE,
      ];

      foreach ($versions_array as $version) {
        // Section.
        $settings = $this->config(SettingsForm::$configName)
          ->get('section_mapping_' . $version);
        $section_value = array();
        $tids = array();
        if (!empty($settings)) {
          foreach ($settings as $tid) {
            $tids[] = $tid['target_id'];
          }
          $section_value = (!empty($tids)) ? Term::loadMultiple($tids) : array();
        }
        $form['events_import_mapping_sections_details']['section_mapping_' . $version] = array(
          '#title' => $version,
          '#type' => 'entity_autocomplete',
          '#target_type' => 'taxonomy_term',
          '#tags' => TRUE,
          '#selection_settings' => array(
            'target_bundles' => array('os2web_sektion'),
          ),
          '#default_value' => $section_value,
        );

        // Category.
        $settings = $this->config(SettingsForm::$configName)
          ->get('category_mapping_' . $version);
        $category_value = array();
        $tids = array();
        if (!empty($settings)) {
          foreach ($settings as $tid) {
            $tids[] = $tid['target_id'];
          }
          $category_value = (!empty($tids)) ? Term::loadMultiple($tids) : array();
        }
        $form['events_import_mapping_category_details']['category_mapping_' . $version] = array(
          '#title' => $version,
          '#type' => 'entity_autocomplete',
          '#target_type' => 'taxonomy_term',
          '#tags' => TRUE,
          '#selection_settings' => array(
            'target_bundles' => array('os2web_event_category'),
          ),
          '#default_value' => $category_value,
        );
      }
    }

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
