<?php
    include_once "api/shared/crudObjectBase.php";

    class Rp extends CrudObjectBase
    {
        public function __construct($conn)
        {
            parent::__construct($conn, "");
        }
    }
?>