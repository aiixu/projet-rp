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
        
        // get specific rp
        function getOne()
        {
          // query to get the rp
          $query = "SELECT
                      'user_id',
                      'is_public',
                      'content',
                      'title'
                    From
                      '$this->table_name'
                    WHERE
                      'id' = '$this->id'";

          // prepare query statement
          $stmt = $this->db->prepare($query);

          // execute query
          $stmt->execute();

          // get retrieved row
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if($stmt->rowCount() == 0)
          {
            return;
          }
          
          // set values to object properties
          $this->user_id = $row["user_id"];
          $this->is_public = $row["is_public"];
          $this->content = $row["content"];
          $this->title = $row["title"];
          
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

        // delete user
        function delete()
        {
          // sanitize
          $this->id = htmlspecialchars(strip_tags($this->id));

          // delete query
          $query = "DELETE
                    FROM
                      `$this->table_name`
                    WHERE
                      `id` = $this->id";

          // prepare query
          $stmt = $this->db->prepare($query);

          // execute query
          if($stmt->execute())
          {
            return true;
          }

          return false;
        }
    }
?>