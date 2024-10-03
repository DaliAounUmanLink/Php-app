<?php
class Database {
    private $host = "db";
    private $username = "user1";
    private $password = "123456";
    private $dbname = "db1";
    public $conn;

    public function connect() {
        // Create connection using MySQLi
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        
        return $this->conn;
    }
}
