<?php

declare(strict_types=1);

namespace Drupal\custom_tweaks;

use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Security\TrustedCallbackInterface;

/**
 * Provides tweaks for datetime functionality.
 */
final class DateTimeTweaks implements TrustedCallbackInterface {

  /**
   * Update datetime widgets not to use a time input element.
   *
   * @param array &$element
   *   The element to check and alter.
   */
  public function widgetFormAlter(array &$element, FormStateInterface $form_state, array $context): void {
    // Swap HTML5 time input and replace with a text input for ALL date+time fields.
    if (array_key_exists('value', $element) && $element['value']['#type'] === 'datetime') {
      $callback = [static::class, 'alterTimeWidget'];
      $element['value']['#date_time_callbacks'][] = $callback;
      // Check for an end date, too
      if (array_key_exists('end_value', $element)) {
        $element['end_value']['#date_time_callbacks'][] = $callback;
      }
    }
  }

  /**
   * Callback for altering time widgets.
   *
   * @see \Drupal\custom_tweaks\DateTimeTweaks::widgetFormAlter().
   */
  public static function alterTimeWidget(array &$element, FormStateInterface $form_state, $date): void {
    if (array_key_exists('#description', $element['time']) && !$element['time']['#description']) {
      $element['time']['#description'] = t('Format: 04:30 PM');
    }
    $element['time']['#attributes']['type'] = 'text';
    $element['time']['#attributes']['placeholder'] = '04:30 PM';
  }

  /**
   * {@inheritdoc}
   */
  public static function trustedCallbacks(): array {
    return ['alterTimeWidget'];
  }

}
