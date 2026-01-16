<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Student;
use App\Models\Course;
use App\Models\Enrollment;

class StudentsController extends Controller
{
    public function home()
    {
        if (isset($_SESSION['student_id'])) {
            $this->redirect('/student/dashboard');
        }
        
        $data = [
            'title' => 'Thoth LMS - Home'
        ];
        
        $this->view('student/home', $data);
    }

    public function login()
    {
        if (isset($_SESSION['student_id'])) {
            $this->redirect('/student/dashboard');
        }
        
        $data = [
            'title' => 'Login',
            'csrf_token' => $this->generateCsrfToken(),
            'success' => isset($_GET['registered']) ? 'Registration successful! Please login.' : null
        ];
        
        $this->view('student/login', $data);
    }

    public function register()
    {
        if (isset($_SESSION['student_id'])) {
            $this->redirect('/student/dashboard');
            return;
        }
        
        $data = [
            'title' => 'Register',
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        $this->view('student/register', $data);
    }

    public function handleRegister()
    {
        $this->validateCsrfToken();
        
        $name = $this->sanitize($_POST['name'] ?? '');
        $email = $this->sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        $errors = [];
        
        if (empty($name) || strlen($name) < 2) {
            $errors[] = "Name must be at least 2 characters";
        }
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Valid email is required";
        }
        
        if (empty($password) || strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters";
        }
        
        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match";
        }
        
        if (Student::exists($email)) {
            $errors[] = "Email already registered";
        }

        if (!empty($errors)) {
            $data = [
                'errors' => $errors,
                'old' => compact('name', 'email'),
                'csrf_token' => $this->generateCsrfToken(),
                'title' => 'Register'
            ];
            $this->view('student/register', $data);
            return;
        }

        $success = Student::create($name, $email, $password);
        
        if ($success) {
            // Regenerate session ID to prevent session fixation
            session_regenerate_id(true);
            $this->redirect('/login?registered=1');
        } else {
            $data = [
                'errors' => ['Registration failed. Please try again.'],
                'old' => compact('name', 'email'),
                'csrf_token' => $this->generateCsrfToken(),
                'title' => 'Register'
            ];
            $this->view('student/register', $data);
        }
    }

    public function handleLogin()
    {
        $this->validateCsrfToken();
        
        $email = $this->sanitize($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            $data = [
                'error' => 'Email and password are required',
                'csrf_token' => $this->generateCsrfToken(),
                'title' => 'Login'
            ];
            $this->view('student/login', $data);
            return;
        }

        $student = Student::authenticate($email, $password);

        if (!$student) {
            $data = [
                'error' => 'Invalid email or password',
                'csrf_token' => $this->generateCsrfToken(),
                'title' => 'Login'
            ];
            $this->view('student/login', $data);
            return;
        }

        session_regenerate_id(true);
        
        $_SESSION['student_id'] = $student['id'];
        $_SESSION['student_name'] = $student['name'];
        $_SESSION['student_email'] = $student['email'];
        
        $this->redirect('/student/dashboard');
    }

    public function dashboard()
    {
        $this->requireAuth();
        
        $studentId = $_SESSION['student_id'];
        $availableCourses = Course::getAll();
        $enrolledCourses = Enrollment::getStudentCourses($studentId);
        
        $enrolledIds = array_column($enrolledCourses, 'id');
        
        // Get flash messages
        $success = $_SESSION['success'] ?? null;
        $error = $_SESSION['error'] ?? null;
        $info = $_SESSION['info'] ?? null;
        
        // Clear flash messages
        unset($_SESSION['success'], $_SESSION['error'], $_SESSION['info']);
        
        $data = [
            'title' => 'Dashboard',
            'studentName' => $_SESSION['student_name'],
            'availableCourses' => $availableCourses,
            'enrolledCourses' => $enrolledCourses,
            'enrolledIds' => $enrolledIds,
            'csrf_token' => $this->generateCsrfToken(),
            'success' => $success,
            'error' => $error,
            'info' => $info
        ];
        
        $this->view('student/dashboard', $data);
    }

    public function course($id)
    {
        $this->requireAuth();
        
        if (!is_numeric($id)) {
            $this->redirect('/student/dashboard');
            return;
        }
        
        $course = Course::find((int)$id);
        if (!$course) {
            http_response_code(404);
            $this->view('errors/404', ['title' => '404 Not Found']);
            return;
        }
        
        $studentId = $_SESSION['student_id'];
        $isEnrolled = Enrollment::isEnrolled($studentId, (int)$id);
        
        $data = [
            'title' => $course['title'],
            'course' => $course,
            'isEnrolled' => $isEnrolled,
            'csrf_token' => $this->generateCsrfToken()
        ];
        
        $this->view('student/course', $data);
    }

    public function enroll()
    {
        $this->requireAuth();
        $this->validateCsrfToken();
        
        $courseId = $_POST['course_id'] ?? null;
        
        if (!is_numeric($courseId)) {
            $_SESSION['error'] = 'Invalid course ID';
            $this->redirect('/student/dashboard');
            return;
        }
        
        $studentId = $_SESSION['student_id'];
        $courseId = (int)$courseId;
        
        $course = Course::find($courseId);
        if (!$course) {
            $_SESSION['error'] = 'Course not found';
            $this->redirect('/student/dashboard');
            return;
        }
        
        if (Enrollment::isEnrolled($studentId, $courseId)) {
            $_SESSION['info'] = 'You are already enrolled in this course';
        } else {
            $success = Enrollment::create($studentId, $courseId);
            if ($success) {
                $_SESSION['success'] = 'Successfully enrolled in ' . htmlspecialchars($course['title'], ENT_QUOTES, 'UTF-8');
            } else {
                $_SESSION['error'] = 'Enrollment failed. Please try again.';
            }
        }
        
        $this->redirect('/student/dashboard');
    }

    public function logout()
    {
        $this->requireAuth();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->validateCsrfToken();
            
            $_SESSION = [];
            
            if (isset($_COOKIE[session_name()])) {
                setcookie(session_name(), '', time() - 3600, '/');
            }
            
            session_destroy();
            $this->redirect('/login');
        } else {
            // Show logout confirmation page
            $data = [
                'title' => 'Logout',
                'csrf_token' => $this->generateCsrfToken()
            ];
            $this->view('student/logout_confirm', $data);
        }
    }
}