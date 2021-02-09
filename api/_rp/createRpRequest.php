<?php
    include_once "api/objects/rp.php";
    include_once "api/shared/responseModel.php";

    // [POST] /users/username/rp/id
    class CreateRpRequest
    {       
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }
    
        public function post($request)
        {
            if(!$request->validateData())
            {
                http_response_code(400);
                echo json_encode(array("message" => "Unable to create rp. Request is incomplete."));
    
                return false;
            }
            
            $rp = new Rp($this->db);
    
            $rp->user_id = $request->user_id;
            $rp->is_public= $request->is_public;
            $rp->content= $request->content;
            $rp->title= $request->title;
    
            $response = new CreateRpResponseModel();
         
            if($rp->create())
            {
                $response->id = $rp->id;

                $response->code = 201; // Created
                $response->content = $response->getObject();
            }
            // if unable to create the rp, tell the user
            else
            {
                $response->code = 503; // Service unavailable
                $response->content = array("message" => "Unable to create rp.");
            }

            return $response->emit();
        }
    }

    class CreateRpRequestModel
    {
        public $user_id;
        public $is_public;
        public $content;
        public $title;

        public function validateData()
        {
            return 
                isset($this->user_id) && 
                isset($this->is_public) && 
                isset($this->content) &&
                isset($this->title);
        }
    }
    
    // Response
    class CreateRpResponseModel extends ResponseModel
    {
        public $id;
    }
?>