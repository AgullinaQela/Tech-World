<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    
   
    $nameRegex = "/^[a-zA-Z\s]{3,50}$/";
    $passwordRegex = "/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$/";
    
    $error = false;
    
   
    if (empty($name) || empty($email) || empty($password) || empty($confirm_password)) {
        $_SESSION['error'] = "All fields are required!";
        $error = true;
    } 
    elseif (!preg_match($nameRegex, $name)) {
        $_SESSION['error'] = "Name must be 3-50 characters long and contain only letters and spaces!";
        $error = true;
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address!";
        $error = true;
    }
    elseif (!preg_match($passwordRegex, $password)) {
        $_SESSION['error'] = "Password must be at least 8 characters long and include: uppercase letter, lowercase letter, number, and special character!";
        $error = true;
    }
    elseif ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match!";
        $error = true;
    }
    elseif ($db->emailExists($email)) {
        $_SESSION['error'] = "Email already exists!";
        $error = true;
    }

    if (!$error) {
        if ($db->registerUser($name, $email, $password)) {
            $_SESSION['success'] = "Registration successful! Please login.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "Registration failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - TechWORLD</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="auth-page">
        <div class="auth-card">
            <h3>Register to TechWORLD</h3>
            
            <?php if(isset($_SESSION['error'])): ?>
                <div class="error">
                    <?php 
                        echo $_SESSION['error'];
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <form action="register.php" method="POST" id="registerForm">
                <div class="form-group">
                    <input type="text" name="name" id="name" placeholder="Full Name" required
                           pattern="[a-zA-Z\s]{3,50}" 
                           title="Name must be 3-50 characters long and contain only letters and spaces">
                </div>
                <div class="form-group">
                    <input type="email" name="email" id="email" placeholder="Email Address" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password" id="password" placeholder="Password" required
                           pattern="(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}"
                           title="Must contain at least 8 characters, one uppercase, one lowercase, one number and one special character">
                </div>
                <div class="form-group">
                    <input type="password" name="confirm_password" id="confirm_password" 
                           placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn">Register</button>
            </form>
            
            <p class="switch-auth">Already have an account? <a href="login.php">Login here</a></p>
        </div>
    </div>

    <script>
    document.getElementById('registerForm').addEventListener('submit', function(e) {
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        if (password !== confirmPassword) {
            e.preventDefault();
            alert('Passwords do not match!');
        }
    });

    // Real-time password match validation
    document.getElementById('confirm_password').addEventListener('input', function() {
        const password = document.getElementById('password').value;
        const confirmPassword = this.value;
        
        if (password !== confirmPassword) {
            this.setCustomValidity('Passwords do not match!');
        } else {
            this.setCustomValidity('');
        }
    });
    </script>
</body>
</html>