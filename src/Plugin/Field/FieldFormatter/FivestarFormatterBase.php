<?php

namespace Drupal\fivestar\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Render\Element;

/**
 * Base class for Fivestar field formatters.
 */
abstract class FivestarFormatterBase extends FormatterBase {

  /**
   * Prepares the widget's render element for rendering.
   *
   * @param array $element
   *   The element to transform.
   *
   * @return array
   *   The transformed element.
   *
   * @see ::formElement()
   */
  public function previewsExpand(array $element) {
    foreach (Element::children($element) as $css) {
      $vars = [
        '#theme' => 'fivestar_preview_widget',
        '#css' => $css,
        '#name' => mb_strtolower($element[$css]['#title']),
      ];
      $element[$css]['#description'] = \Drupal::service('renderer')->render($vars);
    }

    return $element;
  }

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
