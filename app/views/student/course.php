<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Course') ?> - Thoth LMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
        }
        
        .navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .navbar h1 {
            color: #667eea;
            font-size: 24px;
        }
        
        .navbar a {
            color: #667eea;
            text-decoration: none;
            padding: 8px 20px;
            border: 1px solid #667eea;
            border-radius: 5px;
            transition: all 0.3s;
        }
        
        .navbar a:hover {
            background: #667eea;
            color: white;
        }
        
        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .course-header {
            background: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .course-header h1 {
            color: #333;
            margin-bottom: 15px;
            font-size: 32px;
        }
        
        .course-header .instructor {
            color: #666;
            font-size: 18px;
            margin-bottom: 20px;
        }
        
        .course-header p {
            color: #555;
            line-height: 1.8;
            margin-bottom: 25px;
        }
        
        .enrolled-badge {
            display: inline-block;
            background: #48bb78;
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-success {
            background: #48bb78;
            color: white;
        }
        
        .btn-success:hover {
            background: #38a169;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(72, 187, 120, 0.4);
        }
        
        .btn-secondary {
            background: #e2e8f0;
            color: #333;
        }
        
        .btn-secondary:hover {
            background: #cbd5e0;
        }
        
        .course-content {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .course-content h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 24px;
        }
        
        .course-content p {
            color: #666;
            line-height: 1.8;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Thoth LMS</h1>
        <a href="/lms/public/student/dashboard">← Back to Dashboard</a>
    </nav>
    
    <div class="container">
        <div class="course-header">
            <?php if ($isEnrolled): ?>
                <span class="enrolled-badge">✓ You are enrolled</span>
            <?php endif; ?>
            
            <h1><?= htmlspecialchars($course['title']) ?></h1>
            <p class="instructor">Instructor: <?= htmlspecialchars($course['instructor']) ?></p>
            <p><?= htmlspecialchars($course['description']) ?></p>
            
            <?php if (!$isEnrolled): ?>
                <form method="POST" action="/lms/public/student/enroll" style="display: inline;">
                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                    <button type="submit" class="btn btn-success">Enroll in this Course</button>
                </form>
            <?php endif; ?>
        </div>
        
        <?php if ($isEnrolled): ?>
            <div class="course-content">
                <h2>Course Content</h2>
                <p>Welcome to the course! Course materials and lessons will appear here.</p>
            </div>
        <?php else: ?>
            <div class="course-content">
                <h2>About This Course</h2>
                <p>Enroll in this course to access all the learning materials, assignments, and resources.</p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>