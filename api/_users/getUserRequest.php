<?php
    include_once "api/objects/user.php";
    include_once "api/shared/responseModel.php";

    class GetUserRequest
    {
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }

        public function get($request)
        {
            $user = new User($this->db);    
            $user->id = $request->id;
            $user->getOne();

            $response = new GetUserResponseModel();

            if(isset($user->username))
            {
                $response->username = $user->username;
                $response->is_public = $user->is_public;
                $response->profile_picture = $user->profile_picture;

                if($user->is_public)
                {
                    $response->first_name = $user->first_name;
                    $response->last_name = $user->last_name;
                }
            
                $response->_code = 200; // Ok
                $response->_content = $response->getObject();
            }
            else
            {
                $response->_code = 404; // Service unavailable
                $response->_content = array("message" => "User does not exist.");
            }
            
            return $response->emit();
        }
    }
    
    // Request
    class GetUserRequestModel
    {
        public $id;
    }

    // Response
    class GetUserResponseModel extends ResponseModel
    { 
        public $username;
        public $is_public;
        public $profile_picture;

        public $first_name;
        public $last_name;
    }
?>