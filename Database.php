<?php
class Database {
    private $host = 'localhost';
    private $dbname = 'techworldproject';
    private $username = 'root'; 
    private $password = ''; 
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->dbname}", 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            // Për debugging
            error_log("Database connection successful");
        } catch (PDOException $e) {
            error_log("Connection failed: " . $e->getMessage());
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
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);
            $stmt->bindParam(':role', $role);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Register error: " . $e->getMessage());
            return false;
        }
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
            error_log("Login error: " . $e->getMessage());
            return false;
        }
    }

    public function getUserById($id) {
        try {
            $sql = "SELECT * FROM users WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get user error: " . $e->getMessage());
            return false;
        }
    }

    public function getAllProducts() {
        try {
            $sql = "SELECT * FROM products ORDER BY id DESC";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get products error: " . $e->getMessage());
            return [];
        }
    }

    public function addProduct($name, $price, $image) {
        try {
            $sql = "INSERT INTO products (name, price, image) VALUES (:name, :price, :image)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            $stmt->bindParam(':image', $image);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Add product error: " . $e->getMessage());
            return false;
        }
    }

    public function updateProduct($id, $name, $price, $image = null) {
        try {
            $sql = "UPDATE products SET name = :name, price = :price";
            if ($image) {
                $sql .= ", image = :image";
            }
            $sql .= " WHERE id = :id";
            
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':price', $price);
            if ($image) {
                $stmt->bindParam(':image', $image);
            }
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Update product error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteProduct($id) {
        try {
            $sql = "DELETE FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } catch (PDOException $e) {
            error_log("Delete product error: " . $e->getMessage());
            return false;
        }
    }

    public function getProductById($id) {
        try {
            $sql = "SELECT * FROM products WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get product error: " . $e->getMessage());
            return false;
        }
    }

    public function getDashboardStats() {
        try {
            $stats = [];
         
            // Total products
            $sql = "SELECT COUNT(*) as total FROM products";
            $stmt = $this->conn->query($sql);
            $stats['total_products'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Total users
            $sql = "SELECT COUNT(*) as total FROM users";
            $stmt = $this->conn->query($sql);
            $stats['total_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
            
            // Latest products
            $sql = "SELECT * FROM products ORDER BY id DESC LIMIT 5";
            $stmt = $this->conn->query($sql);
            $stats['latest_products'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            // Latest users
            $sql = "SELECT * FROM users ORDER BY id DESC LIMIT 5";
            $stmt = $this->conn->query($sql);
            $stats['latest_users'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            return $stats;
        } catch (PDOException $e) {
            error_log("Get stats error: " . $e->getMessage());
            return [
                'total_products' => 0,
                'total_users' => 0,
                'latest_products' => [],
                'latest_users' => []
            ];
        }
    }
}
?>