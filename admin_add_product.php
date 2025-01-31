<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Pastrojmë të dhënat
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    
    $target_dir = "Images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image = $target_file;
        
        $sql = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";
        
        if($conn->query($sql)) {
            header("Location: admin_products.php");
            exit();
        } else {
            $error = "Gabim gjatë shtimit të produktit: " . $conn->error;
        }
    } else {
        $error = "Gabim gjatë ngarkimit të imazhit.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Shto Produkt</title>
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
        <h2>Shto Produkt të Ri</h2>
        <?php if (isset($error)) echo "<p class='error'>$error</p>"; ?>
        
        <form method="post" action="admin_add_product.php" enctype="multipart/form-data">
            <div class="form-group">
                <label>Emri i Produktit:</label>
                <input type="text" name="name" required>
            </div>
            
            <div class="form-group">
                <label>Çmimi (€):</label>
                <input type="number" step="0.01" name="price" required>
            </div>
            
            <div class="form-group">
                <label>Imazhi:</label>
                <input type="file" name="image" required>
            </div>
            
            <button type="submit" class="btn">Shto Produkt</button>
            <a href="admin_products.php" class="btn btn-secondary">Kthehu</a>
        </form>
    </div>
</body>
</html>