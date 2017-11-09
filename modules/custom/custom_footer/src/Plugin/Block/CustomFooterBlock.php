<?php

namespace Drupal\custom_footer\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a 'Hello' Block.
 *
 * @Block(
 *   id = "CustomfooterBlock",
 *   admin_label = @Translation("Powered by Creative"),
 *   category = @Translation("Custom Footer"),
 * )
 */
class CustomFooterBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = \Drupal::config('custom_footer.settings');
    $footer_value = $config->get('siteinfo_footer_setting');
    return array(
      '#markup' => check_markup($footer_value['value'], $footer_value['format']),
      //'#markup' => $footer_value['value'],
    );
  }

}
