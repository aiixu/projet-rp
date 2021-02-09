<?php
    include_once "api/shared/responseModel.php";
    include_once "api/objects/rp.php";

    class GetRpRequest
    {
        private $db;

        function __construct($db)
        {
            $this->db = $db;
        }

        public function get($request)
        {
            $rp = new RP($this->db);
            $rp->id = $request->id;
            $rp->getOne();
            
            $response = new GetRpResponseModel();

            if(isset($rp->user_id))
            {
                $response->user_id = $rp->user_id;
                $response->is_public = $rp->is_public;
                $response->content = $rp->content;
                $response->title = $request->title;

                $response->code = 200; //Ok
                $response->content = $response->getObject();
            }
            else
            {
                $response->code = 404; // Not found
                $response->content = array("message" => "The RP does not exist.");
            }

            return $response->emit();
        }
    }

    // Request
    class GetRpRequestModel
    {
        public $id;
    }

    // Response
    class GetRpResponseModel extends ResponseModel
    {
        public $user_id;
        public $is_public;
        public $content;
        public $title;
    }
?>