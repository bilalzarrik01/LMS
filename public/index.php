<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Core\Router;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$router = new Router();

// Public routes
$router->get('/', ['App\Controllers\StudentsController', 'login']);
$router->get('/login', ['App\Controllers\StudentsController', 'login']);
$router->post('/login', ['App\Controllers\StudentsController', 'handleLogin']);
$router->get('/register', ['App\Controllers\StudentsController', 'register']);
$router->post('/register', ['App\Controllers\StudentsController', 'handleRegister']);

// Protected routes
$router->get('/student/dashboard', ['App\Controllers\StudentsController', 'dashboard']);
$router->get('/student/course/{id}', ['App\Controllers\StudentsController', 'course']);
$router->get('/student/enroll/{id}', ['App\Controllers\StudentsController', 'enroll']);
$router->get('/logout', ['App\Controllers\StudentsController', 'logout']);

// Dispatch
$router->dispatch($_SERVER['REQUEST_URI']);