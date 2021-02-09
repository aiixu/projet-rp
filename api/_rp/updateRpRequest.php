<?php
    include_once "api/objects/user.php";
    include_once "api/shared/responseModel.php";

    class UpdateRpRequest
    {
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }

        public function get($request)
        {
            $user = new Rp($this->db);    
            $user->id = $request->id;
            
            $response = new UpdateRpResponseModel();

            if(isset($request->user_id)) { $user->user_id = $request->user_id; }
            if(isset($request->is_public)) { $user->is_public = $request->is_public; }
            if(isset($request->content)) { $user->content = $request->content; }
            if(isset($request->title)) { $user->title = $request->title; }

            if($user->update())
            {
                $response->code = 200; // Ok
                $response->content = array("message" => "Rp updated.");
            }
            else
            {
                $response->code = 404; // Service unavailable
                $response->content = array("message" => "Rp does not exist.");
            }
            
            return $response->emit();
        }
    }
    
    // Request
    class UpdateRpRequestModel
    {
        public $user_id;
        public $is_public;
        public $title;
        public $content;
        // public $first_name;
        // public $last_name;
    }

    // Response
    class UpdateRpResponseModel extends ResponseModel
    {}
?>