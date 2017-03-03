<?php

/**
 * @file
 * Contains \Drupal\custom_tweaks\Routing\RouteSubscriber.
 */

namespace Drupal\custom_tweaks\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Listens to the dynamic route events.
 */
class RouteSubscriber extends RouteSubscriberBase {
  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {
    if ($route = $collection->get('entity.user.contact_form')) {
      $route->setDefault('_controller', '\Drupal\custom_tweaks\Controller\CustomContactController::contactPersonalPage');
    }
  }
}
