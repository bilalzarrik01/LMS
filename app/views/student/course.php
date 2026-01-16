<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Course') ?> - Thoth LMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 900px;
            margin: 0 auto;
        }
        
        .back-link {
            display: inline-block;
            color: #DAA520;
            text-decoration: none;
            margin-bottom: 20px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .back-link:hover {
            color: #FFD700;
        }
        
        .course-header {
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 1px solid rgba(218, 165, 32, 0.2);
        }
        
        .course-header h1 {
            background: linear-gradient(135deg, #DAA520 0%, #FFD700 50%, #DAA520 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        
        .course-meta {
            color: #888;
            margin-bottom: 20px;
        }
        
        .course-description {
            color: #c0c0c0;
            line-height: 1.8;
            font-size: 1.1rem;
        }
        
        .enrollment-status {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            border: 1px solid rgba(218, 165, 32, 0.2);
        }
        
        .enrolled-badge {
            background: #51cf66;
            color: white;
            padding: 15px 30px;
            border-radius: 30px;
            font-size: 1.2rem;
            font-weight: 600;
            display: inline-block;
        }
        
        .enroll-btn {
            padding: 15px 40px;
            background: linear-gradient(135deg, #DAA520 0%, #FFD700 100%);
            color: #000;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            font-size: 1.1rem;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .enroll-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(218, 165, 32, 0.6);
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/lms/public/student/dashboard" class="back-link">← Back to Dashboard</a>
        
        <div class="course-header">
            <h1><?= htmlspecialchars($course['title']) ?></h1>
            <div class="course-meta">
                Created: <?= date('F d, Y', strtotime($course['created_at'])) ?>
            </div>
            <div class="course-description">
                <?= nl2br(htmlspecialchars($course['description'])) ?>
            </div>
        </div>
        
        <div class="enrollment-status">
            <?php if ($isEnrolled): ?>
                <span class="enrolled-badge">✓ You are enrolled in this course</span>
            <?php else: ?>
                <p style="color: #c0c0c0; margin-bottom: 20px; font-size: 1.1rem;">
                    Enroll now to start learning!
                </p>
                <a href="/lms/public/student/enroll/<?= $course['id'] ?>" class="enroll-btn">
                    Enroll in This Course
                </a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
```

---

## File: /App/views/errors/404.php
```php
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found - Thoth LMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .container {
            text-align: center;
            background: rgba(0, 0, 0, 0.8);
            padding: 60px 40px;
            border-radius: 20px;
            border: 1px solid rgba(218, 165, 32, 0.2);
        }
        
        .error-code {
            font-size: 8rem;
            background: linear-gradient(135deg, #DAA520 0%, #FFD700 50%, #DAA520 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-weight: 700;
        }
        
        h1 {
            color: #c0c0c0;
            margin: 20px 0;
            font-size: 2rem;
        }
        
        p {
            color: #888;
            margin-bottom: 30px;
            font-size: 1.1rem;
        }
        
        .btn {
            padding: 15px 40px;
            background: linear-gradient(135deg, #DAA520 0%, #FFD700 100%);
            color: #000;
            text-decoration: none;
            border-radius: 50px;
            font-weight: 700;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(218, 165, 32, 0.6);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-code">404</div>
        <h1>Page Not Found</h1>
        <p>The page you are looking for does not exist.</p>
        <a href="/lms/public/" class="btn">Go Home</a>
    </div>
</body>
</html>