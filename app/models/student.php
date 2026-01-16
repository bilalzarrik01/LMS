<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Student
{
    private static function getDb()
    {
        return Database::getInstance()->getConnection();
    }

    public static function create(string $name, string $email, string $password): bool
    {
        try {
            $db = self::getDb();
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            
            $sql = "INSERT INTO students (name, email, password, created_at) 
                    VALUES (:name, :email, :password, NOW())";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $hashedPassword
            ]);
            
            return true;
        } catch (PDOException $e) {
            error_log("Student Create Error: " . $e->getMessage());
            return false;
        }
    }

    public static function exists(string $email): bool
    {
        try {
            $db = self::getDb();
            $sql = "SELECT COUNT(*) FROM students WHERE email = :email";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Student Exists Error: " . $e->getMessage());
            return false;
        }
    }

    public static function authenticate(string $email, string $password): ?array
    {
        try {
            $db = self::getDb();
            $sql = "SELECT id, name, email, password FROM students WHERE email = :email";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([':email' => $email]);
            
            $student = $stmt->fetch();
            
            if ($student && password_verify($password, $student['password'])) {
                unset($student['password']);
                return $student;
            }
            
            return null;
        } catch (PDOException $e) {
            error_log("Student Authenticate Error: " . $e->getMessage());
            return null;
        }
    }

    public static function findById(int $id): ?array
    {
        try {
            $db = self::getDb();
            $sql = "SELECT id, name, email, created_at FROM students WHERE id = :id";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            $student = $stmt->fetch();
            return $student ?: null;
        } catch (PDOException $e) {
            error_log("Student FindById Error: " . $e->getMessage());
            return null;
        }
    }

    public static function getAll(): array
    {
        try {
            $db = self::getDb();
            $sql = "SELECT id, name, email, created_at FROM students ORDER BY name ASC";
            
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Student GetAll Error: " . $e->getMessage());
            return [];
        }
    }
}