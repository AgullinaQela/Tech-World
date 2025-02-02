<?php
if (!isset($_SESSION['admin_id'])) {
    header('Location: admin-login.php');
    exit();
}

require_once 'Admin.php';
$admin = new Admin($conn);
$adminDetails = $admin->getAdminDetails($_SESSION['admin_id']);

if (!$adminDetails) {
    session_destroy();
    header('Location: admin-login.php');
    exit();
}
?>