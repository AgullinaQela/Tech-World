<?php
class User {
    private $conn;
    private $table_name = "users"; // Emri i tabelës që mban përdoruesit

    // Konstruktori që merr lidhjen me databazën
    public function __construct($db) {
        $this->conn = $db;
    }

    // Funksioni për regjistrimin e përdoruesit
    public function register($username, $email, $password) {
        // Hasho fjalëkalimin
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        // Kontrollo nëse email-i ekziston tashmë
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return "Email already exists."; // Kthe mesazhin nëse email-i ekziston
        }

        // Shto përdoruesin në databazë
        $query = "INSERT INTO " . $this->table_name . " (username, email, password, role) VALUES (:username, :email, :password, 'user')";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);

        if ($stmt->execute()) {
            return true; // Kthe true nëse regjistrimi është i suksesshëm
        } else {
            return "Failed to register."; // Kthe mesazhin nëse regjistrimi ka dështuar
        }
    }

    // Funksioni për autentifikimin e përdoruesit
    public function login($email, $password) {
        // Gjej përdoruesin në databazë me email-in
        $query = "SELECT * FROM " . $this->table_name . " WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() === 1) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Kontrollo nëse fjalëkalimi është i saktë
            if (password_verify($password, $user['password'])) {
                return $user; // Kthe përdoruesin nëse fjalëkalimi është i saktë
            }
        }
        return null; // Kthe null nëse nuk ka përdorues ose fjalëkalimi është gabim
    }
}
?>