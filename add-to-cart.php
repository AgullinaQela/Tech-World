<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new Database();
    
    $product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    
    if ($product_id > 0) {
        $product = $db->getProductById($product_id);
        
        if ($product) {
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            
            // Check if product already exists in cart
            $found = false;
            foreach ($_SESSION['cart'] as &$item) {
                if ($item['id'] === $product_id) {
                    $item['quantity'] += $quantity;
                    $found = true;
                    break;
                }
            }
            
            if (!$found) {
                $_SESSION['cart'][] = [
                    'id' => $product_id,
                    'name' => $product['name'],
                    'price' => $product['price'],
                    'quantity' => $quantity
                ];
            }
            
            echo json_encode(['success' => true]);
            exit;
        }
    }
}

echo json_encode(['success' => false]);
?>