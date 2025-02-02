<?php
session_start();
require_once '../Database.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
$db = new Database();
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: ../products.php');
    exit();
}
$product = $db->getProductById($id);
if (!$product) {
    header('Location: ../products.php');
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    
   
    $image = $product['image']; 
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $allowed = ['jpg', 'jpeg', 'png', 'gif'];
        $filename = $_FILES['image']['name'];
        $filetype = pathinfo($filename, PATHINFO_EXTENSION);
        
        if (in_array(strtolower($filetype), $allowed)) {
            $newname = uniqid() . '.' . $filetype;
            if (move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $newname)) {
                // Delete old image if exists
                if ($product['image'] && file_exists('../uploads/' . $product['image'])) {
                    unlink('../uploads/' . $product['image']);
                }
                $image = $newname;
            }
        }
    }
    
    if ($db->updateProduct($id, $name, $description, $price, $image)) {
        $_SESSION['success'] = 'Product updated successfully';
        header('Location: ../products.php');
        exit();
    } else {
        $_SESSION['error'] = 'Error updating product';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - TechWORLD</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="admin-container">
        <h2>Edit Product</h2>
        
        <?php if (isset($_SESSION['error'])): ?>
            <div class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
        <?php endif; ?>
        
        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <div class="form-group">
                <label>Product Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
            </div>
            
            <div class="form-group">
                <label>Description:</label>
                <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>
            </div>
            
            <div class="form-group">
                <label>Price (€):</label>
                <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Current Image:</label>
                <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                     alt="Current product image" style="max-width: 200px;">
            </div>
            
            <div class="form-group">
                <label>New Image (leave empty to keep current):</label>
                <input type="file" name="image">
            </div>
            
            <button type="submit" class="btn">Update Product</button>
            <a href="../products.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html> 