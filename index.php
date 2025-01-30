<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit;
}

echo "Welcome, " . $_SESSION['email'] . "!";
?>
<a href="logout.php">Logout</a>