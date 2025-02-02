<?php
session_start();
session_destroy();

header("Location: index.html");  
exit();


header("Location: admin-login.php");
exit();
?>

