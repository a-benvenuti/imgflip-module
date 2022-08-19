<?php
namespace Drupal\imgflip_module\Controller;

use GuzzleHttp\Client;

class ImgflipController {

    public function imgflip() {
        
        $memes = [];
        $i = 0;
        $meme_default_value = \Drupal::config('imgflip_module.settings')->get('meme_setting');

        $client = new Client();
        $response = $client->get('https://api.imgflip.com/get_memes');
        $result = json_decode($response->getBody(), TRUE);

        for ($i; $i < $meme_default_value; $i++) {
            $memes[] = $result['data']['memes'][$i];
        }

        return array(
            '#cache' => array('max-age' => 0),
            '#theme' => 'imgflip_module__template',
            '#memes' => $memes,
        );
    }
    public function getCacheMaxAge() {
        return 0;
    }
    
}