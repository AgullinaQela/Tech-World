<?php
session_start();
require_once 'config.php';
require_once 'AdminUser.php';


if (!isset($_SESSION['user_id'])) {
    header('Location: admin-login.php');
    exit();
}

$admin = new AdminUser($conn);
if (!$admin->isAdmin($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    
  
    $product = $admin->getProduct($product_id);
    
    if ($product && $admin->deleteProduct($product_id)) {
       
        if (!empty($product['image']) && file_exists($product['image'])) {
            unlink($product['image']);
        }
        header('Location: manage-products.php?success=1');
    } else {
        header('Location: manage-products.php?error=1');
    }
} else {
    header('Location: manage-products.php');
}
exit();
?> 