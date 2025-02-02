<?php
session_start();
require_once 'config.php';  // Changed from '../Database.php'

// Check if user is admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Check if ID is provided
if (!isset($_GET['id'])) {
    header('Location: admin_products.php');
    exit();
}

$id = (int)$_GET['id'];

// Get product details
$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $id);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    header('Location: admin_products.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $price = (float)$_POST['price'];
    
    // Check if new image is uploaded
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "Images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // Delete old image if exists
            if (file_exists($product['image'])) {
                unlink($product['image']);
            }
            
            // Update with new image
            $sql = "UPDATE products SET name = :name, price = :price, image = :image WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':image', $target_file);
        } else {
            $_SESSION['error'] = "Gabim gjatë ngarkimit të imazhit.";
            header("Location: edit_product.php?id=$id");
            exit();
        }
    } else {
        // Update without changing image
        $sql = "UPDATE products SET name = :name, price = :price WHERE id = :id";
        $stmt = $conn->prepare($sql);
    }
    
    $stmt->bindParam(':name', $name);
    $stmt->bindParam(':price', $price);
    $stmt->bindParam(':id', $id);
    
    if ($stmt->execute()) {
        $_SESSION['success'] = "Produkti u përditësua me sukses!";
        header('Location: admin_products.php');
        exit();
    } else {
        $_SESSION['error'] = "Gabim gjatë përditësimit të produktit!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - TechWORLD</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <?php include 'admin_header.php'; ?>

    <div class="admin-container">
        <div class="admin-header">
            <h1>Edit Product</h1>
            <a href="admin_products.php" class="btn-back">
                <i class="fas fa-arrow-left"></i> Back to Products
            </a>
        </div>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form method="post" enctype="multipart/form-data" class="edit-form">
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Price (€):</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Current Image:</label>
                <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                     class="product-image-preview">
            </div>
            
            <div class="form-group">
                <label>New Image (optional):</label>
                <input type="file" name="image" accept="image/*">
            </div>
            
            <div class="button-group">
                <button type="submit" class="btn-save">
                    <i class="fas fa-save"></i> Save Changes
                </button>
                <a href="admin_products.php" class="btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>