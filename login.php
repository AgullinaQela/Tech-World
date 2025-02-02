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
    
    // Debug info
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
    <header>
        <div class="navbar">
            <h1 class="logo">TechWORLD</h1>
            <button class="hamburger" onclick="toggleMenu()">☰</button>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="courses.html">Courses</a></li>
                    <li><a href="products.php">Products</a></li>
                    <li><a href="contact.html">Contact</a></li>
                    <li><a href="login.php" class="active">Login</a></li>
                    <li><a href="register.php">Register</a></li>
                </ul>
            </nav>
        </div>
    </header>

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

    <footer>
        <div class="footer-container">
            <div class="footer-section social-section">
                <h3>TechWORLD</h3>
                <p>Connect with us on social media!</p>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="courses.html">Courses</a></li>
                    <li><a href="contact.html">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Ask Questions</a></li>
                    <li><a href="#">Send Feedback</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Newsletter</h4>
                <p>Subscribe for updates</p>
                <form action="#" method="POST" class="newsletter-form">
                    <input type="email" placeholder="Enter your email" required>
                    <button type="submit">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2024 TechWORLD. All rights reserved.</p>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            document.querySelector('nav ul').classList.toggle('show');
        }

        // Close mobile menu when clicking outside
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