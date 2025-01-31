<?php
session_start();
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}

// Handle product deletion
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    // Add deletion logic here
}

// Fetch products from database
$sql = "SELECT * FROM products ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <div class="dashboard-container">
        <button class="sidebar-toggle">☰</button>
        
        <aside class="dashboard-sidebar">
            <div class="sidebar-header">
                <h2>Admin Dashboard</h2>
            </div>
            <nav class="sidebar-menu">
                <ul>
                    <li><a href="dashboard.php" class="menu-item"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="manage-products.php" class="menu-item active"><i class="fas fa-shopping-cart"></i> Products</a></li>
                    <li><a href="manage-users.php" class="menu-item"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="manage-orders.php" class="menu-item"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                    <li><a href="settings.php" class="menu-item"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><a href="logout.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="dashboard-content">
            <div class="content-header">
                <h1>Manage Products</h1>
                <button class="dashboard-btn btn-primary" onclick="location.href='add-product.php'">
                    <i class="fas fa-plus"></i> Add New Product
                </button>
            </div>

            <div class="table-container">
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Category</th>
                            <th>Stock</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td><img src='" . htmlspecialchars($row['image']) . "' alt='Product' style='width: 50px; height: 50px; object-fit: cover;'></td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>$" . number_format($row['price'], 2) . "</td>";
                                echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                                echo "<td>" . $row['stock'] . "</td>";
                                echo "<td>
                                        <button class='dashboard-btn btn-edit' onclick='location.href=\"edit-product.php?id=" . $row['id'] . "\"'>Edit</button>
                                        <form method='POST' style='display: inline;' onsubmit='return confirm(\"Are you sure you want to delete this product?\");'>
                                            <input type='hidden' name='product_id' value='" . $row['id'] . "'>
                                            <button type='submit' name='delete_product' class='dashboard-btn btn-delete'>Delete</button>
                                        </form>
                                    </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='7' style='text-align: center;'>No products found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

    <script>
        // Toggle sidebar on mobile
        document.querySelector('.sidebar-toggle').addEventListener('click', function() {
            document.querySelector('.dashboard-sidebar').classList.toggle('active');
        });

        // Close sidebar when clicking outside on mobile
        document.addEventListener('click', function(event) {
            const sidebar = document.querySelector('.dashboard-sidebar');
            const toggle = document.querySelector('.sidebar-toggle');
            
            if (!sidebar.contains(event.target) && !toggle.contains(event.target)) {
                sidebar.classList.remove('active');
            }
        });
    </script>
</body>
</html>