<?php
session_start();
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
  
    if (empty($email) || empty($password)) {
        $_SESSION['error'] = "Të gjitha fushat duhet të plotësohen!";
        header("Location: login.php");
        exit();
    }
    
  
    $user = $db->loginUser($email, $password);
    
    if ($user) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        
       
        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
        } else {
            header("Location: index.php");
        }
    } else {
        $_SESSION['error'] = "Email ose fjalëkalimi është i gabuar!";
        header("Location: login.php");
    }
    exit();
}
?> 