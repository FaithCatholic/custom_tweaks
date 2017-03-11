<?php

namespace Drupal\custom_tweaks\Controller;

use Drupal\Component\Utility\Xss;
use Drupal\user\Controller\UserController as UserControllerBase;
use Drupal\user\UserInterface;

/**
 * Controller routines for user routes.
 */
class UserController extends UserControllerBase {

  /**
   * {@inheritdoc}
   */
  public function userTitle(UserInterface $user = NULL) {
    return $user ? ['#markup' => $user->getDisplayName(), '#allowed_tags' => Xss::getHtmlTagList()] : '';
  }

}
