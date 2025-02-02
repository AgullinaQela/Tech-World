<?php
session_start();

// Kontrollo nëse përdoruesi është i loguar dhe është admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../Database.php';
$db = new Database();
$stats = $db->getDashboardStats();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - TechWORLD</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <h1>Admin Dashboard</h1>
            <div class="dashboard-nav">
                <a href="../index.php">Home</a>
                <a href="../products.php">Products</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-box"></i>
                <h3>Total Products</h3>
                <p><?php echo $stats['total_products']; ?></p>
                <a href="add_product.php" class="btn">Add New Product</a>
            </div>
            
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <h3>Total Users</h3>
                <p><?php echo $stats['total_users']; ?></p>
            </div>
        </div>

        <div class="section">
            <h2>Latest Products</h2>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Added By</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['latest_products'] as $product): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td>€<?php echo number_format($product['price'], 2); ?></td>
                            <td><?php echo htmlspecialchars($product['added_by']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($product['created_at'])); ?></td>
                            <td>
                                <a href="edit_product.php?id=<?php echo $product['id']; ?>" 
                                   class="btn-small btn-edit">Edit</a>
                                <a href="delete_product.php?id=<?php echo $product['id']; ?>" 
                                   class="btn-small btn-delete" 
                                   onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="section">
            <h2>Latest Users</h2>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stats['latest_users'] as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['name']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>" 
                                   class="btn-small btn-edit">Edit</a>
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" 
                                   class="btn-small btn-delete" 
                                   onclick="return confirm('Are you sure?')">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html> 