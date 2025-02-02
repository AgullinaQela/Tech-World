<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit();
}
?>
<header>
    <div class="navbar">
        <h1 class="logo">TechWORLD</h1>
        <button class="hamburger" onclick="toggleMenu()">☰</button>
        <nav>
            <ul>
                <li><a href="dashboard.php" <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'class="active"' : ''; ?>>Dashboard</a></li>
                <li><a href="admin_products.php" <?php echo basename($_SERVER['PHP_SELF']) == 'admin_products.php' ? 'class="active"' : ''; ?>>Manage Products</a></li>
                <li><a href="products.php">View Site</a></li>
                <li><a href="users.php" <?php echo basename($_SERVER['PHP_SELF']) == 'users.php' ? 'class="active"' : ''; ?>>Users</a></li>
                <li>
                    <span class="user-name">Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </div>
</header> 