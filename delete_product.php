<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'Database.php';


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

if (isset($_GET['id'])) {
    $db = new Database();
    $id = (int)$_GET['id'];
    
    $product = $db->getProductById($id);
    if ($product && $db->deleteProduct($id)) {
        if (file_exists($product['image'])) {
            unlink($product['image']);
        }
        $_SESSION['success'] = "Product deleted successfully!";
    } else {
        $_SESSION['error'] = "Error deleting product!";
    }
}

header("Location: admin_products.php");
exit();
?>