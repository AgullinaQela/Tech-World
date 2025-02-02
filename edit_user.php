<?php
session_start();
require_once '../config.php';

// Krijo instancën e User
$user = new User($conn);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'] ?? 0;
    
    $data = [
        'name' => $_POST['name'],
        'email' => $_POST['email'],
        'role' => $_POST['role']
    ];

    if ($user->update($id, $data)) {
        $_SESSION['success'] = 'User updated successfully';
        header('Location: users.php');
        exit();
    } else {
        $_SESSION['error'] = 'Failed to update user';
    }
}

$id = $_GET['id'] ?? 0;
$userData = $user->getById($id);

if (!$userData) {
    $_SESSION['error'] = 'User not found';
    header('Location: users.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User - TechWORLD</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <?php include 'admin_header.php'; ?>

    <div class="admin-container">
        <h1>Edit User</h1>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger">
                <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                ?>
            </div>
        <?php endif; ?>

        <form method="post" class="admin-form">
            <input type="hidden" name="id" value="<?php echo $userData['id']; ?>">
            
            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo htmlspecialchars($userData['username']); ?>" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($userData['email']); ?>" required>
            </div>

            <div class="form-group">
                <label>Role:</label>
                <select name="role" required>
                    <option value="user" <?php echo $userData['role'] == 'user' ? 'selected' : ''; ?>>User</option>
                    <option value="admin" <?php echo $userData['role'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
                </select>
            </div>

            <div class="form-buttons">
                <button type="submit" class="btn-primary">Update User</button>
                <a href="users.php" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>