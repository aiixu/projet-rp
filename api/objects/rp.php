<?php 
    class Rp
    {
        // database connection and table name
        private $conn;
        private $table_name = "rp";

        // object properties
        public $id;
        public $user_id;
        public $is_public;
        public $content;
        public $title;
        public $date;

        // constructor with $db as database connection
        public function __construct($db)
        {
          $this->conn = $db;
        }
    
        function create()
        {
          // sanitize
          $this->user_id = htmlspecialchars(strip_tags($this->user_id));
          $this->is_public = htmlspecialchars(strip_tags($this->is_public));
          $this->title = htmlspecialchars(strip_tags($this->title));
          $this->content = htmlspecialchars(strip_tags($this->content));
          $this->date = date("Y-m-d H:i:s"); // 2021-02-08 15:05:54
          
          // query to insert user
          $query = "INSERT 
                    INTO
                      `$this->table_name`
                    SET
                      `user_id`   = '$this->user_id',
                      `is_public` = '$this->is_public',
                      `title`     = '$this->title',
                      `content`   = '$this->content',
                      `date`      = '$this->date'";

          // prepare query
          $stmt = $this->conn->prepare($query);
          
          // execute query
          if($stmt->execute())
          {
            $this->id = intval($this->conn->lastInsertId());

            return true;
          }
          
          return false;
        }
    }
?>