<?php
session_start();


require_once '../app/core/Router.php';
require_once '../app/controllers/StudentController.php';

use app\core\Router;

$router = Router::getRouter();

// Pages publiques
$router->get('/login', [StudentController::class, 'login']);
$router->post('/login', [StudentController::class, 'handleLogin']);
$router->get('/register', [StudentController::class, 'register']);
$router->post('/register', [StudentController::class, 'handleRegister']);


$router->get('/student/dashboard', [StudentController::class, 'dashboard']);

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
