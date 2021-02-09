<?php
    class ResponseModel
    {
        public $_code;
        public $_content;

        public function emit()
        {
            http_response_code($this->_code);
            echo json_encode($this->_content);

            return $this;
        }

        public function getObject()
        {
            $arr = array();
            foreach($this as $key => $value)
            {
                if($key === "_code" || $key === "_content") { continue; }
                $arr[$key] = $value;
            }

            return $arr;
        }
    }
?>