<?php
include_once 'Database.php';
include_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    
    if ($password !== $confirmPassword) {
        die("Passwords do not match.");
    }


    $db = new Database();
    $conn = $db->getConnection();
    $user = new User($conn);


    $registrationResult = $user->register($username, $email, $password);

    if ($registrationResult === true) {
        echo "Registration successful.";
    } else {
        echo $registrationResult; 
    }
}
?>