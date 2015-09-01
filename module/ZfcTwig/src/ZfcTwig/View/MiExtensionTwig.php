<?php

namespace ZfcTwig\View;
 
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;
 
class MiExtensionTwig extends Twig_Extension
{
    public function getFilters() {
        return [new Twig_SimpleFilter('ucfirst', 'ucfirst') ];
    }
    public function getName() {
        return "MiExtensionTwiga";
    }
    public function getFunctions() {
        return [new Twig_SimpleFunction('renderimg', function ($picture, $width = 100, $height = 100) {
            $filename = basename($picture);
            
            return '<img src="' . $filename . '" width="' . $width . '" height="' . $height . '" />';
        }
        , array(
            'is_safe' => array(
                'html'
            )
        )) ];
    }
}