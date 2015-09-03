## Extendiendo Twig en Zend Framework 2

Descargamos una copia del [ZendSkeletonApplication](https://github.com/zendframework/ZendSkeletonApplication) y el modulo [ZfcTwig](https://github.com/ZF-Commons/ZfcTwig), configuramos nuestro composer.json de la siguiente manera y procedemos a instalarlo :
```
{
    "name": "zendframework/skeleton-application",
    "description": "Skeleton Application for ZF2",
    "license": "BSD-3-Clause",
    "keywords": [
        "framework",
        "zf2"
    ],
    "homepage": "http://framework.zend.com/",
    "require": {
        "php": ">=5.5",
        "zendframework/zendframework": "~2.5",
        "zf-commons/zfc-twig": "dev-master"        
    }
}
```

Desde el terminal ejecutamos:
```
composer.phar install
```

Damos de alta el módulo **ZfcTwig** en el fichero application.config.php:

```
    'modules' => array(
        'Application',
        'ZfcTwig',        
    ),

```
Una vez tenemos nuestra copia de **ZendSkeletonApplication** con el modulo **Zfctwig** funcionando en nuestro servidor, vamos a proceder a crear nuestra clase para extender la funcionalidad de twig en nuestro proyecto web. Para ello creamos una carpeta llamada **Extension** dentro de nuestro modulo de trabajo, en este caso la ruta sería **Application\src\Application\Extension** . Dentro de esta carpeta procedemos a crear la clase que extenderá Twig a la que he llamado **MiExtensionTwig**, este es el código:

```
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
```
Como podemos ver la clase que acabamos de crear extiende la clase del módulo de twig **Twig_Extension**. Según sea el caso de la funcionalidad que queramos extender, usaremos una clase diferente, en este caso hacemos uso de las clases **Twig_SimpleFilter** y **Twig_SimpleFunction** puesto que queremos añadir funciones y filtros nuevos a nuestro proyecto. Para darlos de alta necesitamos hacer uso de las funciones **getFunctions** y **getFilters** en nuestra clase, cada una de estas funciones devuelve un array donde cada valor representa una funcionalidad concreta. En filtros hemos dado de alta dos filtros nuevos 'formatea' y 'formateaNumero' además de la funcion 'htmlImagen' cada uno de estos tiene su propia funcion donde se detalla la lógica con la que opera. 

Con nuestra clase ya creada, solo nos queda enlazar esta clase en nuestro proyecto a través del module.config.php.

```
    'zfctwig' => array(
        'extensions' => array(
            'Application\Extension\MiExtensionTwig',

        )
    )
```
Con todo configurado ya solo nos queda hacer uso en nuestras vistas de la nueva funcionalidad y listo.

```
<div class="row">

    <div class="col-md-3">
        <h3>Extensión de función</h3>
        {{ htmlImagen('img/smiley.jpg') }}
        
    </div>

    <div class="col-md-9">
        <h3>Extensión de filtro</h3>
        <p>{{ 'Formateando texto usando filtros en twig'|formatea }}</p>
        <p>Estos números también</p>
        <ul>
        {% for numero in numeros %}
            <li>{{ numero|formateaNumero }}</li>
        {% endfor %}
        </ul>
    </div>

</div>
```
