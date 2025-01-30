<?php
include 'config.php';

$id = $_GET['id'];

$sql = "DELETE FROM users WHERE id=$id";
if ($conn->query($sql) === TRUE) {
    echo "Përdoruesi u fshi me sukses!";
} else {
    echo "Gabim: " . $sql . "<br>" . $conn->error;
}
?>
<a href="read.php">Kthehu tek përdoruesit</a>