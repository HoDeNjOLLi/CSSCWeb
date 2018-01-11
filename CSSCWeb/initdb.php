<?php
require_once __DIR__ . '/vendor/autoload.php';

use App\Model;


$dbConnection = new \PDO('sqlite:' . realpath(dirname(__FILE__)) . '/data/blog.db');
$dbConnection->setAttribute(\PDO::ATTR_ERRMODE,
    \PDO::ERRMODE_EXCEPTION);


$model = new Model($dbConnection);
$model->initDB();

$items = [
    [
        'username' => 'JULIAN',
        'password' => 'geil',
        'credit' => '1'
    ],
    [
        'username' => 'Aaron',
        'password' => 'hallo',
        'credit' => '10000'
    ]
];
foreach ($items as $item) {
    $model->addUser($item);
}
