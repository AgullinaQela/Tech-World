<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = pastroTeDhena($conn, $_POST['name']);
    $price = pastroTeDhena($conn, $_POST['price']);
    
    $target_dir = "Images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image = $target_file;
        
        $te_dhenat = array(
            'name' => $name,
            'price' => $price,
            'image' => $image
        );
        
        if(shtoTeDhena($conn, 'products', $te_dhenat)) {
            header("Location: admin_products.php");
            exit();
        } else {
            $error = "Gabim gjatë shtimit të produktit.";
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
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Shto Produkt të Ri</h2>
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        
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
            <a href="admin_products.php" class="btn" style="background-color: #666;">Kthehu</a>
        </form>
    </div>
</body>
</html>