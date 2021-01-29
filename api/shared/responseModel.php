<?php
    class ResponseModel
    {
        public $code;
        public $content;

        public function emit()
        {
            http_response_code($this->code);
            echo json_encode($this->content);

            return $this;
        }

        public function getObject()
        {
            $arr = array();
            foreach($this as $key => $value)
            {
                if($key === "code" || $key === "content") { continue; }
                $arr[$key] = $value;
            }

            return $arr;
        }
    }
?>