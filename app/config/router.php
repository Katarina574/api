<?php

global $di;

use Phalcon\Mvc\Router;
$router = $di->getRouter();
//$router = new Router(false);
// Define your routes here

$router->add('/upload', [
    'controller' => 'Upload',
    'action' => 'upload'
])->via(['POST']);


$router->add('/list', [
    'controller' => 'File',
    'action' => 'list'
])->via(['GET']);

$router->add(
    '/test',
    [
        'controller' => 'test',
        'action'     => 'index',
    ]
);

$router->handle($_SERVER['REQUEST_URI']);

$router->add('/api/hello', [
    'controller' => 'hello',
    'action'     => 'index',
])->setName('hello');
