<?php
session_start();
require_once 'Database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    
    $name = trim($_POST['name']);
    $price = floatval($_POST['price']);
    
    $target_dir = "uploads/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        if ($db->addProduct($name, $price, $target_file)) {
            header("Location: admin_products.php?success=1");
            exit();
        }
    }
    
    header("Location: admin_products.php?error=1");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Add New Product</h2>
        <form action="add-product.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Price:</label>
                <input type="number" step="0.01" name="price" required>
            </div>
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" required>
            </div>
            <button type="submit" class="btn">Add Product</button>
        </form>
    </div>
</body>
</html>