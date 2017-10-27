<?php

/**
 * @file
 * Contains \Drupal\resume\Form\BatchModuleForm.
 */
namespace Drupal\batch_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class BatchModuleForm extends FormBase {
/**
 * {@inheritdoc}
 */
public function getFormId() {
  return 'batch_module_form';
}
/**
 * Form implementation
 */
public function buildForm(array $form, FormStateInterface $form_state) {
  $form['batch'] = array(
    '#type' => 'select',
    '#title' => 'Choose batch',
    '#options' => array(
      '2' => '2',
      '4' => '4',
      '6' => '6',
      '8' => '8',
      'other' => 'other',
    ),
  );
  $form['selectbox'] = array(
    '#type' => 'select',
    '#title' => t('Publish or Unpublish'),
    '#options' => array(
      NODE_NOT_PUBLISHED => 'Unpublish',
      NODE_PUBLISHED => 'Publish',
    ),
  );
  $form['other'] = array(
    '#type' => 'textfield',
    '#title' => t('Enter your batch'),
    '#states' => array(
      'visible' => array(
        ':input[name="batch"]' => array('value' => 'other'),
      ),
    ),
  );
  $form['submit'] = array(
    '#type' => 'submit',
    '#value' => 'Go',
  );
  return $form;
}
/**
 * form submit handler
 */
public function submitForm(array &$form, FormStateInterface $form_state) {
  if ($form_state -> getValue('batch') == 'other') {
    $options_key = $form_state -> getValue('other');
  }
  else {
    $options_key = $form_state -> getValue('batch');
  }
  $options_check_key = $form_state -> getValue('selectbox');
  if (!empty($options_key)) {
    $num_operations = $options_key;
    $operations = array();
    $context = array();
    for ($i = 0; $i < $num_operations; $i++) {
      $operations[] = array(
        'batch_module_batch_process',
        array(t('(Operation @operation)', array('@operation' => $i)), $options_key, $options_check_key),
      );
    }
    $batch = array(
      'operations' => $operations,
      'finished' => 'batch_module_finished',
      'title' => t('Processing Batch'),
      'init_message' => t('Batch is starting.'),
      'progress_message' => t('Processed @current out of @total.'),
      'error_message' => t('Batch has encountered an error.'),
    );
    batch_set($batch);
  }
}
}
