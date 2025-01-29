<?php
class Database {
    private $host = 'localhost'; // Adresa e serverit (zakonisht localhost)
    private $dbname = 'techworldproject'; // Emri i bazës së të dhënave
    private $username = 'root'; // Përdoruesi (default për MySQL është "root")
    private $password = ''; // Fjalëkalimi (default për MySQL është bosh)
    private $conn;

    public function __construct() {
        try {
            // Krijimi i lidhjes me PDO
            $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Aktivizon raportimin e gabimeve
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }
}
?>