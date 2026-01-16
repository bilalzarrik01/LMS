<?php

namespace App\Core;

abstract class Controller
{
    protected function view(string $path, array $data = [])
    {
        extract($data);
        $viewPath = __DIR__ . "/../views/$path.php";
        
        if (!file_exists($viewPath)) {
            throw new \Exception("View not found: $viewPath");
        }
        
        require $viewPath;
    }
    
    protected function redirect(string $path)
    {
        $fullPath = '/lms/public' . $path;
        header("Location: $fullPath");
        exit;
    }
    
    protected function requireAuth()
    {
        if (!isset($_SESSION['student_id'])) {
            $this->redirect('/login');
        }
    }
    
    protected function validateCsrfToken()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['csrf_token'] ?? '';
            $sessionToken = $_SESSION['csrf_token'] ?? '';
            
            if (empty($token) || empty($sessionToken) || !hash_equals($sessionToken, $token)) {
                http_response_code(403);
                die('CSRF token validation failed');
            }
        }
    }
    
    protected function generateCsrfToken(): string
    {
        // Only generate a new token if one doesn't exist
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }
    
    protected function sanitize($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }
        return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
    }
    
    protected function json($data, int $statusCode = 200)
    {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }
}