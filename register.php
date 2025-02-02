<?php
session_start();

require_once 'Database.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = new Database();
        
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
  
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Të gjitha fushat duhet të plotësohen!";
            header("Location: register.php");
            exit();
        }
        
       
        if ($db->emailExists($email)) {
            $_SESSION['error'] = "Ky email ekziston tashmë!";
            header("Location: register.php");
            exit();
        }
        
        
        if ($db->registerUser($name, $email, $password)) {
            $_SESSION['success'] = "Regjistrimi u krye me sukses! Tani mund të logoheni.";
            header("Location: login.php");
            exit();
        } else {
            $_SESSION['error'] = "Ndodhi një gabim gjatë regjistrimit!";
            header("Location: register.php");
            exit();
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Ndodhi një gabim: " . $e->getMessage();
        header("Location: register.php");
        exit();
=======
require_once 'config.php';
require_once 'User.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $surname = trim($_POST['surname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validimi
    if (empty($name) || empty($surname) || empty($email) || empty($password)) {
        $error = "Ju lutem plotësoni të gjitha fushat";
    } elseif ($password !== $confirm_password) {
        $error = "Fjalëkalimet nuk përputhen";
    } elseif (strlen($password) < 6) {
        $error = "Fjalëkalimi duhet të ketë të paktën 6 karaktere";
    } else {
        $user = new User($conn);
        $result = $user->register($name, $surname, $email, $password);
        
        if ($result === true) {
            $success = "Regjistrimi u krye me sukses! Tani mund të kyçeni.";
        } else {
            $error = $result;
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Regjistrohu</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Regjistrohu</h2>
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
        <form action="register.php" method="POST">
            <div class="form-group">
                <label>Emri:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required>
            </div>
            <div class="form-group">
                <label>Fjalëkalimi:</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit">Regjistrohu</button>
        </form>
        <p>Keni një llogari? <a href="login.php">Login</a></p>
    </div>
</body>
</html>
=======
    <title>Register</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .register-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .error {
            color: #f44336;
            margin-bottom: 15px;
            text-align: center;
        }
        .success {
            color: #4CAF50;
            margin-bottom: 15px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #666;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        button:hover {
            background: #45a049;
        }
        p {
            text-align: center;
            margin-top: 15px;
        }
        a {
            color: #2196F3;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Regjistrohu</h2>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($success): ?>
            <div class="success"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST">
            <div class="form-group">
                <label for="name">Emri</label>
                <input type="text" id="name" name="name" required>
            </div>
            
            <div class="form-group">
                <label for="surname">Mbiemri</label>
                <input type="text" id="surname" name="surname" required>
            </div>
            
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <div class="form-group">
                <label for="confirm_password">Konfirmo Password</label>
                <input type="password" id="confirm_password" name="confirm_password" required>
            </div>
            
            <button type="submit">Regjistrohu</button>
        </form>
        
        <p>Keni llogari? <a href="login.php">Kyçuni këtu</a></p>
    </div>
</body>
</html>

