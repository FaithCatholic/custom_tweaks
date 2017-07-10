<?php

namespace Drupal\custom_tweaks\Plugin\Field\FieldFormatter;

use Drupal\datetime_range\Plugin\Field\FieldFormatter\DateRangeCustomFormatter as DateRangeCustomFormatterBase;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Custom' formatter for 'daterange' fields.
 *
 * This formatter renders the data range as plain text, with a fully
 * configurable date format using the PHP date syntax and separator.
 *
 * @FieldFormatter(
 *   id = "daterange_custom_start",
 *   label = @Translation("Custom start time"),
 *   field_types = {
 *     "daterange"
 *   }
 * )
 */
class DateRangeCustomFormatter extends DateRangeCustomFormatterBase {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      if (!empty($item->start_date)) {
        /** @var \Drupal\Core\Datetime\DrupalDateTime $start_date */
        $start_date = $item->start_date;
        // Always return the start date/time only.
        $elements[$delta] = $this->buildDate($start_date);
      }
    }
    return $elements;
  }

}
