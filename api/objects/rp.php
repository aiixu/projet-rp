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
                      `user_id`,
                      `is_public`,
                      `content`,
                      `title`
                    FROM
                      $this->table_name
                    WHERE
                      `id` = $this->id";
                      
          // prepare query statement
          $stmt = $this->conn->prepare($query);

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

        // get all Rps
        function getAll()
        {
          // query to select all Rps and order y their date
          $query = "SELECT
                      `id`,
                      `user_id`,
                      `is_public`,
                      `content`,
                      `title`
                    FROM
                      `$this->table_name`
                    ORDER BY
                      `date` ASC";
          // prepare query statement
          $stmt = $this->conn->prepare($query);
          
          // execute query
          $stmt->execute();

          return $stmt;
        }
        // create Rp
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
        echo $query;
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

        // delete Rp
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
          $stmt = $this->conn->prepare($query);

          // execute query
          if($stmt->execute())
          {
            return true;
          }

          return false;
        }

        // search products
        function search($keywords, $from_record_num, $records_per_page)
        {
          //sanitize
          $keywords = htmlspecialchars(strip_tags($keywords));
          $keywords = "%{$keywords}%";

          // select all query
          $query = "SELECT
                      `user_id`,
                      `is_public`,
                      `content`,
                      `title`
                    FROM
                      `$this->table_name`
                    WHERE
                      `title` LIKE '$keywords'
                    ORDER BY
                      `date` ASC
                    LIMIT ?, ?";

          // prepare query statement
          $stmt = $this->conn->prepare($query);

          // bind variable values
          $stmt->bindParam(1, $from_record_num, PDO::PARAM_INT);
          $stmt->bindParam(2, $records_per_page, PDO::PARAM_INT);

          // execute query
          $stmt->execute();

          return $stmt;
        }

        public function searchCount($keywords)
        {
          // sanitize
          $keywords = htmlspecialchars(strip_tags($keywords));
          $keywords = "%{$keywords}%";

          // select all query
          $query = "SELECT
                      `user_id`,
                      `is_public`,
                      `content`,
                      `title`
                    FROM
                      `$this->table_name`
                    WHERE
                      `user_id` LIKE '$keywords' OR
                      `is_public` LIKE '$keywords'";

          $stmt = $this->conn->prepare($query);
          $stmt->execute();

          return $stmt->rowCount();
        }
    }
?>