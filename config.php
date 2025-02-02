<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'techworldproject';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}


$conn->exec("SET NAMES 'utf8'");


function shtoTeDhena($conn, $tabela, $te_dhenat) {
    $kolonat = implode(", ", array_keys($te_dhenat));
    $vlerat = "'" . implode("', '", array_values($te_dhenat)) . "'";
    $sql = "INSERT INTO $tabela ($kolonat) VALUES ($vlerat)";
    return $conn->exec($sql);
}

function lexoTeDhena($conn, $tabela, $kushti = "") {
    $sql = "SELECT * FROM $tabela $kushti";
    return $conn->query($sql);
}

function perditesoTeDhena($conn, $tabela, $te_dhenat, $kushti) {
    $updates = array();
    foreach($te_dhenat as $kolona => $vlera) {
        $updates[] = "$kolona = '$vlera'";
    }
    $updates = implode(", ", $updates);
    $sql = "UPDATE $tabela SET $updates WHERE $kushti";
    return $conn->exec($sql);
}

function fshiTeDhena($conn, $tabela, $kushti) {
    $sql = "DELETE FROM $tabela WHERE $kushti";
    return $conn->exec($sql);
}
?>