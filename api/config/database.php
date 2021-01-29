<?php
    class Database
    {
        // db informations
        private $host = "localhost";
        private $db_name = "rpproject";
        private $username = "root";
        private $password = "";

        public $conn;
    
        // get connection to db
        public function getConnection()
        {
            $this->conn = null;
    
            try
            {
                // connect to db with provided informations
                $this->conn = new PDO("mysql:host=$this->host;dbname=$this->db_name", $this->username, $this->password);
                $this->conn->exec("set names utf8");
            }
            catch(PDOException $exception)
            {
                $message = $exception->getMessage();
                echo "Connection error: $message";
            }
    
            return $this->conn;
        }
    }
?>