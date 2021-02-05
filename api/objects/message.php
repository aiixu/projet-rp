<?php 
    class Message
    {
        // database connection and table name
        private $conn;
        private $table_name = "messages";

        // object properties
        public $id;
        public $sender_id;
        public $receiver_id;
        public $text;
        public $date;

        // constructor with $db as database connection
        public function __construct($db)
        {
          $this->conn = $db;
        }

        public function create()
        {
          // sanitize
          $this->sender_id = htmlspecialchars(strip_tags($this->sender_id));
          $this->receiver_id = htmlspecialchars(strip_tags($this->receiver_id));
          $this->text = addslashes(htmlspecialchars(strip_tags($this->text)));
          $this->date = date("Y-m-d H:i:s");
      
          // query to insert message
          $query = "INSERT
                    INTO
                      `$this->table_name`
                    SET
                      `sender_id`   = '$this->sender_id',
                      `receiver_id` = '$this->receiver_id',
                      `text`        = '$this->text',
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

        // get specific message
        public function getOne()
        {
          // query to get the message
          $query = "SELECT
                      `sender_id`,
                      `receiver_id`,
                      `text`,
                      `date`
                    FROM
                      `$this->table_name`
                    WHERE
                      `id` = '$this->id'";

          // prepare query
          $stmt = $this->conn->prepare($query);

          // execute query
          $stmt->execute();

          // get retrieved row
          $row = $stmt->fetch(PDO::FETCH_ASSOC);

          if(!isset($row["sender_id"]))
          {
            return false;
          }

          $this->sender_id   = $row["sender_id"];
          $this->receiver_id = $row["receiver_id"];
          $this->text        = $row["text"];
          $this->date        = $row["date"];

          return true;
        }

        // delete message
        public function delete()
        {
          // sanitize
          $this->id = htmlspecialchars(strip_tags($this->id));

          $query = "DELETE
                    FROM
                      `$this->table_name`
                    WHERE
                      `id` = $this->id";

          // prepare query
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          
          // execute query
          return $stmt->rowCount() != 0;
        }
    }
?>