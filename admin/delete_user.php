<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}

require_once '../Database.php';
$db = new Database();

$userId = $_GET['id'] ?? null;
if ($userId) {
    if ($db->deleteUser($userId)) {
        $_SESSION['success'] = "Përdoruesi u fshi me sukses!";
    } else {
        $_SESSION['error'] = "Ndodhi një gabim gjatë fshirjes së përdoruesit!";
    }
}

header("Location: dashboard.php");
exit(); 