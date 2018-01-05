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
$routes->add('/login',
    new Route('/login',
        ['_controller' => 'Form\Controller::showLoginAction']
    ));
$routes->add('/register',
    new Route('/register',
        ['_controller' => 'Form\Controller::showRegisterAction']
    ));
$routes->add('/casesUser',
    new Route('/casesUser',
        ['_controller' => 'App\WebController::showCasesUserAction']
    ));

$routes->add('/Impressum',
    new Route('/Impressum',
        ['_controller' => 'App\WebController::ImpressumAction']
    ));
$routes->add('/timeline',
    new Route('/timeline',
        ['_controller' => 'App\WebController::timelineAction']
    ));

return $routes;
