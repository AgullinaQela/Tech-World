<?php
session_start();
require_once '../Database.php';

// Kontrollo nëse përdoruesi është admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $userId = $_SESSION['user_id'];
    
    // Handle file upload
    $image = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            $newname = uniqid() . '.' . $filetype;
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $newname)) {
                $image = $newname;
            }
        }
    }
    
    if ($db->addProduct($name, $description, $price, $image, $userId)) {
        $_SESSION['success'] = 'Product added successfully';
        header('Location: ../products.php');
        exit();
    } else {
        $_SESSION['error'] = 'Error adding product';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - TechWORLD</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Add New Product</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required></textarea>
            </div>
            
            <div class="form-group">
                <label>Price (€):</label>
                <input type="number" name="price" step="0.01" required>
            </div>
            
            <div class="form-group">
                <label>Image:</label>
                <input type="file" name="image" required>
            </div>
            
            <button type="submit" class="btn">Add Product</button>
            <a href="../products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>