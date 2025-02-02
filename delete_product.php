<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM products WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Produkti u fshi me sukses!";
    } else {
        echo "Gabim: " . $conn->error;
    }
}

header("Location: products.php");
?>
