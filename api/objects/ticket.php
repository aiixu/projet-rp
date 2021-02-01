<?php
    class Ticket
    {
        // database connection and table name
        private $conn;
        private $table_name = "tickets";

        // object properties
        public $id;
        public $sender_name;
        public $sender_mail;
        public $message;
        public $date;

        // constructor with $db as database connection
        public function __construct($db)
        {
          $this->conn = $db;
        }

        // get specific ticket
        function getOne()
        {
          // query to get the ticket
          $query = "SELECT
                      `sender_name`,
                      `sender_mail`,
                      `message`,
                      `date`
                    FROM 
                      `$this->table_name`
                    WHERE 
                      `id` = '$this->id'";

          // prepare query statement
          $stmt = $this->conn->prepare($query);

          // execute query
          $stmt->execute();

          // get retrieved row
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if(!isset($row["sender_name"]))
          {
            return;
          }

          // set values to object properties
          $this->senderName = $row["sender_name"];
          $this->senderMail = $row["sender_mail"];
          $this->message = $row["message"];
          $this->date = $row["date"];
        }

        // get all tickets
        function getAll()
        {
          // query to select all tickets and order by their date
          $query = "SELECT 
                      `id`,
                      `sender_name`,
                      `sender_mail`,
                      `message`,
                      `date`
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
        
        // create user
        function create()
        {
          // sanitize
          $this->username = htmlspecialchars(strip_tags($this->username));
          $this->email = htmlspecialchars(strip_tags($this->email));
          $this->password_hash = htmlspecialchars(strip_tags($this->password_hash));
          $this->is_public = htmlspecialchars(strip_tags($this->is_public));
          $this->profile_picture = htmlspecialchars(strip_tags($this->profile_picture));
          
          if($this->first_name || $this->last_name)
          {
            try
            {
              $this->first_name = htmlspecialchars(strip_tags($this->first_name));
              $this->last_name = htmlspecialchars(strip_tags($this->last_name));
            }
            catch(Exception $e)
            {
              return false;
            }
          }
        
          // query to insert user
          $query = "INSERT 
                    INTO
                      `$this->table_name`
                    SET
                      `username`        = '$this->username',
                      `email`           = '$this->email',
                      `password_hash`   = '$this->password_hash',
                      `is_public`       = '$this->is_public',
                      `profile_picture` = '$this->profile_picture',
                      `first_name`      = '$this->first_name',
                      `last_name`       = '$this->last_name'";
      
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
          // sanitize
          $keywords = htmlspecialchars(strip_tags($keywords));
          $keywords = "%{$keywords}%";

          // select all query
          $query = "SELECT
                      `id`,
                      `username`,
                      `is_public`,
                      `profile_picture`,  
                      `first_name`,
                      `last_name`
                    FROM
                      `$this->table_name`
                    WHERE
                      `username` LIKE '$keywords' OR 
                      (`is_public` = 1 AND 
                      (`first_name` LIKE '$keywords' OR 
                       `last_name` LIKE '$keywords'))
                    ORDER BY
                      `username` ASC
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
                      `id`,
                      `username`,
                      `is_public`,
                      `profile_picture`,  
                      `first_name`,
                      `last_name`
                    FROM
                      `$this->table_name`
                    WHERE
                      `username` LIKE '$keywords' OR 
                      (`is_public` = 1 AND 
                      (`first_name` LIKE '$keywords' OR 
                       `last_name` LIKE '$keywords'))";

          $stmt = $this->conn->prepare($query);
          $stmt->execute();

          return $stmt->rowCount();
        }
    }
?>