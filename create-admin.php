<?php
require_once 'config.php';

$username = "admin"; // Ndrysho këtë
$password = "admin123"; // Ndrysho këtë
$email = "admin@example.com"; // Ndrysho këtë

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO admin (username, password, email) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $username, $hashed_password, $email);

if ($stmt->execute()) {
    echo "Admin u krijua me sukses!";
} else {
    echo "Error: " . $stmt->error;
}
?>