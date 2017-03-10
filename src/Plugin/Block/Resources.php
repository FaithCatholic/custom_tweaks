<?php

namespace Drupal\custom_tweaks\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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
    $build = [];
    $build['resources']['#markup'] = $this->_getViewsContent();
    return $build;
  }

  protected function _getViewsContent() {
    $documents = \Drupal\views\Views::getView('media_resources');
    $documents->setDisplay('attachment_1');
    $documents = drupal_render($documents->render());

    $links = \Drupal\views\Views::getView('media_resources');
    $links->setDisplay('attachment_2');
    $links = drupal_render($links->render());

    $videos = \Drupal\views\Views::getView('media_resources');
    $videos->setDisplay('attachment_3');
    $videos = drupal_render($videos->render());

    $output = $documents . $links . $videos;
    return $output;
  }
}
