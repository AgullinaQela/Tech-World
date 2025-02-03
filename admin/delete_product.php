<?php
session_start();
require_once '../Database.php';


if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$db = new Database();
$id = $_GET['id'] ?? null;

if ($id) {
   
    $product = $db->getProductById($id);
    
    if ($product && $db->deleteProduct($id)) {
      
        if ($product['image'] && file_exists('../uploads/' . $product['image'])) {
            unlink('../uploads/' . $product['image']);
        }
        $_SESSION['success'] = 'Product deleted successfully';
    } else {
        $_SESSION['error'] = 'Error deleting product';
    }
}

header('Location: ../products.php');
exit(); 