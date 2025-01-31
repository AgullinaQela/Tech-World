<?php
session_start();
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $stock = $_POST['stock'];

    // Handle file upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        move_uploaded_file($_FILES["image"]["tmp_name"], $target_file);
        $image_path = $target_file;
    }

    // Insert into database
    $sql = "INSERT INTO products (name, price, description, category, stock, image) 
            VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sdssss", $name, $price, $description, $category, $stock, $image_path);
    
    if ($stmt->execute()) {
        header('Location: manage-products.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <button class="sidebar-toggle">☰</button>
        
        <aside class="dashboard-sidebar">
            <!-- Same sidebar as manage-products.php -->
        </aside>

        <main class="dashboard-content">
            <div class="content-header">
                <h1>Add New Product</h1>
            </div>

            <div class="dashboard-form">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" id="name" name="name" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" id="price" name="price" step="0.01" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea id="description" name="description" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="category">Category</label>
                        <select id="category" name="category" class="form-control" required>
                            <option value="">Select Category</option>
                            <option value="electronics">Electronics</option>
                            <option value="clothing">Clothing</option>
                            <option value="books">Books</option>
                            <!-- Add more categories as needed -->
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" id="stock" name="stock" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label for="image">Product Image</label>
                        <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
                    </div>

                    <button type="submit" class="submit-btn">Add Product</button>
                </form>
            </div>
        </main>
    </div>

    <script>
        // Same JavaScript as manage-products.php
    </script>
</body>
</html>