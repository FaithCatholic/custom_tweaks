<?php

namespace Drupal\custom_tweaks\Controller;

use Drupal\Core\Controller\ControllerBase;

/**
 * Class ContactConfirmation.
 *
 * @package Drupal\custom_tweaks\Controller
 */
class ContactConfirmation extends ControllerBase {

  /**
   * Default.
   *
   * @return string
   *   Return Hello string.
   */
  public function default() {
    return [
      '#type' => 'markup',
      '#markup' => $this->t('<p>Thank you, your message has been sent successfully!</p><p><a href="/">Return to home page...</a></p>')
    ];
  }

}
