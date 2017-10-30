<?php
/**
 * @file
 * Contains \Drupal\custom_taxonomy\Plugin\Block\CustomTaxonomyBlock.
 */
namespace Drupal\custom_taxonomy\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;

/**
 * Provides a 'custom_taxonomy' block.
 *
 * @Block(
 *   id = "custom_taxonomy_block",
 *   admin_label = @Translation("Taxonomy block"),
 *   category = @Translation("Custom Taxonomy block example")
 * )
 */
class CustomTaxonomyBlock extends BlockBase implements BlockPluginInterface {
  /**
   * {@inheritdoc}
   *
   * This method sets the block default configuration. This configuration
   * determines the block's behavior when a block is initially placed in a
   * region. Default values for the block configuration form should be added to
   * the configuration array. System default configurations are assembled in
   * BlockBase::__construct() e.g. cache setting and block title visibility.
   *
   * @see \Drupal\block\BlockBase::__construct()
   */
  public function defaultConfiguration() {
    return [
      'taxonomy_string' => '',
    ];
  }
  /**
   * {@inheritdoc}
   * @see \Drupal\block\BlockBase::buildConfigurationForm()
   * @see \Drupal\block\BlockFormController::form()
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    $vocabulary = \Drupal\taxonomy\Entity\Vocabulary::loadMultiple();
    foreach ($vocabulary as $key => $value) {
      $voca[$value->id()] = $value->label();
    }
    $form['taxo'] = array (
      '#type' => 'select',
      '#title' => $this->t('List of current Vocabularies'),
      '#empty_option' => $this->t('- Select a vocabulary -'),
      '#options' => $voca,
      '#default_value' => $this->configuration['taxo'] ? $this->configuration['taxo'] : '',
    );
    return $form;
  }

  /**
   * {@inheritdoc}
   *
   * This method processes the blockForm() form fields when the block
   * configuration form is submitted.
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('taxo', $form_state->getValue('taxo'));
  }

  public function build() {
    $config = $this->getConfiguration();
    $taxo = $config['taxo'];
    $terms = \Drupal::entityTypeManager()->getStorage('taxonomy_term')->loadTree($taxo,0,NULL,TRUE);
    $term_item = array ();
    foreach ($terms as $term) {
      $term_item[] = array (
        '#markup' => \Drupal::l($term->toLink()->getText(), $term->toUrl()),
      );
    }
    $item_list = array (
      '#theme' => 'item_list',
      '#title' => $taxo. t(' Terms'),
      '#empty' => t('No Terms.'),
      '#items' => $term_item,
    );
    $message = \Drupal::service('renderer')->render($item_list);
    return [
      '#markup' => $message,
    ];
  }
}
