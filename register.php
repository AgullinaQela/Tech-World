<?php
include_once 'Database.php';
include_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Merr të dhënat nga forma
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Kontrollo nëse fjalëkalimet përputhen
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }

    // Krijo një objekt të klasës User
    $db = new Database();
    $conn = $db->getConnection();
    $user = new User($conn);

    // Regjistro përdoruesin
    $registrationResult = $user->register($username, $email, $password);

    if ($registrationResult === true) {
        echo "Registration successful.";
    } else {
        echo $registrationResult; // Kthe mesazhin e gabimit
    }
}
?>