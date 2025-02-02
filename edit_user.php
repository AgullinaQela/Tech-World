<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.html");
    exit();
}
require_once '../Database.php';
$db = new Database();
$userId = $_GET['id'] ?? null;
if (!$userId) {
    header("Location: dashboard.php");
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $role = $_POST['role'];
    if ($db->updateUser($userId, $name, $email, $role)) {
        $_SESSION['success'] = "Përdoruesi u përditësua me sukses!";
    } else {
        $_SESSION['error'] = "Ndodhi një gabim gjatë përditësimit!";
    }
    header("Location: dashboard.php");
    exit();
}
$user = $db->getUserById($userId);
if (!$user) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edito Përdoruesin - Admin Dashboard</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="admin-form">
        <h2>Edito Përdoruesin</h2>
        <form method="POST">
            <div class="form-group">
                <label>Emri:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            </div>
            <div class="form-group">
                <label>Roli:</label>
                <select name="role">
                    <option value="user" <?php echo $user['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo $user['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>
            <button type="submit" class="btn">Ruaj Ndryshimet</button>
            <a href="dashboard.php" class="btn btn-secondary">Kthehu</a>
        </form>
    </div>
</body>
</html> 