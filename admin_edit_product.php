<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "Images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $sql = "UPDATE products SET name='$name', price='$price', image='$target_file' WHERE id=$id";
        }
    } else {
        $sql = "UPDATE products SET name='$name', price='$price' WHERE id=$id";
    }
    
    if ($conn->query($sql)) {
        header("Location: admin_products.php?message=Produkti u përditësua me sukses!");
        exit();
    } else {
        $error = "Gabim gjatë përditësimit: " . $conn->error;
    }
} else {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM products WHERE id=$id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ndrysho Produkt</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .current-image {
            max-width: 200px;
            margin: 10px 0;
        }
        .btn {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin-right: 10px;
        }
        .btn-secondary {
            background-color: #666;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Ndrysho Produkt</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="post" action="admin_edit_product.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            
            <div class="form-group">
                <label>Emri i Produktit:</label>
                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Çmimi (€):</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Imazhi Aktual:</label><br>
                <img src="<?php echo $product['image']; ?>" class="current-image">
            </div>
            
            <div class="form-group">
                <label>Ndrysho Imazhin (opsionale):</label>
                <input type="file" name="image">
            </div>
            
            <button type="submit" class="btn">Ruaj Ndryshimet</button>
            <a href="admin_products.php" class="btn btn-secondary">Kthehu</a>
        </form>
    </div>
</body>
</html>