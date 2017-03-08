<?php

namespace Drupal\custom_tweaks\Plugin\Field\FieldFormatter;

use Drupal\date_recur\Plugin\Field\FieldFormatter\DateRecurDefaultFormatter;

/**
 * Plugin implementation of the 'date_recur_start_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "date_recur_start_formatter",
 *   label = @Translation("Date recur start time formatter"),
 *   field_types = {
 *     "date_recur"
 *   }
 * )
 */
class DateRecurStartFormatter extends DateRecurDefaultFormatter {

  protected function buildDateRangeValue($start_date, $end_date, $isOccurrence = FALSE) {
    if ($isOccurrence) {
      $start_date->_dateRecurIsOccurrence = $end_date->_dateRecurIsOccurrence = TRUE;
    }
    $element = $this->buildDateWithIsoAttribute($start_date);
    return $element;
  }

}
