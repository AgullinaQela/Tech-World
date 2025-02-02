<?php
$servername = "localhost";
$username = "root";  
$password = "";     
$database = "product_db";

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Lidhja me databazën dështoi: " . $conn->connect_error);
}
?>
