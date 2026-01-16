<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Thoth LMS') ?></title>
    <style>
        /* ... existing CSS ... */
        
        .btn-secondary:hover {
            transform: translateY(-5px);
            border-color: #FFD700;
            color: #FFD700;
            box-shadow: 0 15px 40px rgba(218, 165, 32, 0.3);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🎓</div>
        <h1>THOTH LMS</h1>
        <p class="tagline">Ancient Wisdom, Modern Learning</p>
        
        <div class="buttons">
            <a href="/login" class="btn btn-primary">
                <span>Login</span>
            </a>
            <a href="/register" class="btn btn-secondary">
                <span>Register</span>
            </a>
        </div>
    </div>
</body>
</html>