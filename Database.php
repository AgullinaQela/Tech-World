<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'techworldproject';
    private $username = 'root'; 
    private $password = ''; 
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, 
            $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

    public function emailExists($email) {
        $sql = "SELECT COUNT(*) FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function registerUser($name, $email, $password, $role = 'user') {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        $stmt->bindParam(':role', $role);
        return $stmt->execute();
    }

    public function loginUser($email, $password) {
        try {
            $sql = "SELECT * FROM users WHERE email = :email";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();
            
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if ($user && password_verify($password, $user['password'])) {
                return $user;
            }
            return false;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllProducts() {
        $sql = "SELECT p.*, u.name as added_by 
                FROM products p 
                LEFT JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addProduct($name, $description, $price, $image, $userId) {
        $sql = "INSERT INTO products (name, description, price, image, user_id) 
                VALUES (:name, :description, :price, :image, :user_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    public function updateProduct($id, $name, $description, $price, $image) {
        $sql = "UPDATE products 
                SET name = :name, description = :description, 
                    price = :price, image = :image 
                WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':image', $image);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $sql = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getProductById($id) {
        $sql = "SELECT p.*, u.name as added_by 
                FROM products p 
                LEFT JOIN users u ON p.user_id = u.id 
                WHERE p.id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDashboardStats() {
        $stats = [];
     
        $sql = "SELECT COUNT(*) as total FROM products";
        $stmt = $this->conn->query($sql);
        $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
        
        $sql = "SELECT COUNT(*) as total FROM users";
        $stmt = $this->conn->query($sql);
        $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
        
       
        $sql = "SELECT p.*, u.name as added_by 
                FROM products p 
                LEFT JOIN users u ON p.user_id = u.id 
                ORDER BY p.created_at DESC LIMIT 5";
        $stmt = $this->conn->query($sql);
        $stats['latest_products'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        
        $sql = "SELECT * FROM users ORDER BY created_at DESC LIMIT 5";
        $stmt = $this->conn->query($sql);
        $stats['latest_users'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        return $stats;
    }
}
?>
