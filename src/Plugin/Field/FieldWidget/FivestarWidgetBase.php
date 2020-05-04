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
   * Returns a list of all available Fivestar widgets.
   *
   * @return array
   *   An associative array where each key is the location of a CSS file for a
   *   fivestar widget and each value is the user-facing name of the widget.
   */
  protected function getAllWidgets() {
    return \Drupal::moduleHandler()->invokeAll('fivestar_widgets');
  }

}
