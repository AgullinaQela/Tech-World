<?php
require_once 'Database.php';

$db = new Database();

$name = "Agullina";
$email = "agullinaqela@gmail.com";
$password = "agullina123";
$role = "admin";

// Kontrollo nëse admin ekziston
if (!$db->emailExists($email)) {
    if ($db->registerUser($name, $email, $password, $role)) {
        echo "Admin u krijua me sukses!<br>";
        echo "Mund të logoheni me:<br>";
        echo "Email: agullinaqela@gmail.com<br>";
        echo "Password: agullina123";
    } else {
        echo "Gabim gjatë krijimit të admin!";
    }
} else {
    echo "Admin ekziston tashmë!<br>";
    echo "Mund të logoheni me:<br>";
    echo "Email: agullinaqela@gmail.com<br>";
    echo "Password: agullina123";
}
?>

<br><br>
<a href="login.php">Shko tek Login</a>