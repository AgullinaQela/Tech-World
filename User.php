<?php
class User {
    private $conn;
    private $table_name = "users"; 

    
    public function __construct($db) {
        $this->conn = $db;
    }

    
    public function register($username, $email, $password) {
       
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Email already exists."; 
        }

        
        $query = "INSERT INTO " . $this->table_name . " (username, email, password, role) VALUES (:username, :email, :password, 'user')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return true; 
        } else {
            return "Failed to register."; 
        }
    }

    
    public function login($email, $password) {
        /
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

           
            if (password_verify($password, $user['password'])) {
                return $user; 
            }
        }
        return null; 
    }
}
?>