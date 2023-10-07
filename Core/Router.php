<?php

namespace Core;

use Core\Middleware\Middleware;

class Router
{
    protected $routes = [];

    public function add($method, $uri, $controller)
    {
        $this->routes[] = [
            'uri' => $uri,
            'controller' => $controller,
            'method' => $method,
            'middleware' => null
        ];

        return $this;
    }

    public function get($uri, $controller)
    {
        return $this->add('GET', $uri, $controller);
    }

    public function post($uri, $controller)
    {
        return $this->add('POST', $uri, $controller);
    }

    public function delete($uri, $controller)
    {
        return $this->add('DELETE', $uri, $controller);
    }

    public function patch($uri, $controller)
    {
        return $this->add('PATCH', $uri, $controller);
    }

    public function put($uri, $controller)
    {
        return $this->add('PUT', $uri, $controller);
    }

    public function only($key)
    {
        $this->routes[array_key_last($this->routes)]['middleware'] = $key;

        return $this;
    }

    public function route($uri, $method)
    {
        foreach ($this->routes as $route) {
            if ($route['uri'] === $uri && $route['method'] === strtoupper($method)) {
                Middleware::resolve($route['middleware']);
    
                // Extract the controller class and method from the route value
                if (strpos($route['controller'], '@') !== false) {
                    [$controllerClass, $controllerMethod] = explode('@', $route['controller']);
                } else {
                    $controllerClass = ltrim($route['controller']);
                    $controllerMethod = strtolower($method);
                }
                
                // Construct the full namespace of the controller class
                $controllerNamespace = 'Http\Controllers';
                if (strpos($controllerClass, '/') !== false) {
                    $controllerNamespace .= '\\' . str_replace('/', '\\', dirname($controllerClass));
                    $controllerClass = basename($controllerClass);
                }
                
                // Load the controller file
                $controllerFile = base_path(str_replace('\\', '/', $controllerNamespace . '/' . $controllerClass) . '.php');
                
                if (!file_exists($controllerFile)) {
                    throw new \Exception("Controller file not found: $controllerFile");
                }
                
                require_once $controllerFile;
      
                // Create a new instance of the controller
                $controllerClass = $controllerNamespace . '\\' . $controllerClass;
                $controller = new $controllerClass;

                // Call the controller method dynamically
                return $controller->$controllerMethod();
            }
        }
    
        $this->abort();
    }

    public function previousUrl()
    {
        return $_SERVER['HTTP_REFERER'];
    }

    protected function abort($code = 404)
    {
        http_response_code($code);

        require base_path("views/{$code}.php");

        die();
    }
}