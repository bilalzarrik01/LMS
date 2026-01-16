<?php
namespace App\Core;
class Router
{
    private $routes = [];

    public function get($path, $callback)
    {
        $this->routes['GET'][$path] = $callback;
    }

    public function post($path, $callback)
    {
        $this->routes['POST'][$path] = $callback;
    }

    public function dispatch($uri)
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($uri, PHP_URL_PATH);

        // Remove base path
        $basePath = '/lms/public';
        if (strpos($uri, $basePath) === 0) {
            $uri = substr($uri, strlen($basePath));
        }

        if ($uri === '' || $uri === false) {
            $uri = '/';
        }

        foreach ($this->routes[$method] ?? [] as $route => $callback) {
            // Routes with parameters {id}
            $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '([^/]+)', $route);
            $pattern = "@^" . $pattern . "$@D";

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                if (is_array($callback)) {
                    $controller = new $callback[0]();
                    $methodName = $callback[1];
                    return call_user_func_array([$controller, $methodName], $matches);
                }

                return call_user_func_array($callback, $matches);
            }
        }

        http_response_code(404);
        echo "404 Not Found";
    }}