<?php

namespace Application\Extension;
 
use Twig_Extension;
use Twig_SimpleFilter;
use Twig_SimpleFunction;
 
class MiExtensionTwig extends Twig_Extension
{

    public function getName() {
        return "MiExtensionTwig";
    }

    public function getFunctions() {

        return array(
            new Twig_SimpleFunction('htmlImagen', [$this, 'getImagen']
            , array(
                'is_safe' => array(
                    'html'
                )
            ))

        );        

    }

    public function getFilters(){        

        return array(
            new Twig_SimpleFilter('formatea', [$this, 'formatea']),
            new Twig_SimpleFilter('formateaNumero', [$this, 'formateaNumero']),

        );

    }

    public function getImagen($imagen) {

        $filename = basename($imagen);
        return '<img src="' . $imagen . '" class="img-responsive" />';

    }

    public function formatea($texto){

        return(ucfirst(strtolower($texto)));

    }

    public function formateaNumero($numero){

        return(number_format( $numero , '2' , "," ,  "."));

    }

}