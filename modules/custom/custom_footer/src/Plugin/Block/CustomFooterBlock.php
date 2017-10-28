<?php

namespace Drupal\custom_footer\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "CustomfooterBlock",
 *   admin_label = @Translation("Custom Footer"),
 *   category = @Translation("Custom Footer"),
 * )
 */
class CustomFooterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::config('custom_footer.settings');
    return array(
      '#markup' => $config->get('siteinfo_footer_setting'),
    );

  }

}
