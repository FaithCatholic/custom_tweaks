<?php

namespace Drupal\custom_tweaks\Plugin\Field\FieldFormatter;

use Drupal\date_recur\Plugin\Field\FieldFormatter\DateRecurDefaultFormatter;

/**
 * Plugin implementation of the 'custom_date_recur_default_formatter' formatter.
 *
 * @FieldFormatter(
 *   id = "starting_date_recur_default_formatter",
 *   label = @Translation("Starting date recur default formatter"),
 *   field_types = {
 *     "date_recur"
 *   }
 * )
 */
class StartingDateRecurDefaultFormatter extends DateRecurDefaultFormatter {

  protected function buildDateRangeValue($start_date, $end_date, $isOccurrence = FALSE) {
    if ($isOccurrence) {
      $start_date->_dateRecurIsOccurrence = $end_date->_dateRecurIsOccurrence = TRUE;
    }
    $element = $this->buildDateWithIsoAttribute($start_date);
    return $element;
  }

}
