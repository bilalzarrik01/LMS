<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>

<h2>Student Register</h2>
<form method="POST" action="/register">
    <input type="text" name="name" required>
    <input type="email" name="email" required>
    <input type="password" name="password" required>
    <button type="submit">Register</button>
    <?php if(isset($error)): ?>
    <p style="color:red"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>
</form>

<p>
    Already have an account?
    <a href="login.php">Login</a>
</p>

</body>
</html>
