<?php

    namespace app ;

 
 class Router {
    private static array $routes = [];

    private static $router ;

    private function __construct() {

    }

    public static function getRouter() : router {
        if (!isset(self::$router)) {
           self ::$router = new Router();
        }
        return self::$router;
    }
    
        private function register(string $route , string $method , array|callable $action)
    {
        $route = trim($route , '/');
        
        self::$routes[$method][$route] = $action ;
    }
    public function get(string $route , array|callable $action  ) {

        $this->register ($route, 'GET' ,$action);
    }
    public function post( string $route , array|callable $action){

          $this->register ($route, 'POST' ,$action);
           }
    public function put(string $route, array|callable $action)
    {
        $this->register($route, 'PUT', $action);
    }
    public function delete(string $route, array|callable $action)
    {
        $this->register($route, 'DELETE', $action);
    }
 } 