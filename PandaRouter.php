<?php

class PandaRouter
{
    private $defaultRoute;
    private $routes = [];

    /**
     * @return string - the path of the request url and removes the last backslash
     */
    private function httpRequest(): string
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI']);
        $requestPath = $requestUri['path'];
        return rtrim($requestPath, '/');
    }

    /**
     * @return array - an array with the properties important for the route
     */
    private function setRoute($path, $controller, $action, $params = []): array
    {
        return [
            'path' => $path,
            'controller' => $controller,
            'action' => $action,
            'params' => $params,

        ];
    }

    /**
     * @return - an array with the routes depending on the method of the $_SERVER["REQUEST_METHOD"] 
     */
    private function selectRoutes(): array
    {
        $routes = [];
        switch ($_SERVER["REQUEST_METHOD"]) {
            case 'GET':
                $routes = $this->routes['GET'];
                break;
            case 'POST':
                $routes = $this->routes['POST'];
                break;
            case 'PUT':
                $routes = $this->routes['PUT'];
                break;
            case 'PATCH':
                $routes = $this->routes['PATCH'];
                break;
            case 'DELETE':
                $routes = $this->routes['DELETE'];
                break;
            default:
                $routes = [];
                break;
        }
        return $routes;
    }

    /**
     * set the route which will be shown if no route is found (404)
     */
    public function default($controller, $action): void
    {
        $this->defaultRoute = $this->setRoute(null, $controller, $action, null);
    }

    /**
     * set the route to be called via the GET method
     */
    public function get($path, $controller, $action, $params = []): void
    {
        $this->routes['GET'][$path] = $this->setRoute($path, $controller, $action, $params);
    }
    /**
     * set the route to be called via the POST method
     */
    public function post($path, $controller, $action, $params = [])
    {
        $this->routes['POST'][$path] = $this->setRoute($path, $controller, $action, $params);
    }

    /**
     * set the route to be called via the PUT method
     */
    public function put($path, $controller, $action, $params = [])
    {
        $this->routes['PUT'][$path] = $this->setRoute($path, $controller, $action, $params);
    }

    /**
     * set the route to be called via the PATCH method
     */
    public function patch($path, $controller, $action, $params = [])
    {
        $this->routes['PATCH'][$path] = $this->setRoute($path, $controller, $action, $params);
    }

    /**
     * set the route to be called via the DELETE method
     */
    public function delete($path, $controller, $action, $params = [])
    {
        $this->routes['DELETE'][$path] = $this->setRoute($path, $controller, $action, $params);
    }
    /**
     * fetches the default route
     */
    private function getDefault()
    {
        // ERROR 404
        $default = $this->defaultRoute;
        call_user_func([$default["controller"], $default["action"]]);
    }

    /**
     * Checks for validity of route and request 
     * This checks whether the route and the request have the same number of parameters.
     * --------------------------------
     * @param string $request - the request uri 
     * @param string $params - are the parameters to be checked by the path (route)
     * @param string $sub - the part that must be removed from the request string to start the comparison
     * 
     * @return bool
     */

    private function validateParams($request, $params, $sub): bool
    {
        $request = str_replace($sub, '', $request);
        $requestParams = explode('/', $request);
        $pathParams  = explode(',', $params);

        $countRP = count($requestParams);
        $countPP = count($pathParams);

        return $countRP === $countPP;
    }

    /**
     * 
     */
    private function getParams($request, $params, $sub): array
    {
        $request = str_replace($sub, '', $request);
        $requestParams = explode('/', $request);
        $pathParams  = explode(',', $params);

        $params = [];
        foreach ($pathParams as $key => $pParams) {
            $params[$pParams] = $requestParams[$key];
        }
        return $params;
    }

    /**
     * This method starts the routing process
     */
    public function run(): void
    {
        $request = $this->httpRequest();
        $routes = $this->selectRoutes();

        $match = false;
        $selectedRoute = [];

        foreach ($routes as $route) {

            $cleanPath = rtrim($route['path'], '/');

            #serach for static routes
            if ($cleanPath === $request) {
                #---STATIC MATCH---#
                $match = true;
                $selectedRoute['path'] = $route['path'];
                $selectedRoute['controller'] = $route['controller'];
                $selectedRoute['action'] = $route['action'];
                $selectedRoute['params'] = $route['params'];
                break;
            }

            #search for dynamic routes
            if ((strpos($cleanPath, ':') !== false)) {

                $path = explode(':', $cleanPath);
                $dynamicPath = $path[0];
                $dynamicParams = $path[1];
                $isValid = $this->validateParams($request, $dynamicParams, $dynamicPath);
                $validatedParams = $this->getParams($request, $dynamicParams, $dynamicPath);

                $dynamicPath = rtrim($dynamicPath, '/');
                $regEx = "~^$dynamicPath?[a-z,A-Z,/,-,_,\.,0-9]{0,200}$~i";

                if (preg_match($regEx, $request) && $isValid) {
                    $match = true;
                    #---DYNAMIC MATCH---#
                    $selectedRoute['path'] = $route['path'];
                    $selectedRoute['controller'] = $route['controller'];
                    $selectedRoute['action'] = $route['action'];
                    $selectedRoute['params'] = $validatedParams;
                    break;
                }
            }
        }

        // Checks if it is a match and a callable function within this configuration in the selected Route
        if ($match && is_callable([$selectedRoute['controller'], $selectedRoute['action']])) {
            #--MATCH--#
            call_user_func_array([$selectedRoute['controller'], $selectedRoute['action']], [$selectedRoute['params']]);
        } else {
            $this->getDefault();
        }
    }
}