<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Course
{
    private static function getDb()
    {
        return Database::getInstance()->getConnection();
    }

    public static function getAll(): array
    {
        try {
            $db = self::getDb();
            $sql = "SELECT id, title, description, created_at FROM courses ORDER BY title ASC";
            
            $stmt = $db->query($sql);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Course GetAll Error: " . $e->getMessage());
            return [];
        }
    }

    public static function find(int $id): ?array
    {
        try {
            $db = self::getDb();
            $sql = "SELECT id, title, description, created_at FROM courses WHERE id = :id";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([':id' => $id]);
            
            $course = $stmt->fetch();
            return $course ?: null;
        } catch (PDOException $e) {
            error_log("Course Find Error: " . $e->getMessage());
            return null;
        }
    }

    public static function create(string $title, string $description): bool
    {
        try {
            $db = self::getDb();
            $sql = "INSERT INTO courses (title, description, created_at) 
                    VALUES (:title, :description, NOW())";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':title' => $title,
                ':description' => $description
            ]);
            
            return true;
        } catch (PDOException $e) {
            error_log("Course Create Error: " . $e->getMessage());
            return false;
        }
    }

    public static function getEnrolledStudentsCount(int $courseId): int
    {
        try {
            $db = self::getDb();
            $sql = "SELECT COUNT(*) FROM enrollments WHERE course_id = :course_id";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);
            
            return (int) $stmt->fetchColumn();
        } catch (PDOException $e) {
            error_log("Course GetEnrolledStudentsCount Error: " . $e->getMessage());
            return 0;
        }
    }
}