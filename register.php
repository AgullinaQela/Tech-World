<?php
include_once 'Database.php';
include_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $db = new Database();
    $connection = $db->getConnection();
    $user = new User($connection);

    
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $password = $_POST['password'];

   
    if ($user->register($name, $surname, $email, $password)) {
        header("Location: login.php"); 
        exit;
    } else {
        echo "Error registering user!";
    }
}
?>

<form action="register.php" method="POST">
    Name: <input type="text" name="name" required><br>
    Surname: <input type="text" name="surname" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>