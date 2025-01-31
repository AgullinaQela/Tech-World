<?php
include 'config.php';

// Marrja e të gjitha produkteve
$sql = "SELECT * FROM products";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Menaxho Produktet</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .admin-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }
        .admin-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .admin-table th, .admin-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .admin-table th {
            background-color: #f4f4f4;
        }
        .btn-add {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            display: inline-block;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .btn-edit {
            background-color: #2196F3;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
        }
        .btn-delete {
            background-color: #f44336;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            border-radius: 4px;
        }
        .product-image {
            max-width: 100px;
            height: auto;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h2>Menaxho Produktet</h2>
        <a href="admin_add_product.php" class="btn-add">Shto Produkt të Ri</a>
        
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Imazhi</th>
                    <th>Emri</th>
                    <th>Çmimi</th>
                    <th>Veprime</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td><img src='" . $row['image'] . "' class='product-image' alt='" . $row['name'] . "'></td>";
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>€" . number_format($row['price'], 2) . "</td>";
                        echo "<td>
                                <a href='admin_edit_product.php?id=" . $row['id'] . "' class='