<?php
    class Category
    {
        // database connection and table name
        private $conn;
        private $table_name = "categories";
    
        // object properties
        public $id;
        public $name;
        public $is_parent;
        public $parent_id;
    
        // constructor with $db as database connection
        public function __construct($db)
        {
          $this->conn = $db;
        }
    }
?>