<?php
namespace Drupal\Defaultblock\Plugin\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Block\BlockPluginInterface;
/**
 * Provides a 'CustomBlock' block.
 *
 * @Block(
 *  id = "Footerblock",
 *  admin_label = @Translation("footerblock"),
 * )
 */
class Footerblock extends BlockBase implements BlockPluginInterface {
  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
    $form = parent::blockForm($form, $form_state);
    $config = $this->getConfiguration();
    $form['footer_visibility'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('Who'),
      '#description' => $this->t('Who do you want to say hello to?'),
      '#default_value' => isset($config['name']) ? $config['name'] : '',
    );
    $form['mobile_number'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('your number'),
      '#description' => $this->t('enter your personal mobile number'),
      '#default_value' => isset($config['number']) ? $config['number'] : '',
    );
    $form['address'] = array (
      '#type' => 'textfield',
      '#title' => $this->t('your address'),
      '#description' => $this->t('enter your home town'),
      '#default_value' => isset($config['town']) ? $config['town'] : '',
    );
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
    $this->setConfigurationValue('name', $form_state->getValue('hello_block_name'));
    $this->setConfigurationValue('number', $form_state->getValue('mobile_number'));
    $this->setConfigurationValue('town', $form_state->getValue('address'));
  }
  public function build() {
    $config = $this->getConfiguration();
    if (!empty($config['name'])) {
      $name = $config['name'];
    }
    else {
      $name = $this->t('to no one');
    }
    if (!empty($config['number'])) {
      $number = $config['number'];
    }
    else {
      $number = $this->t('mobile number');
    }
    if (!empty($config['town'])) {
      $town = $config['town'];
    }
    else {
      $town = $this->t("@town");
    }
    return array(
      '#markup' => $this->t('Hi my number is @number!,@name and my address @town',
       array (
         '@number' => $number, '@name' => $name, '@town' => $town,
       )
       ),
    );
  }
}
