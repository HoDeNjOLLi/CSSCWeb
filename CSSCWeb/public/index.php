<?php
/**
 * Created by PhpStorm.
 * User: Julian und Aaron
 * Date: 04.12.2017
 * Time: 19:23
 */

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel;

$container = include __DIR__ . '/../src/container.php';
$routes = include __DIR__ . '/../src/routes.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();
$uri = $request->getPathInfo();

$context = new RequestContext();
$context->fromRequest($request);
$matcher = new UrlMatcher($routes, $context);

// Get current user
$session = getSession($request);
$user = App\User::getFromSession($container, $session);
// Add user to request
$request->attributes->set('user', $user);

//// Handle flash message
//$flash = $session->get('flash');
//$request->attributes->set('flash', $flash);
//$session->remove('flash');


try {
    $parameters = $matcher->match($uri);
    $response = handleRequest($request, $parameters, $container);
} catch (Routing\Exception\ResourceNotFoundException $e) {
    $response = new Response('Not Found', 404);
}

//// Check permission
//$options = $routes->get($parameters['_route'])->getOptions();
//if (isset($options['_permission'])) {
//    if (!$user->hasPermission($options['_permission'])) {
//        throw new HttpKernel\Exception\AccessDeniedHttpException;
//    }
//}

function handleRequest($request, $parameters, $container)
{
    if (!is_null($parameters)) {
// Add parameters from URI to request
        foreach ($parameters as $key => $value) {
            $request->attributes->set($key, $value);
        }
        $controllerMap = preg_split('/::/', $parameters['_controller']);
        $controllerClass = $controllerMap[0];
        $action = isset($controllerMap[1]) ? $controllerMap[1] : null;
        $response = callController($request, $container, $controllerClass, $action);
    } else {
        throw new \Exception('No parameters found.');
    }
    return $response;
}

function callController($request, $container, $controllerClass, $action)
{
    if (class_exists($controllerClass) && $action) {
        $controller = new $controllerClass($container);
        if (method_exists($controller, $action)) {
            $response = $controller->$action($request);
            return $response;
        } else {
            throw new \Exception('Action not found.');
        }
    } else {
        throw new \Exception('Controller not found.');
    }
}

dump($session);

$response->send();

function getSession(Request $request)
{
    $session = $request->getSession();
    if (!$request->getSession()) {
        $session = new Session();
        $request->setSession($session);
    }
    $session->start();
    return $session;
}