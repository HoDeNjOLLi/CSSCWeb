<?php
/**
 * Created by PhpStorm.
 * User: aaje7965
 * Date: 28/11/17
 * Time: 18:50
 */

use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

$routes = new RouteCollection();


$routes->add('list',
    new Route('/',
        ['_controller' => 'App\WebController::listAction']                      // je nachdem welchen twig wir rendern wollen
    ));

return $routes;
