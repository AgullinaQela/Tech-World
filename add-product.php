<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'Database.php';

// Check if user is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

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
            $_SESSION['success'] = "Product added successfully!";
            header("Location: admin_products.php");
            exit();
        }
    }
    
    $_SESSION['error'] = "Error adding product!";
    header("Location: admin_products.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product - TechWORLD</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="navbar">
            <h1 class="logo">TechWORLD</h1>
            <nav>
                <ul>
                    <li><a href="admin_products.php">Back to Products</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <div class="container">
        <div class="form-container">
            <h2>Add New Product</h2>
            <form action="add-product.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Product Name:</label>
                    <input type="text" name="name" required>
                </div>
                <div class="form-group">
                    <label>Price (€):</label>
                    <input type="number" step="0.01" name="price" required>
                </div>
                <div class="form-group">
                    <label>Image:</label>
                    <input type="file" name="image" required accept="image/*">
                </div>
                <div class="form-buttons">
                    <button type="submit" class="btn">Add Product</button>
                    <a href="admin_products.php" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>