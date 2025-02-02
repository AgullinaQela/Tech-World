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
