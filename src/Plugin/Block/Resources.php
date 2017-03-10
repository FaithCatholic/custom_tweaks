<?php

namespace Drupal\custom_tweaks\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Cache\Cache;

/**
 * Provides a 'Resources' block.
 *
 * @Block(
 *  id = "resources",
 *  admin_label = @Translation("Resources"),
 * )
 */
class Resources extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    if ($content = custom_tweaks_views_get_resources('media_resources', ['attachment_1', 'attachment_2', 'attachment_3'])) {
      $build = [];
      $build['resources']['#markup'] = $content;
      return $build;
    }
  }

  public function getCacheTags() {
    // Rebuild block cache on node change.
    if ($node = \Drupal::routeMatch()->getParameter('node')) {
      // If there is node add its cachetag.
      return Cache::mergeTags(parent::getCacheTags(), array('node:' . $node->id()));
    } else {
      // Return default tags.
      return parent::getCacheTags();
    }
  }

  public function getCacheContexts() {
    // Rebuild block cache on every new route.
    // Set context with 'route' context tag when using \Drupal::routeMatch().
    return Cache::mergeContexts(parent::getCacheContexts(), array('route'));
  }

}
