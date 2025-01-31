<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = pastroTeDhena($conn, $_POST['name']);
    $price = pastroTeDhena($conn, $_POST['price']);
    
    $te_dhenat = array(
        'name' => $name,
        'price' => $price
    );
    
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "Images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $te_dhenat['image'] = $target_file;
        }
    }
    
    if(perditesoTeDhena($conn, 'products', $te_dhenat, "id = $id")) {
        header("Location: admin_products.php");
        exit();
    }
} else {
    $id = $_GET['id'];
    $result = lexoTeDhena($conn, 'products', "WHERE id = $id");
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Ndrysho Produkt</title>
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
        .current-image {
            max-width: 200px;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Ndrysho Produkt</h2>
        
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
            <a href="admin_products.php" class="btn" style="background-color: #666;">Kthehu</a>
        </form>
    </div>
</body>
</html>