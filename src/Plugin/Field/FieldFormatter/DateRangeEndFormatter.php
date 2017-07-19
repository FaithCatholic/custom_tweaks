<?php

namespace Drupal\custom_tweaks\Plugin\Field\FieldFormatter;

use Drupal\datetime_range\Plugin\Field\FieldFormatter\DateRangeCustomFormatter;
use Drupal\Core\Field\FieldItemListInterface;

/**
 * Plugin implementation of the 'Custom' formatter for 'daterange' fields.
 *
 * This formatter renders the data range as plain text, with a fully
 * configurable date format using the PHP date syntax and separator.
 *
 * @FieldFormatter(
 *   id = "daterange_custom_end",
 *   label = @Translation("Custom end time"),
 *   field_types = {
 *     "daterange"
 *   }
 * )
 */
class DateRangeEndFormatter extends DateRangeCustomFormatter {

  /**
   * {@inheritdoc}
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];
    foreach ($items as $delta => $item) {
      if (!empty($item->end_date)) {
        /** @var \Drupal\Core\Datetime\DrupalDateTime $end_date */
        $end_date = $item->end_date;
        // Always return the end date/time only.
        $elements[$delta] = $this->buildDate($end_date);
      }
    }
    return $elements;
  }

}
