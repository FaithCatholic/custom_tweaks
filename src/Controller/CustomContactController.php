<?php

namespace Drupal\custom_tweaks\Controller;

use Drupal\contact\Controller\ContactController;
use Drupal\user\UserInterface;
use Drupal\Core\Url;

/**
 * Extend controller from base contact module.
 */
class CustomContactController extends ContactController {
  /**
   * Extended personal page method from the base contact module.
   */
  public function contactPersonalPage(UserInterface $user) {
    // Original method returns $form.
    $form = parent::contactPersonalPage($user);

    // Set custom title from pre-defined, optional field-ui textfields.
    $name_display = $this->_contactPersonalPageTitle();
    $form['#title'] = $this->t('Contact @name', array('@name' => $name_display));

    // Return to drupal_render().
    return $form;
  }

  /**
   * Helper function that returns a concatenated display name from some
   * optional text fields in a user account.
   */
  private function _contactPersonalPageTitle() {
    // Use current path to grab the user object.
    $path = \Drupal::service('path.current')->getPath();
    $params = Url::fromUri("internal:" . $path)->getRouteParameters();
    $user = \Drupal::entityTypeManager()->getStorage('user')->load($params['user']);

    // Grab name parts, if the exist.
    $name_prefix = $user->get('field_user_prefix')->getValue();
    $name_first = $user->get('field_user_first_name')->getValue();
    $name_last = $user->get('field_user_last_name')->getValue();
    $name_suffix = $user->get('field_user_suffix')->getValue();

    // Assemble the full[est] name for display.
    $name_display = '';
    if ($name_prefix[0]['value'] != '') {
      $name_display .= $name_prefix[0]['value'] .' ';
    }
    if ($name_first[0]['value'] != '') {
      $name_display .= $name_first[0]['value'];
    }
    if ($name_first[0]['value'] != '' && $name_last[0]['value'] != '') {
      $name_display .= ' ';
    }
    if ($name_last[0]['value'] != '') {
      $name_display .= $name_last[0]['value'];
    }
    if ($name_suffix[0]['value'] != '') {
      $name_display .= ' '. $name_suffix[0]['value'];
    }

    // Use system username if no fields are filled.
    if (trim($name_display) == '') {
      $name_display = $user->getUsername();
    }

    // String
    return $name_display;
  }

}
