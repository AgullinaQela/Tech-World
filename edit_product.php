<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    // Kontrollojmë nëse është ngarkuar një imazh i ri
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "Images/";
        $target_file = $target_dir . basename($_FILES["image"]["name"]);
        
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            $image = $target_file;
            $sql = "UPDATE products SET name='$name', price=$price, image='$image' WHERE id=$id";
        }
    } else {
        $sql = "UPDATE products SET name='$name', price=$price WHERE id=$id";
    }
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='alert alert-success'>Produkti u përditësua me sukses!</div>";
        header("Location: products.php");
    } else {
        echo "<div class='alert alert-danger'>Gabim: " . $conn->error . "</div>";
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id=$id";
    $result = $conn->query($sql);
    $product = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ndrysho Produkt</title>
    <style>
        .form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .form-container div {
            margin-bottom: 15px;
        }
        .current-image {
            max-width: 200px;
            margin: 10px 0;
        }
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Ndrysho Produkt</h2>
        <form method="post" action="edit_product.php" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
            
            <div>
                <label>Emri i Produktit:</label>
                <input type="text" name="name" value="<?php echo $product['name']; ?>" required>
            </div>
            
            <div>
                <label>Çmimi:</label>
                <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>
            </div>
            
            <div>
                <label>Imazhi Aktual:</label><br>
                <img src="<?php echo $product['image']; ?>" class="current-image" alt="Imazhi aktual">
            </div>
            
            <div>
                <label>Ndrysho Imazhin (opsionale):</label>
                <input type="file" name="image">
            </div>
            
            <div>
                <button type="submit">Ruaj Ndryshimet</button>
                <a href="products.php">Kthehu</a>
            </div>
        </form>
    </div>
</body>
</html>