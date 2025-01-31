<?php
include 'config.php';

// Kontrollojmë nëse po shtohet një produkt i ri
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    // Menaxhimi i ngarkimit të imazhit
    $target_dir = "Images/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image = $target_file;
        
        $sql = "INSERT INTO products (name, price, image) VALUES ('$name', $price, '$image')";
        if ($conn->query($sql) === TRUE) {
            echo "<div class='alert alert-success'>Produkti u shtua me sukses!</div>";
        } else {
            echo "<div class='alert alert-danger'>Gabim: " . $conn->error . "</div>";
        }
    }
}

// Marrja e të gjitha produkteve
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Menaxhimi i Produkteve</title>
    <style>
        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }
        .product-card {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: center;
        }
        .product-card img {
            max-width: 200px;
            height: auto;
        }
        .form-container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ddd;
        }
        .alert {
            padding: 10px;
            margin: 10px 0;
            border-radius: 4px;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>
<body>
    <h2>Shto Produkt të Ri</h2>
    <div class="form-container">
        <form method="post" action="products.php" enctype="multipart/form-data">
            <div>
                <label>Emri i Produktit:</label>
                <input type="text" name="name" required>
            </div>
            <div>
                <label>Çmimi:</label>
                <input type="number" step="0.01" name="price" required>
            </div>
            <div>
                <label>Imazhi:</label>
                <input type="file" name="image" required>
            </div>
            <button type="submit">Shto Produkt</button>
        </form>
    </div>

    <h2>Produktet Ekzistuese</h2>
    <div class="product-grid">
        <?php
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='product-card'>";
                echo "<img src='" . $row['image'] . "' alt='" . $row['name'] . "'>";
                echo "<h3>" . $row['name'] . "</h3>";
                echo "<p>Çmimi: $" . number_format($row['price'], 2) . "</p>";
                echo "<a href='edit_product.php?id=" . $row['id'] . "'>Ndrysho</a> | ";
                echo "<a href='delete_product.php?id=" . $row['id'] . "' onclick='return confirm(\"A jeni të sigurt?\")'>Fshi</a>";
                echo "</div>";
            }
        } else {
            echo "<p>Nuk ka produkte për të shfaqur.</p>";
        }
        ?>
    </div>
</body>
</html>