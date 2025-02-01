<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); 
    exit;
    header("Location: login.html");
    exit();
}

echo "Welcome, " . $_SESSION['email'] . "!";
$userName = $_SESSION['user_name'];
$userRole = $_SESSION['user_role'];
?>
<a href="logout.php">Logout</a>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechWORLD - Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="dashboard">
        <h1>Mirë se erdhe, <?php echo htmlspecialchars($userName); ?>!</h1>
        <p>Roli juaj: <?php echo htmlspecialchars($userRole); ?></p>
        
        <?php if ($userRole == 'admin'): ?>
            <a href="admin/dashboard.php" class="btn">Admin Dashboard</a>
        <?php endif; ?>
        
        <a href="logout.php" class="btn">Dilni</a>
    </div>
</body>
</html>