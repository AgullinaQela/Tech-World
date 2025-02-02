<?php
include 'db.php';

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    $sql = "UPDATE products SET name='$name', price='$price', image='$image' WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        echo "Produkti u përditësua me sukses!";
    } else {
        echo "Gabim: " . $conn->error;
    }
}

header("Location: products.php");
?>
