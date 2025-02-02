<?php
session_start();
require_once 'config.php';

$auth = new Auth($conn);
$auth->requireLogin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cart = new Cart($conn);
    $result = $cart->add(
        $_SESSION['user_id'],
        $_POST['product_id'],
        $_POST['quantity'] ?? 1
    );
    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit();
}

header('HTTP/1.1 400 Bad Request');
echo json_encode(['success' => false, 'error' => 'Invalid request']);