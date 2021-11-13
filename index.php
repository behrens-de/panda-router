<?php
error_reporting(E_ALL);
require_once __DIR__ . '/PandaRouter.php';
$router = new PandaRouter;

$router->get('/panda-router', null, function(){
    echo 'Start Seite';
});

$router->get('/panda-router/demo/', null, function(){
    echo 'DEMO SEITE';
});

$router->default(null, function(){
    echo 'Error Seite';
});

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
