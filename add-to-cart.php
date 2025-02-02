<?php
session_start();
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = (int)$_POST['product_id'];
    
    // Inicializo shportën nëse nuk ekziston
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Shto produktin në shportë ose rrit sasinë
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id]++;
    } else {
        $_SESSION['cart'][$product_id] = 1;
    }
    
    echo json_encode([
        'success' => true,
        'cartCount' => count($_SESSION['cart'])
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request'
    ]);
}
?> 