<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
  
    error_log("Login attempt with email: " . $email);
    
    $user = $db->loginUser($email, $password);
    
    if ($user) {
        error_log("User found: " . print_r($user, true));
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        
        error_log("User role: " . $user['role']);
        
        if ($user['role'] == 'admin') {
            error_log("Redirecting to admin page");
            header("Location: admin_products.php");
        } else {
            error_log("Redirecting to index page");
            header("Location: index.php");
        }
        exit();
    } else {
        error_log("Login failed for email: " . $email);
        $_SESSION['error'] = "Email ose fjalëkalimi është i gabuar!";
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
            <form action="login.php" method="POST">
                <div class="form-group">
                    <input type="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="btn">Login</button>
            </form>
            <p class="switch-auth">Don't have an account? <a href="register.php">Register here</a></p>
        </div>
    </div>

   
    <script>
        function toggleMenu() {
            document.querySelector('nav ul').classList.toggle('show');
        }

        
        document.addEventListener('click', function(event) {
            const nav = document.querySelector('nav ul');
            const hamburger = document.querySelector('.hamburger');
            
            if (!nav.contains(event.target) && !hamburger.contains(event.target)) {
                nav.classList.remove('show');
            }
        });
    </script>
</body>
</html>