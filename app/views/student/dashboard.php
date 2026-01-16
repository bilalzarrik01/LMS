<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Dashboard') ?> - Thoth LMS</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .header {
            background: rgba(0, 0, 0, 0.8);
            padding: 20px 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid rgba(218, 165, 32, 0.2);
        }
        
        .header h1 {
            background: linear-gradient(135deg, #DAA520 0%, #FFD700 50%, #DAA520 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.8rem;
        }
        
        .welcome {
            color: #c0c0c0;
            font-size: 1.1rem;
        }
        
        .logout-btn {
            padding: 10px 25px;
            background: linear-gradient(135deg, #ff6b6b 0%, #ff8787 100%);
            color: white;
            text-decoration: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .logout-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 107, 107, 0.4);
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        
        .section {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 1px solid rgba(218, 165, 32, 0.2);
        }
        
        .section h2 {
            color: #DAA520;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        
        .course-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
        }
        
        .course-card {
            background: rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 12px;
            border: 1px solid rgba(218, 165, 32, 0.3);
            transition: all 0.3s;
        }
        
        .course-card:hover {
            transform: translateY(-5px);
            background: rgba(218, 165, 32, 0.1);
            border-color: rgba(218, 165, 32, 0.5);
        }
        
        .course-card h3 {
            color: #FFD700;
            margin-bottom: 10px;
            font-size: 1.3rem;
        }
        
        .course-card p {
            color: #999;
            margin-bottom: 15px;
            line-height: 1.6;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .btn-enroll {
            background: linear-gradient(135deg, #DAA520 0%, #FFD700 100%);
            color: #000;
        }
        
        .btn-enroll:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(218, 165, 32, 0.4);
        }
        
        .btn-view {
            background: transparent;
            border: 2px solid #DAA520;
            color: #DAA520;
        }
        
        .btn-view:hover {
            background: rgba(218, 165, 32, 0.1);
            border-color: #FFD700;
            color: #FFD700;
        }
        
        .enrolled-badge {
            background: #51cf66;
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
        }
        
        .empty-state {
            text-align: center;
            color: #666;
            padding: 40px;
            font-size: 1.1rem;
        }
        
        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
            
            .course-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div>
                <h1>🎓 THOTH LMS</h1>
                <p class="welcome">Welcome, <?= htmlspecialchars($studentName) ?>!</p>
            </div>
            <a href="/lms/public/logout" class="logout-btn">Logout</a>
        </div>
        
        <div class="section">
            <h2>📚 My Enrolled Courses</h2>
            <?php if (empty($enrolledCourses)): ?>
                <div class="empty-state">
                    You haven't enrolled in any courses yet. Browse available courses below!
                </div>
            <?php else: ?>
                <div class="course-grid">
                    <?php foreach ($enrolledCourses as $course): ?>
                        <div class="course-card">
                            <h3><?= htmlspecialchars($course['title']) ?></h3>
                            <p><?= htmlspecialchars($course['description']) ?></p>
                            <p style="color: #888; font-size: 0.9rem;">
                                Enrolled: <?= date('M d, Y', strtotime($course['enrollment_date'])) ?>
                            </p>
                            <a href="/lms/public/student/course/<?= $course['id'] ?>" class="btn btn-view">
                                View Course
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="section">
            <h2>🔍 Available Courses</h2>
            <?php if (empty($availableCourses)): ?>
                <div class="empty-state">
                    No courses available at the moment.
                </div>
            <?php else: ?>
                <div class="course-grid">
                    <?php foreach ($availableCourses as $course): ?>
                        <div class="course-card">
                            <h3><?= htmlspecialchars($course['title']) ?></h3>
                            <p><?= htmlspecialchars($course['description']) ?></p>
                            <?php if (in_array($course['id'], $enrolledIds)): ?>
                                <span class="enrolled-badge">✓ Enrolled</span>
                            <?php else: ?>
                                <a href="/lms/public/student/enroll/<?= $course['id'] ?>" class="btn btn-enroll">
                                    Enroll Now
                                </a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>