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

          if($stmt->rowCount() == 0)
          {
            return;
          }

          // set values to object properties
          $this->sender_name = $row["sender_name"];
          $this->sender_mail = $row["sender_mail"];
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
          $this->sender_mail = htmlspecialchars(strip_tags($this->sender_mail));
          $this->sender_name = htmlspecialchars(strip_tags($this->sender_name));
          $this->message = htmlspecialchars(strip_tags($this->message));
          $this->date = date("Y-m-d H:i:s");
          
          // query to insert user
          $query = "INSERT 
                    INTO
                      `$this->table_name`
                    SET
                      `sender_mail` = '$this->sender_mail',
                      `sender_name` = '$this->sender_name',
                      `message`     = '$this->message',
                      `date`        = '$this->date'";

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
                      `sender_mail`,
                      `sender_name`,
                      `message`,
                      `date` 
                    FROM
                      `$this->table_name`
                    WHERE
                      `sender_mail` LIKE '$keywords' OR 
                      `sender_name` LIKE '$keywords'
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
                      `sender_mail`,
                      `sender_name`,
                      `message`,
                      `date` 
                    FROM
                      `$this->table_name`
                    WHERE
                      `sender_mail` LIKE '$keywords' OR 
                      `sender_name` LIKE '$keywords'";

          $stmt = $this->conn->prepare($query);
          $stmt->execute();

          return $stmt->rowCount();
        }
    }
?>