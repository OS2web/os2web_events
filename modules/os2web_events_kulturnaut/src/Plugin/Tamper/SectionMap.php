<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Drupal\os2web_events_kulturnaut\Plugin\Tamper;

use Drupal\tamper\Exception\TamperException;
use Drupal\tamper\TamperableItemInterface;
use Drupal\tamper\TamperBase;
use Drupal\os2web_events_kulturnaut\Form\SettingsForm;

/**
 * Plugin implementation for filtering data.
 *
  @Tamper(
 *   id = "section_map_tamper",
 *   label = @Translation("Section Map"),
 *   description = @Translation("Modify the data in the way you want."),
 *   category = "Events",
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
      $sections = $settingFormConfig->get('version_' . $paths[1]);
      $event_categories = array();
      if (!empty($sections)) {
        foreach ($sections as $section) {
          $event_categories[] = (int) $section['target_id'];
        }
      }
      return $event_categories;
    }
    return false;
  }
}
