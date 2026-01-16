<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> - Thoth LMS</title>
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
        
        .navbar .user-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        
        .navbar .user-name {
            color: #333;
            font-weight: 500;
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
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert-success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        
        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border: 1px solid #bee5eb;
        }
        
        .section {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }
        
        .section h2 {
            color: #333;
            margin-bottom: 20px;
            font-size: 22px;
        }
        
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }
        
        .course-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            transition: all 0.3s;
        }
        
        .course-card:hover {
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transform: translateY(-5px);
        }
        
        .course-card h3 {
            color: #667eea;
            margin-bottom: 10px;
            font-size: 18px;
        }
        
        .course-card p {
            color: #666;
            margin-bottom: 15px;
            line-height: 1.5;
        }
        
        .course-card .instructor {
            color: #999;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background: #667eea;
            color: white;
        }
        
        .btn-primary:hover {
            background: #5568d3;
        }
        
        .btn-success {
            background: #48bb78;
            color: white;
        }
        
        .btn-secondary {
            background: #e2e8f0;
            color: #333;
        }
        
        .enrolled-badge {
            display: inline-block;
            background: #48bb78;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 12px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Thoth LMS</h1>
        <div class="user-info">
            <span class="user-name">Welcome, <?= htmlspecialchars($studentName) ?></span>
            <a href="/lms/public/logout">Logout</a>
        </div>
    </nav>
    
    <div class="container">
        <?php if (isset($success)): ?>
            <div class="alert alert-success">
                ✓ <?= htmlspecialchars($success) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($error)): ?>
            <div class="alert alert-error">
                ✗ <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        
        <?php if (isset($info)): ?>
            <div class="alert alert-info">
                ℹ <?= htmlspecialchars($info) ?>
            </div>
        <?php endif; ?>
        
        <div class="section">
            <h2>My Enrolled Courses</h2>
            <?php if (empty($enrolledCourses)): ?>
                <p style="color: #666;">You haven't enrolled in any courses yet.</p>
            <?php else: ?>
                <div class="courses-grid">
                    <?php foreach ($enrolledCourses as $course): ?>
                        <div class="course-card">
                            <span class="enrolled-badge">Enrolled</span>
                            <h3><?= htmlspecialchars($course['title']) ?></h3>
                            <p><?= htmlspecialchars($course['description']) ?></p>
                            <p class="instructor">By <?= htmlspecialchars($course['instructor']) ?></p>
                            <a href="/lms/public/student/course/<?= $course['id'] ?>" class="btn btn-primary">View Course</a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="section">
            <h2>Available Courses</h2>
            <div class="courses-grid">
                <?php foreach ($availableCourses as $course): ?>
                    <div class="course-card">
                        <h3><?= htmlspecialchars($course['title']) ?></h3>
                        <p><?= htmlspecialchars($course['description']) ?></p>
                        <p class="instructor">By <?= htmlspecialchars($course['instructor']) ?></p>
                        
                        <?php if (in_array($course['id'], $enrolledIds)): ?>
                            <a href="/lms/public/student/course/<?= $course['id'] ?>" class="btn btn-secondary">View Course</a>
                        <?php else: ?>
                            <form method="POST" action="/lms/public/student/enroll" style="display: inline;">
                                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                <button type="submit" class="btn btn-success">Enroll Now</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>
</html>