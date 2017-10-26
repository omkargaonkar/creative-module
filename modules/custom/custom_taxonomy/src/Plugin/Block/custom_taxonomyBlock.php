<?php
/**
 * @file
 * Contains \Drupal\custom_taxonomy\Plugin\Block\XaiBlock.
 */
namespace Drupal\custom_taxonomy\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a 'custom_taxonomy' block.
 *
 * @Block(
 *   id = "custom_taxonomy_block",
 *   admin_label = @Translation("Taxonomy block"),
 *   category = @Translation("Custom Taxonomy block example")
 * )
 */
class custom_taxonomyBlock extends BlockBase {
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
   *
   * This method defines form elements for custom block configuration. Standard
   * block configuration fields are added by BlockBase::buildConfigurationForm()
   * (block title and title visibility) and BlockFormController::form() (block
   * visibility settings).
   *
   * @see \Drupal\block\BlockBase::buildConfigurationForm()
   * @see \Drupal\block\BlockFormController::form()
   */
  public function blockForm($form, FormStateInterface $form_state) {

    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();

    // $config = $this->config('custom_taxonomy.settings');
    $vocabulary = \Drupal\taxonomy\Entity\Vocabulary::loadMultiple();
    foreach ($vocabulary as $key => $value) {
      $voca[$value->id()] = $value->label();
    }
    $form['taxonomy_string_text'] = [
      '#type' => 'select',
      '#title' => $this->t('List of current Vocabularies'),
      '#options' => $voca,
      '#default_value' => $config['taxonomy_string_text'] ? $config['taxonomy_string_text'] : '',
    ];
    return $form;
  }

  /**
   * {@inheritdoc}
   *
   * This method processes the blockForm() form fields when the block
   * configuration form is submitted.
   *
   * The blockValidate() method can be used to validate the form submission.
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    // kint($form_state);
    // parent::blockSubmit($form,$form_state);
    // $this->config('custom_taxonomy.settings')
    //       ->set('taxonomy_string_text', $form_state->getValue('taxonomy_string_text'))
    //       ->save();

    parent::blockSubmit($form, $form_state);
    $values = $form_state->getValues();
    $this->configuration['taxonomy_string_text'] = $values['taxonomy_string_text'];

    // $this->config['taxonomy_string']
    //   = $form_state->getValue('taxonomy_string_text');
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $terms = \Drupal\taxonomy\Entity\Term::loadMultiple();
    $display = "<ul>";
    foreach ($terms as $key => $value) {
      $display .= "<li><a href='taxonomy/term/" .$value->id(). "'>" . $value->label()."</a></li>";
    }
    $display .= "</ul>";
    return [
      '#markup' => $this->$display,
    ];
  }
}
