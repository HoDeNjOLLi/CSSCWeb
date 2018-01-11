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
        ['_controller' => 'App\WebController::showCasesAction'], [], ['_permission' => 'view cases'], '',
        [], ['GET', 'HEAD']
    ));
$routes->add('/cases',
    new Route('/cases',
        ['_controller' => 'App\WebController::showCasesAction'], [], ['_permission' => 'view cases'], '',
        [], ['GET', 'HEAD']
    ));
$routes->add('/login',
    new Route('/login',
        ['_controller' => 'Form\UserController::showLoginAction'], [], [], '',
        [], ['GET', 'HEAD', 'POST']
    ));
$routes->add('/logout',
    new Route('/logout',
        ['_controller' => 'Form\UserController::logoutAction'], [], [], '',
        [], ['GET', 'HEAD', 'POST']
    ));
$routes->add('/register',
    new Route('/register',
        ['_controller' => 'Form\UserController::showRegisterAction']
    ));
$routes->add('/casesUser',
    new Route('/casesUser',
        ['_controller' => 'App\WebController::showCasesUserAction'], [], ['_permission' => 'buy cases'], '',
        [], ['GET', 'HEAD', 'POST']
    ));

$routes->add('/Impressum',
    new Route('/Impressum',
        ['_controller' => 'App\WebController::ImpressumAction']
    ));
$routes->add('/timeline',
    new Route('/timeline',
        ['_controller' => 'App\WebController::timelineAction']
    ));
$routes->add('/account',
    new Route('/account',
        ['_controller' => 'Form\UserController::showAccountAction'], [], ['_permission' => 'buy cases'], '',
        [], ['GET', 'HEAD', 'POST']
    ));

return $routes;
