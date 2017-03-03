<?php

namespace Drupal\custom_tweaks\Controller;

use Drupal\contact\Controller\ContactController;
use Drupal\user\UserInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Drupal\Core\Url;

/**
 * Controller routines for contact routes.
 */
class CustomContactController extends ContactController {

  /**
   * Form constructor for the personal contact form.
   *
   * @param \Drupal\user\UserInterface $user
   *   The account for which a personal contact form should be generated.
   *
   * @return array
   *   The personal contact form as render array as expected by drupal_render().
   *
   * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
   *   Exception is thrown when user tries to access a contact form for a
   *   user who does not have an email address configured.
   */
  public function contactPersonalPage(UserInterface $user) {
    // Do not continue if the user does not have an email address configured.
    if (!$user->getEmail()) {
      throw new NotFoundHttpException();
    }

    $message = $this->entityManager()->getStorage('contact_message')->create(array(
      'contact_form' => 'personal',
      'recipient' => $user->id(),
    ));

    $form = $this->entityFormBuilder()->getForm($message);

    $path = \Drupal::service('path.current')->getPath();
    $params = Url::fromUri("internal:" . $path)->getRouteParameters();
    $user = \Drupal::entityTypeManager()->getStorage('user')->load($params['user']);

    $name_prefix = $user->get('field_user_prefix')->getValue();
    $name_first = $user->get('field_user_first_name')->getValue();
    $name_last = $user->get('field_user_last_name')->getValue();
    $name_suffix = $user->get('field_user_suffix')->getValue();

    $name_display = '';

    // Add trailing space if prefix is present.
    if ($name_prefix[0]['value'] != '') {
      $name_display .= $name_prefix[0]['value'] .' ';
    }
    // Add space between first and last names.
    if ($name_first[0]['value'] != '' && $name_last[0]['value'] != '') {
      $name_display .= $name_first[0]['value'] .' '. $name_last[0]['value'];
    }
    // Add leading space if suffix.
    if ($name_suffix[0]['value'] != '') {
      $name_display .= ' '. $name_suffix[0]['value'];
    }
    // Use username if no name.
    if (trim($name_display) == '') {
      $name_display = $user->getUsername();
    }

    $form['#title'] = $this->t('Contact @name', array('@name' => $name_display));

    $form['recipient']['#access'] = false;
    $form['#cache']['contexts'][] = 'user.permissions';
    return $form;
  }

}
