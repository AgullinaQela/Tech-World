<?php
session_start();
require_once 'config.php';

// Check if user is logged in and is admin
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
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
                    <li><a href="#" class="menu-item active"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="#" class="menu-item"><i class="fas fa-shopping-cart"></i> Products</a></li>
                    <li><a href="#" class="menu-item"><i class="fas fa-users"></i> Users</a></li>
                    <li><a href="#" class="menu-item"><i class="fas fa-shopping-bag"></i> Orders</a></li>
                    <li><a href="#" class="menu-item"><i class="fas fa-cog"></i> Settings</a></li>
                    <li><a href="logout.php" class="menu-item"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="dashboard-content">
            <div class="content-header">
                <h1>Dashboard Overview</h1>
                <div class="user-info">
                    <span>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
                </div>
            </div>

            <div class="stats-container">
                <div class="stat-card">
                    <h3>Total Products</h3>
                    <div class="stat-value">150</div>
                </div>
                <div class="stat-card">
                    <h3>Total Users</h3>
                    <div class="stat-value">1,240</div>
                </div>
                <div class="stat-card">
                    <h3>Total Orders</h3>
                    <div class="stat-value">450</div>
                </div>
                <div class="stat-card">
                    <h3>Total Revenue</h3>
                    <div class="stat-value">$15,350</div>
                </div>
            </div>

            <div class="table-container">
                <h2>Recent Orders</h2>
                <table class="dashboard-table">
                    <thead>
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Product</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>#12345</td>
                            <td>John Doe</td>
                            <td>Product Name</td>
                            <td>$99.99</td>
                            <td>Completed</td>
                            <td>
                                <button class="dashboard-btn btn-edit">Edit</button>
                                <button class="dashboard-btn btn-delete">Delete</button>
                            </td>
                        </tr>
                        <!-- Add more rows as needed -->
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