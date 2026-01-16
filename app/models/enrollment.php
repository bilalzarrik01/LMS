<?php

namespace App\Models;

use App\Core\Database;
use PDO;
use PDOException;

class Enrollment
{
    private static function getDb()
    {
        return Database::getInstance()->getConnection();
    }

    public static function create(int $studentId, int $courseId): bool
    {
        try {
            $db = self::getDb();
            $sql = "INSERT INTO enrollments (student_id, course_id, enrollment_date) 
                    VALUES (:student_id, :course_id, NOW())";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':student_id' => $studentId,
                ':course_id' => $courseId
            ]);
            
            return true;
        } catch (PDOException $e) {
            error_log("Enrollment Create Error: " . $e->getMessage());
            return false;
        }
    }

    public static function isEnrolled(int $studentId, int $courseId): bool
    {
        try {
            $db = self::getDb();
            $sql = "SELECT COUNT(*) FROM enrollments 
                    WHERE student_id = :student_id AND course_id = :course_id";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':student_id' => $studentId,
                ':course_id' => $courseId
            ]);
            
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Enrollment IsEnrolled Error: " . $e->getMessage());
            return false;
        }
    }

    public static function getStudentCourses(int $studentId): array
    {
        try {
            $db = self::getDb();
            $sql = "SELECT c.id, c.title, c.description, e.enrollment_date
                    FROM courses c
                    INNER JOIN enrollments e ON c.id = e.course_id
                    WHERE e.student_id = :student_id
                    ORDER BY e.enrollment_date DESC";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([':student_id' => $studentId]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Enrollment GetStudentCourses Error: " . $e->getMessage());
            return [];
        }
    }

    public static function getCourseStudents(int $courseId): array
    {
        try {
            $db = self::getDb();
            $sql = "SELECT s.id, s.name, s.email, e.enrollment_date
                    FROM students s
                    INNER JOIN enrollments e ON s.id = e.student_id
                    WHERE e.course_id = :course_id
                    ORDER BY e.enrollment_date DESC";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([':course_id' => $courseId]);
            
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Enrollment GetCourseStudents Error: " . $e->getMessage());
            return [];
        }
    }

    public static function delete(int $studentId, int $courseId): bool
    {
        try {
            $db = self::getDb();
            $sql = "DELETE FROM enrollments 
                    WHERE student_id = :student_id AND course_id = :course_id";
            
            $stmt = $db->prepare($sql);
            $stmt->execute([
                ':student_id' => $studentId,
                ':course_id' => $courseId
            ]);
            
            return true;
        } catch (PDOException $e) {
            error_log("Enrollment Delete Error: " . $e->getMessage());
            return false;
        }
    }
}
