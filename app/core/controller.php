<?php


class Controller
{
    protected function view(string $path, array $data = [])
    {
        extract($data);
        require "../app/views/$path.php";
    }

    protected function redirect(string $path)
    {
        header("Location: $path");
        exit;
    }

    protected function requireAuth()
    {
        if (!isset($_SESSION['student_id'])) {
            $this->redirect('/login');
        }
    }
    protected function render(){
        
    }
}
