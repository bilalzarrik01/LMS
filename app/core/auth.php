<?php

namespace App\Core;

class Auth
{
    public static function check()
    {
        session_start();
        return isset($_SESSION['student_id']);
    }

    public static function student()
    {
        if (self::check()) {
            return [
                'id' => $_SESSION['student_id'],
                'name' => $_SESSION['student_name'] ?? null
            ];
        }
        return null;
    }

    public static function login($studentId, $studentName)
    {
        session_start();
        $_SESSION['student_id'] = $studentId;
        $_SESSION['student_name'] = $studentName;
    }

    public static function logout()
    {
        session_start();
        session_unset();
        session_destroy();
    }
}