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


