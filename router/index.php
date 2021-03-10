<?php

declare(strict_types=1);

require_once __DIR__ . '/router/main.php';

use SOL5\Router;
use SOL5\Request;

$router = new Router();

$router->get('/', function (Request $request) {
  return $request->data();
});

$router->get('/message', function (Request $request) {
  return [
    'id'  => 400,
    'message' => 'The server says hello'
  ];
});

$router->get('/news', function (Request $request) {
  return [
    'item_1'  => 'lorem ipsum',
    'item_2'  => 'delos mae',
  ];
});

$router->run();