<?php
session_start();
require_once 'config.php';
require_once 'AdminUser.php';

// Kontrollo nëse përdoruesi është i kyçur dhe është admin
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
    
    // Merr produktin për të fshirë foton
    $product = $admin->getProduct($product_id);
    
    if ($product && $admin->deleteProduct($product_id)) {
        // Fshi foton nëse ekziston
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