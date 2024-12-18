<?php
class Database {
    // private $host = "sql103.byethost7.com"; // MySQL Host Name
    // private $port = "3306"; // MySQL Port
    // private $db_name = "b7_37926105_baochaumobile2"; // Database Name
    // private $username = "b7_37926105"; // MySQL Username
    // private $password = "mychau0910"; // MySQL Password
    // private $conn;
    private $host = "localhost";
    private $port = "3306";
    private $db_name = "baochaumobile";
    private $username = "root";
    private $password = "";
    private $conn;
    public function connect() {
        $this->conn = null;

        try {
            // DSN với host và cổng MySQL
            $dsn = "mysql:host={$this->host};port={$this->port};dbname={$this->db_name};charset=utf8mb4";            
            $this->conn = new PDO($dsn, $this->username, $this->password);

            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->conn->exec("SET NAMES utf8mb4");
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }

        return $this->conn;
    }
}

// Sử dụng lớp Database để kết nối
$db = new Database();
$pdo = $db->connect();
?>
