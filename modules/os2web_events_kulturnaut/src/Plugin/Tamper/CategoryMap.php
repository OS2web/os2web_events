<?php

namespace Drupal\os2web_events_kulturnaut\Plugin\Tamper;

use Drupal\tamper\TamperableItemInterface;
use Drupal\tamper\TamperBase;
use Drupal\os2web_events_kulturnaut\Form\SettingsForm;

/**
 * Plugin implementation for filtering data.
 *
  @Tamper(
 *   id = "os2web_events_kulturnaut_category_map_tamper",
 *   label = @Translation("OS2Web Category Map"),
 *   description = @Translation("Adds mapping to a category specific in Kulturnatut module settings"),
 *   category = "OS2Web Events Kulturnaut",
 * )
 */
class CategoryMap extends TamperBase {

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
      $categories = $settingFormConfig->get('category_mapping_' . $paths[1]);
      $event_categories = array();
      if (!empty($categories)) {
        foreach ($categories as $category) {
          $event_categories[] = (int) $category['target_id'];
        }
      }
      return $event_categories;
    }
    return false;
  }
}
