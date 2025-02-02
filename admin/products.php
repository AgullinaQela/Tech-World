<?php
session_start();

// Kontrollo nëse përdoruesi është admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}

require_once '../Database.php';
$db = new Database();
$products = $db->getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - TechWORLD</title>
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="admin-dashboard">
        <div class="dashboard-header">
            <h1>Manage Products</h1>
            <div class="dashboard-nav">
                <a href="dashboard.php">Dashboard</a>
                <a href="../index.php">Home</a>
                <a href="../logout.php">Logout</a>
            </div>
        </div>

        <?php if (isset($_SESSION['success'])): ?>
            <div class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
        <?php endif; ?>

        <div class="section">
            <div class="section-header">
                <h2>All Products</h2>
                <a href="add_product.php" class="btn">Add New Product</a>
            </div>
            
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Price</th>
                            <th>Added By</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product): ?>
                        <tr>
                            <td>
                                <img src="../uploads/<?php echo htmlspecialchars($product['image']); ?>" 
                                     alt="<?php echo htmlspecialchars($product['name']); ?>"
                                     class="product-thumb">
                            </td>
                            <td><?php echo htmlspecialchars($product['name']); ?></td>
                            <td><?php echo htmlspecialchars($product['description']); ?></td>
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
    </div>
</body>
</html> 