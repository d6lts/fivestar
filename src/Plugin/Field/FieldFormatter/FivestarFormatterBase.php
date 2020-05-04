<?php

namespace Drupal\fivestar\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FormatterBase;
use Drupal\Core\Render\Element;

/**
 * Base class for Fivestar field formatters.
 */
abstract class FivestarFormatterBase extends FormatterBase {

  /**
   * @param array $element
   * @return array
   */
  public function previewsExpand(array $element) {
    foreach (Element::children($element) as $css) {
      $vars = [
        '#theme' => 'fivestar_preview_widget',
        '#css' => $css,
        '#name' => strtolower($element[$css]['#title']),
      ];
      $element[$css]['#description'] = \Drupal::service('renderer')
        ->render($vars);
    }
    return $element;
  }

  /**
   * Return list of all available widgets.
   *
   * @return array
   */
  protected function getAllWidgets() {
    return \Drupal::moduleHandler()->invokeAll('fivestar_widgets');
  }

}
