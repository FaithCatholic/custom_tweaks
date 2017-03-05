<?php

namespace Drupal\custom_tweaks\Controller;

use Drupal\contact\Controller\ContactController;
use Drupal\user\UserInterface;
use Drupal\Core\Url;
use Drupal\Core\Render\RendererInterface;

/**
 * Controller routines for contact routes.
 */
class CustomContactController extends ContactController {

  /**
   * Constructs a ContactController object.
   *
   * @param \Drupal\Core\Render\RendererInterface $renderer
   *   The renderer.
   */
  public function __construct(RendererInterface $renderer) {
    parent::__construct($renderer);
  }

  /**
   * Extended form constructor for the personal contact form.
   *
   * @param \Drupal\user\UserInterface $user
   *   The account for which a personal contact form should be generated.
   *
   * @return array
   *   The personal contact form as render array as expected by drupal_render().
   */
  public function contactPersonalPage(UserInterface $user) {
    // Original method returns $form.
    $form = parent::contactPersonalPage($user);

    // Set custom title from pre-defined, optional field-ui textfields.
    $name_display = $this->_contactPersonalPageTitle();
    $form['#title'] = $this->t('Contact @name', array('@name' => $name_display));

    return $form;
  }

  /**
   * Helper function that creates a display name using the current
   * path and a set of pre-defined user account field-ui fields.
   *
   * @param \Drupal\user\UserInterface $user
   *   The account for which a personal contact form should be generated.
   *
   * @return string
   *   The long-form display name of the user, or the username.
   */
  protected function _contactPersonalPageTitle() {
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

    return $name_display;
  }

}
