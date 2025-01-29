<?php
session_start();
include_once 'Database.php';
include_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    try {
       
        $db = new Database();
        $conn = $db->getConnection();

        
        $user = new User($conn);

        
        $authenticatedUser = $user->login($email, $password);

        if ($authenticatedUser) {
            
            $_SESSION['user_id'] = $authenticatedUser['id'];
            $_SESSION['username'] = $authenticatedUser['username'];
            $_SESSION['role'] = $authenticatedUser['role'];

            
            if ($authenticatedUser['role'] === 'admin') {
                header("Location: admin_dashboard.php"); 
            } else {
                header("Location: user_dashboard.php"); 
            }
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - TechWORLD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <h3>Login to TechWORLD</h3>
            <form id="loginForm" method="POST" action="login.php">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>

                <div class="additional-options">
                    <label for="rememberMe">
                        <input type="checkbox" id="rememberMe" name="rememberMe">
                        Remember Me
                    </label>
                    <a href="#" class="forgot-password">Forgot Password?</a>
                </div>

                <button type="submit" class="btn">Login</button>
                <?php if (!empty($error)): ?>
                    <p id="errorMessage" class="error"><?= htmlspecialchars($error) ?></p>
                <?php endif; ?>
            </form>
            <p class="switch-auth">Don't have an account? <a href="register.html">Register here</a></p>
        </div>
    </div>
</body>
</html>