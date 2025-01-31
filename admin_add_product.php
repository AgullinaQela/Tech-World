<?php
// Lidhja me bazën e të dhënave
include('db_connection.php');

// Kontrollo nëse është dërguar formulari
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $price = $_POST['price'];
    
    // Rruga për të ngarkuar imazhin
    $image = 'Images/' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], $image);

    // Query për të shtuar produktin në bazën e të dhënave
    $sql = "INSERT INTO products (name, price, image) VALUES ('$name', '$price', '$image')";
    
    // Ekzekuto query dhe kontrollo nëse është ekzekutuar me sukses
    if ($conn->query($sql) === TRUE) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . $conn->error;
    }
    
    // Mbyll lidhjen me bazën e të dhënave
    $conn->close();
}
?>
