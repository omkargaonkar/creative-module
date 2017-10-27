<?php
/**
 * @file
 * Contains \Drupal\select_list\Form\select_list_form.
 */
namespace Drupal\select_list\Form;;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

class SelectListForm extends FormBase {
  /**
   * {@inheritdoc}
   */
   public function getFormId() {
     return 'select_list_form';
   }
   public function buildForm(array $form, FormStateInterface $form_state) {
      $form['temperature'] = [
      '#title' => $this->t('Select Course'),
      '#type' => 'select',
      '#options' => $this->getYear(),
      '#empty_option' => $this->t('- Select your year -'),
      '#ajax' => [
        'callback' => '::updateCollege',
        'wrapper' => 'college',
      ],
    ];
    $form['college'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'college'],
    ];
    $courses = $form_state->getValue('temperature');
    if (!empty($courses)) {
      $form['college']['year'] = [
        '#type' => 'select',
        '#title' => $this->t('subject'),
        '#options' => $this->getCourseBycollege($courses),
      ];
    }
    $form['actions'] = [
      '#type' => 'actions',
      'submit' => [
        '#type' => 'submit',
        '#value' => $this->t('Refresh List'),
      ],
    ];
    return $form;
  }
  /**
   * Ajax callback for the college course dropdown.
   */
  public function updateCollege(array $form, FormStateInterface $form_state) {
    return $form['college'];
  }

  /**
   * Returns return courses withe the given years.
   */
  protected function getCourseBycollege($courses) {
    return $this->getColors()[$courses]['years'];
  }

  /**
   * Returns a list of subject.
   */
  protected function getYear() {
    return array_map(function ($color_data) {
      return $color_data['name'];
    }, $this->getColors());
  }

  /**
   * Returns an array of subject grouped by years.
   */
  protected function getColors() {
    return [
      'first_year' => [
        'name' => $this->t('FIRST YEAR'),
        'years' => [
          'basicelectronics' => $this->t('Basic Electronics'),
          'digitalsystems' => $this->t('Digital Systems'),
          'objectorientedprogramming' => $this->t('Object Oriented Programming'),
          'mathematicalfoundationofcomputerscience' => $this->t('Mathematical foundation of Computer Science'),
          'appliedmathematics' => $this->t('Applied Mathematics'),
          'icttoolsandsecurity' => $this->t('ICT Tools and Security'),
          'communityservices' => $this->t('Community Services'),
        ],
      ],
      'second_year' => [
        'name' => $this->t('SECOND YEAR'),
        'years' => [
          'communicationengineering' => $this->t('Communication Engineering'),
          'computerorganization' => $this->t('Computer Organization'),
          'datastructures' => $this->t('Data Structures'),
          'probabilitystatisticsandnumerical Analysis' => $this->t('Probability Statistics and Numerical Analysis'),
          'computerperipheralsworkshop' => $this->t('Computer Peripherals Workshop'),
          'economicsforengineers' => $this->t('Economics for Engineers'),
          'dvanceddatastructures' => $this->t('Advanced Data Structures'),
        ],
      ],
      'third_year' => [
        'name' => $this->t('THIRD YEAR'),
        'years' => [
          'theoryofcomputation' => $this->t('Theory of Computation'),
          'databasemanagementsystems' => $this->t('Database Management Systems'),
          'datacommunicationnetworks' => $this->t('Data Communication Networks'),
          'operatingsystems' => $this->t('Operating Systems'),
          'webdesigning' => $this->t('Web designing'),
          'lawforengineers' => $this->t('Law for Engineers'),
          'fractionalcourse' => $this->t('Fractional Course'),
          'datamining' => $this->t('Data Mining'),
        ],
      ],
      'fourth_year' => [
        'name' => $this->t('FOURTH YEAR'),
        'years' => [
          'softwareengineering' => $this->t('Software Engineering'),
          'designandanalysis of Algorithms' => $this->t('Design and Analysis of Algorithms'),
          'nettechnologies' => $this->t('.net Technologies'),
          'javatechnologies' => $this->t('Java Technologies'),
          'objectivecprogramming' => $this->t('Objective C Programming'),
          'embeddedcprogramming' => $this->t('Embedded C Programming'),
          'mobileapplicationsdevelopment Technologies' => $this->t('Mobile Applications Development Technologies'),
          'advancedcomputernetworks' => $this->t('Advanced Computer Networks'),
        ],
      ],
    ];
  }
  /**
   * {@inheritdoc}
   */
   public function submitForm(array &$form, FormStateInterface $form_state) {

   }

}
