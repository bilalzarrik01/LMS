<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Register') ?> - Thoth LMS</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow: hidden;
        }
        
        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 215, 0, 0.15) 0%, transparent 70%);
            bottom: -300px;
            left: -300px;
            border-radius: 50%;
            animation: pulse 4s ease-in-out infinite;
        }
        
        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.15; }
            50% { transform: scale(1.1); opacity: 0.25; }
        }
        
        .container {
            background: rgba(0, 0, 0, 0.85);
            padding: 50px 40px;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.6),
                        0 0 100px rgba(218, 165, 32, 0.1);
            width: 100%;
            max-width: 500px;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(218, 165, 32, 0.2);
            backdrop-filter: blur(10px);
        }
        
        .logo {
            text-align: center;
            font-size: 3rem;
            margin-bottom: 1rem;
            filter: drop-shadow(0 0 20px rgba(218, 165, 32, 0.5));
        }
        
        h1 {
            text-align: center;
            background: linear-gradient(135deg, #DAA520 0%, #FFD700 50%, #DAA520 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 10px;
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: 2px;
        }
        
        .subtitle {
            text-align: center;
            color: #888;
            margin-bottom: 35px;
            font-size: 14px;
            letter-spacing: 1px;
        }
        
        .form-group {
            margin-bottom: 25px;
            position: relative;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: #DAA520;
            font-weight: 500;
            font-size: 14px;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            padding: 15px 20px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(218, 165, 32, 0.3);
            border-radius: 10px;
            font-size: 15px;
            color: #fff;
            transition: all 0.3s;
        }
        
        input::placeholder {
            color: #666;
        }
        
        input:focus {
            outline: none;
            border-color: #DAA520;
            background: rgba(218, 165, 32, 0.05);
            box-shadow: 0 0 20px rgba(218, 165, 32, 0.2);
        }
        
        .btn {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #DAA520 0%, #FFD700 100%);
            color: #000;
            border: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            letter-spacing: 2px;
            text-transform: uppercase;
            transition: all 0.4s;
            box-shadow: 0 10px 30px rgba(218, 165, 32, 0.4);
            position: relative;
            overflow: hidden;
        }
        
        .btn::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: linear-gradient(135deg, #FFD700 0%, #DAA520 100%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s, height 0.6s;
        }
        
        .btn:hover::before {
            width: 500px;
            height: 500px;
        }
        
        .btn span {
            position: relative;
            z-index: 1;
        }
        
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(218, 165, 32, 0.6);
        }
        
        .btn:active {
            transform: translateY(-1px);
        }
        
        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            animation: slideIn 0.3s ease-out;
        }
        
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .alert-error {
            background: rgba(220, 53, 69, 0.2);
            color: #ff6b6b;
            border: 1px solid rgba(220, 53, 69, 0.3);
        }
        
        .alert-error ul {
            margin: 0;
            padding-left: 20px;
        }
        
        .alert-error li {
            margin: 5px 0;
        }
        
        .link-group {
            text-align: center;
            margin-top: 30px;
            color: #888;
            font-size: 14px;
        }
        
        .link-group a {
            color: #DAA520;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }
        
        .link-group a:hover {
            color: #FFD700;
            text-shadow: 0 0 10px rgba(218, 165, 32, 0.5);
        }
        
        .password-strength {
            height: 4px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
            margin-top: 8px;
            overflow: hidden;
        }
        
        .password-strength-bar {
            height: 100%;
            width: 0;
            background: linear-gradient(90deg, #ff6b6b, #ffd700);
            transition: width 0.3s;
        }
        
        @media (max-width: 480px) {
            .container {
                padding: 40px 30px;
            }
            
            h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">🎓</div>
        <h1>THOTH LMS</h1>
        <p class="subtitle">Create Your Account</p>
        
        <?php if (isset($errors) && !empty($errors)): ?>
            <div class="alert alert-error">
                <ul>
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        
        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">
            
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" id="name" name="name" 
                       placeholder="Enter your full name" 
                       value="<?= htmlspecialchars($old['name'] ?? '') ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" 
                       placeholder="Enter your email" 
                       value="<?= htmlspecialchars($old['email'] ?? '') ?>" 
                       required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" 
                       placeholder="Create a password (min 8 characters)" 
                       required>
                <div class="password-strength">
                    <div class="password-strength-bar" id="strength-bar"></div>
                </div>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" 
                       placeholder="Confirm your password" 
                       required>
            </div>
            
            <button type="submit" class="btn">
                <span>Create Account</span>
            </button>
        </form>
        
        <div class="link-group">
            Already have an account? <a href="login">Login here</a>
        </div>
    </div>
    
    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthBar = document.getElementById('strength-bar');
        
        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = 0;
            
            if (password.length >= 8) strength += 25;
            if (password.length >= 12) strength += 25;
            if (/[a-z]/.test(password) && /[A-Z]/.test(password)) strength += 25;
            if (/\d/.test(password) && /[^a-zA-Z\d]/.test(password)) strength += 25;
            
            strengthBar.style.width = strength + '%';
            
            if (strength <= 25) {
                strengthBar.style.background = '#ff6b6b';
            } else if (strength <= 50) {
                strengthBar.style.background = '#ffa500';
            } else if (strength <= 75) {
                strengthBar.style.background = '#ffd700';
            } else {
                strengthBar.style.background = '#51cf66';
            }
        });
    </script>
</body>
</html>
