<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image']; 

    $sql = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";

    if ($conn->query($sql) === TRUE) {
        echo "Produkti u shtua me sukses!";
    } else {
        echo "Gabim: " . $conn->error;
    }
}
?>

<form action="add_product.php" method="post">
    <label>Emri i produktit:</label>
    <input type="text" name="name" required>
    
    <label>Çmimi:</label>
    <input type="number" step="0.01" name="price" required>
    
    <label>Emri i imazhit (në folderin Images/):</label>
    <input type="text" name="image" required>
    
    <button type="submit">Shto Produkt</button>
</form>
