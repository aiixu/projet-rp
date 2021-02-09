<?php
    include_once "api/objects/user.php";
    include_once "api/shared/responseModel.php";

    class UpdateUserRequest
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
            
            $response = new UpdateUserResponseModel();

            if(isset($request->username)) { $user->username = $request->username; }
            if(isset($request->is_public)) { $user->is_public = $request->is_public; }
            if(isset($request->password_hash)) { $user->password_hash = $request->password_hash; }
            if(isset($request->profile_picture)) { $user->profile_picture = $request->profile_picture; }

            if($user->update())
            {
                $response->_code = 200; // Ok
                $response->_content = array("message" => "User updated.");
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
    class UpdateUserRequestModel
    {
        public $username;
        public $is_public;
        public $profile_picture;

        public $first_name;
        public $last_name;
    }

    // Response
    class UpdateUserResponseModel extends ResponseModel
    {}
?>