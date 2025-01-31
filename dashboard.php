<?php
session_start();
require_once 'config.php';
require_once 'Admin.php';
require_once 'admin-check.php';

$admin = new Admin($conn);

// Merr statistikat
$totalProducts = $admin->getTotalProducts();
$totalUsers = $admin->getTotalUsers();
$recentProducts = $admin->getRecentProducts();
$recentUsers = $admin->getRecentUsers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
        }

        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #2c3e50;
            color: white;
            padding: 20px;
        }

        .sidebar-header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #34495e;
        }

        .sidebar-menu {
            margin-top: 20px;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 15px;
            color: white;
            text-decoration: none;
            transition: 0.3s;
            border-radius: 5px;
            margin-bottom: 5px;
        }

        .menu-item:hover, .menu-item.active {
            background: #34495e;
        }

        .menu-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: 20px;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .welcome-text {
            font-size: 24px;
            color: #2c3e50;
        }

        /* Stats Cards */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            text-align: center;
        }

        .stat-card i {
            font-size: 40px;
            color: #3498db;
            margin-bottom: 10px;
        }

        .stat-card h3 {
            font-size: 24px;
            color: #2c3e50;
            margin: 10px 0;
        }

        .stat-card p {
            color: #7f8c8d;
        }

        /* Recent Activity */
        .recent-activity {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 20px;
        }

        .activity-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .activity-card h2 {
            color: #2c3e50;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f4f4f4;
        }

        .activity-list {
            list-style: none;
        }

        .activity-item {
            padding: 10px 0;
            border-bottom: 1px solid #f4f4f4;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .logout-btn {
            background: #e74c3c;
            color: white;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            font-size: 14px;
        }

        .logout-btn:hover {
            background: #c0392b;
        }

        @media (max-width: 768px) {
            .dashboard-container {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
                position: sticky;
                top: 0;
                z-index: 1000;
            }

            .recent-activity {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="sidebar-header">
                <h2>Admin Panel</h2>
            </div>
            <div class="sidebar-menu">
                <a href="dashboard.php" class="menu-item active">
                    <i class="fas fa-home"></i> Dashboard
                </a>
                <a href="manage-products.php" class="menu-item">
                    <i class="fas fa-box"></i> Products
                </a>
                <a href="manage-users.php" class="menu-item">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="index.php" class="menu-item">
                    <i class="fas fa-globe"></i> View Site
                </a>
                <a href="admin-logout.php" class="menu-item">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <div class="welcome-text">
                    Welcome back, <?php echo htmlspecialchars($adminDetails['username']); ?>!
                </div>
                <a href="admin-logout.php" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>

            <div class="stats-container">
                <div class="stat-card">
                    <i class="fas fa-box"></i>
                    <h3><?php echo $totalProducts; ?></h3>
                    <p>Total Products</p>
                </div>
                <div class="stat-card">
                    <i class="fas fa-users"></i>
                    <h3><?php echo $totalUsers; ?></h3>
                    <p>Total Users</p>
                </div>
            </div>

            <div class="recent-activity">
                <div class="activity-card">
                    <h2>Recent Products</h2>
                    <ul class="activity-list">
                        <?php foreach ($recentProducts as $product): ?>
                        <li class="activity-item">
                            <span><?php echo htmlspecialchars($product['name']); ?></span>
                            <span>$<?php echo number_format($product['price'], 2); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="activity-card">
                    <h2>Recent Users</h2>
                    <ul class="activity-list">
                        <?php foreach ($recentUsers as $user): ?>
                        <li class="activity-item">
                            <span><?php echo htmlspecialchars($user['username']); ?></span>
                            <span><?php echo date('d M Y', strtotime($user['created_at'])); ?></span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>