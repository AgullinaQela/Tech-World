<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    $sql = "INSERT INTO users (name, email, age) VALUES ('$name', '$email', $age)";
    if ($conn->query($sql) === TRUE) {
        echo "Përdoruesi u shtua me sukses!";
    } else {
        echo "Gabim: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Shto Përdorues</title>
</head>
<body>
    <h2>Shto Përdorues</h2>
    <form method="post" action="create.php">
        Emri: <input type="text" name="name" required><br>
        Email: <input type="email" name="email" required><br>
        Mosha: <input type="number" name="age" required><br>
        <input type="submit" value="Shto">
    </form>
</body>
</html>