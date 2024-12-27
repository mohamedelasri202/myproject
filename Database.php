<?php

class Database {
    private $host = 'localhost'; 
    private $db_name = 'voyage_agency'; 
    private $username = 'root'; 
    private $password = ''; 
    public $conn; 

    public function connect() {
        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset=utf8";
        $this->conn = new PDO($dsn, $this->username, $this->password);
        
    
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        if (!$this->conn) {
            echo "wallo gha ktrwan";
            return null;
        }
        
        echo "kayna awda a hadak";
        return $this->conn;
    }
}

?>
