<?php

namespace Drupal\fivestar\Plugin\Field\FieldWidget;

use Drupal\Core\Field\WidgetBase;

/**
 * Class FivestarWidgetBase.
 *
 * @package Drupal\fivestar\Plugin\Field\FieldWidget
 */
abstract class FivestarWidgetBase extends WidgetBase {

  /**
   * @return array
   */
  protected function getAllWidgets() {
    return \Drupal::moduleHandler()->invokeAll('fivestar_widgets');
  }

}
