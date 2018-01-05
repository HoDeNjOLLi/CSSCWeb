<?php
require_once __DIR__ . '/vendor/autoload.php';

$dbConnection = new \PDO('sqlite:' . realpath(dirname(__FILE__)) .
    '/data/blog.db');
$dbConnection->setAttribute(\PDO::ATTR_ERRMODE,
    \PDO::ERRMODE_EXCEPTION);
$model = new App\Model($dbConnection);
$model->initDB();
$items = [
    [
        'title' => 'Tag 1:',
        'publishDate' => '2017-01-01',
        'blogText' => 'Sylvester war Super! :)'
    ],
    [
        'title' => 'Tag 2:',
        'publishDate' => '2017-01-02',
        'blogText' => 'Geburtstag vom Kollegen ist ausgeartet.'
    ],
    [
        'title' => 'Tag 3:',
        'publishDate' => '2017-01-03',
        'blogText' => 'Ausnüchtern...'
    ]
    ,
    [
        'title' => 'Tag 4:',
        'publishDate' => '2017-01-04',
        'blogText' => 'Gute Jahresvorsätze machen :P'
    ]
];
foreach ($items as $item) {
    $model->addItem($item);
}