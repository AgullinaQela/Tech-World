<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];

    $sql = "UPDATE users SET name='$name', email='$email', age=$age WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Përdoruesi u përditësua me sukses!";
    } else {
        echo "Gabim: " . $sql . "<br>" . $conn->error;
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT * FROM users WHERE id=$id";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Përditëso Përdorues</title>
</head>
<body>
    <h2>Përditëso Përdorues</h2>
    <form method="post" action="update.php">
        <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
        Emri: <input type="text" name="name" value="<?php echo $user['name']; ?>" required><br>
        Email: <input type="email" name="email" value="<?php echo $user['email']; ?>" required><br>
        Mosha: <input type="number" name="age" value="<?php echo $user['age']; ?>" required><br>
        <input type="submit" value="Përditëso">
    </form>
</body>
</html>