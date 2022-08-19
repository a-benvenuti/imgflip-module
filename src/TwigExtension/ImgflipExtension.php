<?php

namespace Drupal\imgflip_module\TwigExtension;


class ImgflipExtension extends \Twig_Extension {

    public function getName() {
        return 'imgflip_module.ImgflipExtension';
    }

    public function getFilters() {
        return [
            new \Twig_SimpleFilter('title_meme', [$this, 'title_meme']),
        ];
    }

    public function title_meme($name) {
        return "Meme: " . $name;
    }
    
}
