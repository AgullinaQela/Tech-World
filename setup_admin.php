<?php
require_once 'config.php';

// Kontrollo nëse tabela users ekziston
$create_table = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL,
    role VARCHAR(20) NOT NULL DEFAULT 'user'
)";

if ($conn->query($create_table)) {
    $message = "Tabela users u krijua me sukses";
} else {
    $message = "Error krijimi i tabelës: " . $conn->error;
    exit();
}

// Të dhënat e adminit
$username = "Arber";
$password = password_hash("arber123", PASSWORD_DEFAULT);
$email = "arber@gmail.com";
$role = "admin";

// Kontrollo nëse admin-i ekziston
$check_sql = "SELECT * FROM users WHERE username = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("s", $username);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows > 0) {
    $message = "Admini ekziston tashmë!";
    $credentials = true;
} else {
    // Krijo admin-in
    $sql = "INSERT INTO users (username, password, email, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    
    if (!$stmt) {
        $message = "Error në krijimin e admin: " . $conn->error;
        exit();
    }
    
    $stmt->bind_param("ssss", $username, $password, $email, $role);
    
    if ($stmt->execute()) {
        $message = "Admini u krijua me sukses!";
        $credentials = true;
    } else {
        $message = "Gabim gjatë krijimit të admin: " . $stmt->error;
    }
    $stmt->close();
}

$check_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup Admin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }
        .setup-container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }
        .message {
            margin: 20px 0;
            padding: 15px;
            border-radius: 4px;
            background: #e8f5e9;
            color: #2e7d32;
        }
        .credentials {
            background: #f5f5f5;
            padding: 20px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .credentials p {
            margin: 5px 0;
            color: #333;
        }
        .login-btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .login-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="setup-container">
        <h1>Setup Admin</h1>
        <div class="message">
            <?php echo $message; ?>
        </div>
        
        <?php if (isset($credentials) && $credentials): ?>
        <div class="credentials">
            <h3>Kredencialet e Adminit:</h3>
            <p><strong>Username:</strong> Arber</p>
            <p><strong>Password:</strong> arber123</p>
        </div>
        <?php endif; ?>
        
        <a href="login.php" class="login-btn">Shko te Login</a>
    </div>
</body>
</html>