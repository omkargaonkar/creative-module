<?php

namespace Drupal\article_mail\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Class ArticleMailForm.
 *
 * @package Drupal\article_mail\Form
 */
class ArticleMailForm extends ConfigFormBase {
  /**
   * {@inheritdoc}
   */
   protected function getEditableConfigNames() {
     return [
       'article_mail.settings',
     ];
   }

   /**
    * {@inheritdoc}
    */
    public function getFormId() {
      return 'article_mail_form';
    }

    /**
     * {@inheritdoc}
     */
     function token_theme() {
       $info['token_tree_link'] = [
         'variables' => [
           'token_types' => [],
           'global_types' => TRUE,
           'click_insert' => TRUE,
           'show_restricted' => FALSE,
           'show_nested' => FALSE,
           'recursion_limit' => 3,
           'text' => NULL,
           'options' => [],
         ],
         'file' => 'token.pages.inc',
       ];
       return $info;
     }

     /**
      * {@inheritdoc}
      */
      public function buildForm(array $form, FormStateInterface $form_state) {
        $config = $this->config('article_mail.settings');
        $form['subject'] = array(
          '#type' => 'textfield',
          '#title' => $this->t('Subject'),
          '#default_value' => $config->get('subject'),
        );
        $form['body'] = array(
          '#type' => 'text_format',
          '#title' => $this->t('Body'),
          '#default_value' => $config->get('body'),
        );

        // Add the token tree UI.
        $form['body']['token_tree'] = array(
          '#theme' => 'token_tree_link',
          '#token_types' => array('user'),
          '#show_restricted' => TRUE,
          '#weight' => 90,
        );
        return parent::buildForm($form, $form_state);
      }

      /**
       * {@inheritdoc}
       */
       public function submitForm(array &$form, FormStateInterface $form_state) {
         parent::submitForm($form, $form_state);
         $mail_body = $form_state->getValue('body');
         $this->config('article_mail.settings')
         ->set('subject', $form_state->getValue('subject'))
         ->set('body', $mail_body['value'])
         ->save();
       }
     }
