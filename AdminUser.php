<?php
class AdminUser {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function isAdmin($user_id) {
        $stmt = $this->conn->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        return $result && $result['role'] === 'admin';
    }
    
    public function getUserDetails($user_id) {
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
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
    
    public function getAllUsers() {
        $result = $this->conn->query("SELECT id, username, email, role FROM users ORDER BY id DESC");
        return $result->fetch_all(MYSQLI_ASSOC);
    }
    
    public function updateUserRole($user_id, $new_role) {
        $stmt = $this->conn->prepare("UPDATE users SET role = ? WHERE id = ?");
        $stmt->bind_param("si", $new_role, $user_id);
        return $stmt->execute();
    }
    
    public function deleteUser($user_id) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ? AND role != 'admin'");
        $stmt->bind_param("i", $user_id);
        return $stmt->execute();
    }
    
    public function getProducts($limit = 10, $offset = 0) {
        $sql = "SELECT * FROM products ORDER BY id DESC LIMIT ? OFFSET ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ii", $limit, $offset);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public function addProduct($name, $description, $price, $image) {
        $sql = "INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("ssds", $name, $description, $price, $image);
        return $stmt->execute();
    }
    
    public function updateProduct($id, $name, $description, $price, $image = null) {
        if ($image) {
            $sql = "UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssdsi", $name, $description, $price, $image, $id);
        } else {
            $sql = "UPDATE products SET name = ?, description = ?, price = ? WHERE id = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bind_param("ssdi", $name, $description, $price, $id);
        }
        return $stmt->execute();
    }
    
    public function deleteProduct($id) {
        $stmt = $this->conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
    
    public function getProduct($id) {
        $stmt = $this->conn->prepare("SELECT * FROM products WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
}
?> 