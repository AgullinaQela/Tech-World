<?php
class Admin {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function getAdminDetails($admin_id) {
        $stmt = $this->conn->prepare("SELECT id, username, email FROM admin WHERE id = ?");
        $stmt->bind_param("i", $admin_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public function getTotalProducts() {
        $result = $this->conn->query("SELECT COUNT(*) as count FROM products");
        return $result->fetch_assoc()['count'];
    }
    
    public function getTotalUsers() {
        $result = $this->conn->query("SELECT COUNT(*) as count FROM users");
        return $result->fetch_assoc()['count'];
    }
    
    public function getRecentProducts($limit = 5) {
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function getRecentUsers($limit = 5) {
        $sql = "SELECT id, username, email, created_at FROM users ORDER BY id DESC LIMIT ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("i", $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>