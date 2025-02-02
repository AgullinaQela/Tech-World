<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $action = $_POST['action'];

    if ($action == "add") {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];

        $stmt = $conn->prepare("INSERT INTO products (name, price, image) VALUES (?, ?, ?)");
        $stmt->bind_param("sds", $name, $price, $image);
        $stmt->execute();
        header("Location: admin_dashboard.php");
    } 
    elseif ($action == "update") {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $image = $_POST['image'];

        $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image=? WHERE id=?");
        $stmt->bind_param("sdsi", $name, $price, $image, $id);
        $stmt->execute();
        header("Location: admin_dashboard.php");
    } 
    elseif ($action == "delete") {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM products WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: admin_dashboard.php");
    }
}
?>
