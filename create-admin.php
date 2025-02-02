<?php
require_once 'config.php';

$username = "Agullina"; 
$password = "_Agullina1";
$email = "agullinaqela@gmail.com"; 

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