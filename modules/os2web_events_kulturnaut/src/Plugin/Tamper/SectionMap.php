<?php

namespace Drupal\os2web_events_kulturnaut\Plugin\Tamper;

use Drupal\tamper\TamperableItemInterface;
use Drupal\tamper\TamperBase;
use Drupal\os2web_events_kulturnaut\Form\SettingsForm;

/**
 * Plugin implementation for filtering data.
 *
  @Tamper(
 *   id = "os2web_events_kulturnaut_section_map_tamper",
 *   label = @Translation("OS2Web Section Map"),
 *   description = @Translation("Adds mapping to a section specific in Kulturnatut module settings"),
 *   category = "OS2Web Events Kulturnaut",
 * )
 */
class SectionMap extends TamperBase {

  /**
   * {@inheritdoc}
   */
  public function tamper($data, TamperableItemInterface $item = NULL) {
    $settingFormConfig = \Drupal::config(SettingsForm::$configName);
    $source = $item->getSource();
    $data = array_pop($source["parent:source"]);
    $query = parse_url($data, PHP_URL_QUERY);
    $paths = explode('=', $query);
    if ($paths[0] == 'version') {
      $sections = $settingFormConfig->get('section_mapping_' . $paths[1]);
      $event_sections = array();
      if (!empty($sections)) {
        foreach ($sections as $section) {
          $event_sections[] = (int) $section['target_id'];
        }
      }
      return $event_sections;
    }
    return false;
  }
}
