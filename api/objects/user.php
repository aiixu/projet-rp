<?php
    include "api/config/core.php";

    class User
    {
        // database connection and table name
        private $conn;
        private $table_name = "users";
    
        // object properties
        public $id;
        public $username;
        public $email;
        public $password_hash;
        public $is_public;
        public $profile_picture;
        public $first_name;
        public $last_name;
    
        // constructor with $db as database connection
        public function __construct($db)
        {
          $this->conn = $db;
        }

        // get specific user
        function getOne()
        {
          // query to get the user
          $query = "SELECT
                      `username`,
                      `is_public`,
                      `profile_picture`,
                      `first_name`,
                      `last_name`
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

          if(!isset($row["username"]))
          {
            return;
          }

          // set values to object properties
          $this->username = $row["username"];
          $this->is_public = $row["is_public"];
          $this->profile_picture = $row["profile_picture"];
          $this->first_name = $row["first_name"];
          $this->last_name = $row["last_name"];
        }

        // get all users
        function getAll()
        {
          // query to select all users and order by their username
          $query = "SELECT 
                      `id`,
                      `username`,
                      `is_public`,
                      `profile_picture`,
                      `first_name`,
                      `last_name`
                    FROM 
                      `$this->table_name`
                    ORDER BY 
                      `username` ASC";

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

        // update user 
        function update()
        {
          $fields = "";

          function addField(&$fields, $fname, &$usrvar)
          {
            if(isset($usrvar))
            {
              $usrvar = htmlspecialchars(strip_tags($usrvar));
              $fields .= "`$fname` = '$usrvar',";
            }
          }

          addField($fields, "username", $this->username);
          addField($fields, "email", $this->email);
          addField($fields, "is_public", $this->is_public);
          addField($fields, "profile_picture", $this->profile_picture);
          
          //addField($fields, $this->first_name);
          //addField($fields, $this->last_name);

          $fields = rtrim($fields, ',');

          // update query
          $query = "UPDATE
                      `$this->table_name`
                    SET
                      $fields
                    WHERE
                      `id` = $this->id";

          // prepare query statement
          $stmt = $this->conn->prepare($query);

          if($stmt->execute())
          {
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
          global $levenshtein_max_dist;

          // sanitize
          $keywords = htmlspecialchars(strip_tags($keywords));
          $p_keywords = "%{$keywords}%";
          
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
                      `username` LIKE '$p_keywords' OR 
                       LEVENSHTEIN(`username`, '$keywords') BETWEEN 0 AND $levenshtein_max_dist OR
                      (`is_public` = 1 AND 
                      (`first_name` LIKE '$p_keywords' OR 
                       `last_name` LIKE '$p_keywords' OR
                       LEVENSHTEIN(`first_name`, '$keywords') BETWEEN 0 AND $levenshtein_max_dist OR
                       LEVENSHTEIN(`last_name`, '$keywords') BETWEEN 0 AND $levenshtein_max_dist))
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
          global $levenshtein_max_dist;
          
          // sanitize
          $keywords = htmlspecialchars(strip_tags($keywords));
          $p_keywords = "%{$keywords}%";

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
                      `username` LIKE '$p_keywords' OR 
                       LEVENSHTEIN(`username`, '$keywords') BETWEEN 0 AND $levenshtein_max_dist OR
                      (`is_public` = 1 AND 
                      (`first_name` LIKE '$p_keywords' OR 
                       `last_name` LIKE '$p_keywords' OR
                       LEVENSHTEIN(`first_name`, '$keywords') BETWEEN 0 AND $levenshtein_max_dist OR
                       LEVENSHTEIN(`last_name`, '$keywords') BETWEEN 0 AND $levenshtein_max_dist))";
        
          $stmt = $this->conn->prepare($query);
          $stmt->execute();
          
          return $stmt->rowCount();
        }

        public function checkLogin()
        {
          $query = "SELECT
                      `id`
                    FROM
                      `$this->table_name`
                    WHERE
                      `username` = '$this->username' AND
                      `password_hash` = '$this->password_hash'";

          $stmt = $this->conn->prepare($query);
          $stmt->execute();

          if($stmt->rowCount() > 0)
          {
            // get retrieved row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $this->id = $row["id"];
            $this->getOne();

            return true;
          }

          return false;
        }

        public function login($token, $expiration_date)
        {
          // query to insert user
          $query = "INSERT 
                    INTO
                      `users_tokens`
                    SET
                      `id`         = '$this->id',
                      `username`   = '$this->username',
                      `token`      = '$token',
                      `expiration` = '$expiration_date'";
                       
          // prepare query
          $stmt = $this->conn->prepare($query);
          
          // execute query
          return $stmt->execute();
        }

        public function logout()
        {
          // delete query
          $query = "DELETE 
                    FROM 
                      `users_tokens` 
                    WHERE 
                      `username` = '$this->username'";

          // prepare query
          $stmt = $this->conn->prepare($query);

          // execute query
          return $stmt->execute();
        }
    }
?>
