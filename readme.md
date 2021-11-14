# Panda Router

## Description

the panda-router is a small alternative PHP router that can be used for small projects. With this router you can use different HTTP methods. For example GET and POST but also PUT, PATCH and DELETE. Furthermore a 404 (default) route can be created.

The routes work with simple functions as well as with functions that are in objects.

## How to integrate the panda router in your Project

### First Step

include and modify the htaccess file

```
RewriteEngine On
RewriteBase /
RewriteRule ^index\.php$ - [L]
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule . /projectFolder/index.php [L]
```

### Secound Step

add the class PandaRouter (PandaRouter.php) to your project and then include it in your index page

```php
#index.php (example)
require_once __DIR__ . '/PandaRouter.php';
$router = new PandaRouter;

```

### Third Step

create the routes

#### OPTION A

Routes by functions

```php
#index.php (example)
require_once __DIR__ . '/PandaRouter.php';
$router = new PandaRouter;

$demo = function () {
    echo 'Demo';
};

$error = function () {
    echo 'Error';
};

$router->get('/demo/', null, $demo);
$router->default(null, $error);
```

#### OPTION B

Routes by functions in Methods

```php
#index.php (example)
require_once __DIR__ . '/PandaRouter.php';
require_once __DIR__ . '/DemoController.php';

$controller = new DemoController;
#Static GET-Route
$router->get('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

#Dynamic GET-Route
$router->get('DOMAIN/route/:param1,param2,...', 'object | class', 'method',['optionalParams']);

#POST-Route
$router->post('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

#PUT-Route
$router->put('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

#PATCH-Route
$router->patch('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

#DELETE-Route
$router->delete('DOMAIN/route/', 'object | class', 'method',['optionalParams']);

#DEFAULT-Route (404-ROUTE)
$router->default('object | class', 'method');

```
### Last Step
Start the Router

```php
#index.php (example)
... OPTION A OR OPTION B ...

$router->run();
```

---
created by JP Behrens 
---
If you have any suggestions for improvement or ideas for extension. please let me know. 

[hallo@jpbehrens.de](mailto:hallo@jpbehrens.de)