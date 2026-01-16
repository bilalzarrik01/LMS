<?php

namespace App\Core;

use PDO;

class Database
{
    private static $instance = null;
    private $connection;

    private function __construct()
    {
        $this->connection = new PDO(
            'mysql:host=localhost;dbname=lms;charset=utf8mb4',
            'root',
            '',
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]
        );
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    private function __clone() {}
}