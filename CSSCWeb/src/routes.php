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


$routes->add('/',
    new Route('/',
        ['_controller' => 'App\WebController::listAction']
    ));
$routes->add('/form',
    new Route('/form',
        ['_controller' => 'Form\Controller::showFormAction']
    ));

return $routes;
