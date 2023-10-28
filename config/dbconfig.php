<?php
class Database {
    private $host = "localhost";
    private $dbname = "im2_3d";
    private $user = "root";
    private $pass = "";

    private $conn;
    private $state;
    private $errMsg;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->state = true;
            $this->errMsg = "Connected successfully!";
        } catch (PDOException $e) {
            $this->errMsg=("Connection failed: " . $e->getMessage());
            $this->state = false;
        }
    }

    public function dbConn() {
        return $this->conn;
    }

    public function dbState() {
        return $this->state;
    }

    public function errMsg() {
        return $this->errMsg;
    }
}
