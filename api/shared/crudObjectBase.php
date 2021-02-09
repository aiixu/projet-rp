<?php
    include "api/Route.php";

    abstract class CrudObjectBase
    {
        private $conn;
        private $tableName;

        public function __construct($db, $tableName)
        {
            $this->conn = $conn;
            $this->tableName = $tableName;
        }

        public function bindGetOne($route, $fields)
        {
            $queryFields = "";

            foreach($fields as $field)
            {
                $queryFields .= $field;
            }

            echo $field;

            
        }

        private function fillFields()
        {
            
        }

        private function bind($route, $func, $method = "get")
        {
            Route::add($route, $func, $method);
        }
    }
?>