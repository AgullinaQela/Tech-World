<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

$sql = "SELECT COUNT(*) as total FROM products";
$stmt = $conn->prepare($sql);
$stmt->execute();
$total_products = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$sql = "SELECT COUNT(*) as total FROM users";
$stmt = $conn->prepare($sql);
$stmt->execute();
$total_users = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

$sql = "SELECT * FROM products ORDER BY id DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->execute();
$latest_products = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM users ORDER BY id DESC LIMIT 5";
$stmt = $conn->prepare($sql);
$stmt->execute();
$latest_users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>


        <div class="latest-section">
            <div class="section-header">
                <h2>Latest Products</h2>
                <a href="admin_products.php" class="btn-add">
                    <i class="fas fa-plus"></i> Add New Product
                </a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($latest_products as $product): ?>
                            <tr>
                                <td>
                                    <img src="<?php echo htmlspecialchars($product['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($product['name']); ?>"
                                         class="product-thumbnail">
                                </td>
                                <td><?php echo htmlspecialchars($product['name']); ?></td>
                                <td>€<?php echo number_format($product['price'], 2); ?></td>
                                <td>
                                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" 
                                       class="btn-edit">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" 
                                       class="btn-delete"
                                       onclick="return confirm('Are you sure you want to delete this product?')">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="latest-section">
            <div class="section-header">
                <h2>Latest Users</h2>
                <a href="users.php" class="btn-view">View All Users</a>
            </div>
            <div class="table-responsive">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Joined Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($latest_users as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['name']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo ucfirst($user['role']); ?></td>
                                <td><?php echo date('M d, Y', strtotime($user['created_at'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer>
        <div class="footer-bottom">
            <p>&copy; 2024 TechWORLD Admin Panel. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>