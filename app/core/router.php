<?php

namespace app\core;

class Router {
    private static array $routes = [];
    private static $router;

    private function __construct() {}

    public static function getRouter(): Router {
        if (!isset(self::$router)) {
            self::$router = new Router();
        }
        return self::$router;
    }

    private function register(string $route, string $method, array|callable $action) {
        $route = trim($route, '/');
        self::$routes[$method][$route] = $action;
    }

    public function get(string $route, array|callable $action) {
        $this->register($route, 'GET', $action);
    }

    public function post(string $route, array|callable $action) {
        $this->register($route, 'POST', $action);
    }

    public function put(string $route, array|callable $action) {
        $this->register($route, 'PUT', $action);
    }

    public function delete(string $route, array|callable $action) {
        $this->register($route, 'DELETE', $action);
    }

    public function dispatch($uri, $method = null) {
        if (!$method) {
            $method = $_SERVER['REQUEST_METHOD'];
        }

        $uri = trim(parse_url($uri, PHP_URL_PATH), '/');

        if (isset(self::$routes[$method][$uri])) {
            $action = self::$routes[$method][$uri];
            $this->callAction($action);
        } else {
            http_response_code(404);
            echo "404 - Page Not Found";
        }
    }

    private function callAction(array|callable $action) {
        if (is_array($action)) {
            // [ControllerClass, 'method']
            [$controllerClass, $method] = $action;
            $controller = new $controllerClass();
            $controller->$method();
        } elseif (is_callable($action)) {
            call_user_func($action);
        }
    }
}
