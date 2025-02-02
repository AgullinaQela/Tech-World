<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
   
    $user = $db->loginUser($email, $password);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        
        
        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.html");
        }
        exit();
    } else {
        $_SESSION['error'] = "Email ose fjalëkalimi është i gabuar!";
        header("Location: login.php");
        exit();
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
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="error">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="success">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']);
            }
            ?>
            <form id="loginForm" action="login.php" method="POST">
                <div class="form-group">
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <p class="switch-auth">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>
</body>
</html>