<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>Test Database Connection</h2>";

try {
    $conn = new PDO("mysql:host=localhost;dbname=techworldproject", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully to database<br>";
    
    // Test if users table exists
    $result = $conn->query("SHOW TABLES LIKE 'users'");
    if($result->rowCount() > 0) {
        echo "Table 'users' exists<br>";
    } else {
        echo "Table 'users' does not exist<br>";
    }
    
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

echo "<h2>POST Data</h2>";
if($_POST) {
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";
} else {
    echo "No POST data received";
}
?>

<h2>Test Registration Form</h2>
<form action="test.php" method="POST">
    Name: <input type="text" name="name"><br>
    Email: <input type="email" name="email"><br>
    Password: <input type="password" name="password"><br>
    <button type="submit">Test Register</button>
</form> 