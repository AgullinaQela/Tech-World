<?php
$servername = "localhost";
$username = "root"; // Ndryshoje nëse është e nevojshme
$password = ""; // Ndryshoje nëse është e nevojshme
$dbname = "techworldproject";

$conn = new mysqli($servername, $username, $password, $dbname);

// Kontrollo lidhjen
if ($conn->connect_error) {
    die("Lidhja me bazën e të dhënave dështoi: " . $conn->connect_error);
}
?>