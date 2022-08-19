<?php

namespace Drupal\imgflip_module\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use GuzzleHttp\Client;


/**
* Configure settings.
*/
class Settings extends ConfigFormBase {
  
  // ! GET FORM ID
  public function getFormId() {
    return 'imgflip_module_settings';
  }
 
  // ! GET TITLE FORM (.routing.yml)
  protected function getEditableConfigNames() {
    return [
      'imgflip_module.settings',
    ];
  }

  // ! BUILD
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('imgflip_module.settings');
    $form['meme_setting'] = array(
      '#type' => 'number',
      '#title' => $this->t('Meme setting'),
      '#description' => $this->t('Number of memes to display on page.'),
      '#default_value' => $config->get('meme_setting'),
    );
    return parent::buildForm($form, $form_state);
  }

  // ! VALIDATE
  public function validateForm(array &$form, FormStateInterface $form_state) {
    // Limit maximum (number_of_memes in API).
    $number_of_memes = 0;
    $client = new Client();
    $response = $client->get('https://api.imgflip.com/get_memes');
    $result = json_decode($response->getBody(), TRUE);
    $number_of_memes = count($result['data']['memes']);

    $number_value = $form_state->getValue('meme_setting');
    if ($number_value >= $number_of_memes && is_numeric($number_value)) {
        $form_state->setErrorByName('meme_setting', 'The value must be a number and cannot be greater than 100.');
    }
  }

  // ! SUBMIT
  public function submitForm(array &$form, FormStateInterface $form_state) {
      // Retrieve the configuration
       $this->configFactory->getEditable('imgflip_module.settings')
      // Set the submitted configuration setting
      ->set('meme_setting', $form_state->getValue('meme_setting'))
      ->save();
 
    parent::submitForm($form, $form_state);
  }

}