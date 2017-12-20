<?php
/**
 * Created by PhpStorm.
 * User: aaje7965
 * Date: 28/11/17
 * Time: 18:56
 */
$loader = new \Twig_Loader_Filesystem(realpath(dirname(__FILE__))
    . '/../templates');
$twig = new \Twig_Environment($loader, ['cache' => false, 'debug' => true]);

$dbConnection = new \PDO('sqlite:' . realpath(dirname(__FILE__))
    . '/../data/nameUnserDB.db');                                                                   // Name unserer DB eintragen!

$dbConnection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

$container = [
    'twig' => $twig,
    'dbConnection' => $dbConnection,
];

return $container;
