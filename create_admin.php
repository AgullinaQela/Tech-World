<?php
require_once 'config.php';

// Kontrollo nëse admin-i ekziston
$check_sql = "SELECT * FROM users WHERE username = 'admin'";
$result = $conn->query($check_sql);

if ($result->num_rows > 0) {
    echo "Admin already exists!";
    echo "<br>You can login with:<br>";
    echo "Username: admin<br>";
    echo "Password: admin123";
    exit();
}

$username = "admin";
$password = password_hash("admin123", PASSWORD_DEFAULT);
$email = "admin@example.com";
$role = "admin";

$sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $username, $password, $email, $role);

if ($stmt->execute()) {
    echo "Admin created successfully!<br>";
    echo "You can now login with:<br>";
    echo "Username: admin<br>";
    echo "Password: admin123";
} else {
    echo "Error creating admin: " . $conn->error;
}
?>

<br><br>
<a href="login.php">Go to Login Page</a>