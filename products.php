<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "techworldproject";

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Lidhja dështoi: " . $conn->connect_error);
}

$sql = "INSERT INTO products (name, price, image) VALUES
('Lenovo ThinkPad P1 Gen 4', 850.00, 'Images/14458.png'),
('Laptop HP Zbook Fury G7 15', 670.00, 'Images/1111.png'),
('Laptop MSI Thin 15 B12UCX', 700.00, 'Images/dfrt.png'),
('Laptop DELL NB Vostro 3530', 540.00, 'Images/gywbdfuhd.png'),
('Laptop HP Probook', 500.00, 'Images/hjhjhj.png'),
('Laptop DELL Latitude', 370.00, 'Images/Recovered_SHABLLONI-FINAL.png')";

if ($conn->query($sql) === TRUE) {
    echo "Produktet u shtuan me sukses!";
} else {
    echo "Gabim: " . $conn->error;
}

$conn->close();
?>
