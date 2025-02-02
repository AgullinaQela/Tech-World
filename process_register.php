<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $db = new Database();
        
        $name = trim($_POST['name']);
        $email = trim($_POST['email']);
        $password = trim($_POST['password']);
        
        // Validimi bazik
        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['error'] = "Të gjitha fushat duhet të plotësohen!";
            header("Location: register.php");
            exit();
        }
        
        // Kontrollo nëse emaili ekziston
        if ($db->emailExists($email)) {
            $_SESSION['error'] = "Ky email ekziston tashmë!";
            header("Location: register.php");
            exit();
        }
        
        // Regjistro përdoruesin
        if ($db->registerUser($name, $email, $password)) {
            $_SESSION['success'] = "Regjistrimi u krye me sukses! Tani mund të logoheni.";
            header("Location: login.php");
        } else {
            $_SESSION['error'] = "Ndodhi një gabim gjatë regjistrimit!";
            header("Location: register.php");
        }
    } catch (Exception $e) {
        $_SESSION['error'] = "Ndodhi një gabim: " . $e->getMessage();
        header("Location: register.php");
    }
    exit();
}
?> 