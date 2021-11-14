<?php
error_reporting(E_ALL);
require_once __DIR__ . '/PandaRouter.php';
require_once __DIR__ . '/DemoController.php';

$controller = new DemoController;



$demo = function () {
    echo 'Demo';
};

$error = function () {
    echo 'Error';
};

# ROUTING 
$router = new PandaRouter;
$router->setPrefixRoute('/panda-router');

# ROUTS WITHOUT CONTROLLER CLASSES
$router->get('/', $controller, 'home',['test'=>'test']);
$router->get('/demo/', null, $demo);
$router->default(null, $error);

# STARTS THE ROUTER 
$router->run();

// #Static GET-Route
// $router->get('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

// #Dynamic GET-Route
// $router->get('DOMAIN/route/:param1,param2,...', 'object | class', 'method',['optionalParams']);

// #POST-Route
// $router->post('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

// #PUT-Route
// $router->put('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

// #PATCH-Route
// $router->patch('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

// #DELETE-Route
// $router->delete('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

// #DEFAULT-Route (404-ROUTE)
// $router->default('object | class', 'method');