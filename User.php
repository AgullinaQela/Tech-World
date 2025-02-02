<?php
class User {
    private $conn;
    
    public function __construct($db) {
        $this->conn = $db;
    }
    
    public function register($username, $email, $password) {
        try {
            // Kontrollo nëse email-i ekziston
            $check_email = $this->conn->prepare("SELECT id FROM users WHERE email = ?");
            $check_email->bind_param("s", $email);
            $check_email->execute();
            $email_result = $check_email->get_result();
            
            if ($email_result->num_rows > 0) {
                $check_email->close();
                return "Ky email është regjistruar tashmë!";
            }
            $check_email->close();
            
            // Kontrollo nëse username ekziston
            $check_username = $this->conn->prepare("SELECT id FROM users WHERE username = ?");
            $check_username->bind_param("s", $username);
            $check_username->execute();
            $username_result = $check_username->get_result();
            
            if ($username_result->num_rows > 0) {
                $check_username->close();
                return "Ky username është marrë tashmë!";
            }
            $check_username->close();
            
            // Krijo përdoruesin e ri
            $insert = $this->conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'user')");
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert->bind_param("sss", $username, $email, $hashed_password);
            
            if ($insert->execute()) {
                $insert->close();
                return true;
            }
            
            $insert->close();
            return "Gabim gjatë regjistrimit";
            
        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }
    
    public function login($username, $password) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($user = $result->fetch_assoc()) {
                if (password_verify($password, $user['password'])) {
                    $_SESSION['user_id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $stmt->close();
                    return true;
                }
            }
            
            $stmt->close();
            return false;
            
        } catch (Exception $e) {
            return false;
        }
    }
}
?>