<?php
    include_once "api/objects/user.php";
    include_once "api/shared/responseModel.php";

    class CreateUserRequest
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
                echo json_encode(array("message" => "Unable to create user. Request is incomplete."));

                return false;
            }
            
            $user = new User($this->db);

            $user->username = $request->username;
            $user->email = $request->email;
            $user->password_hash = md5($request->password_hash);
            $user->is_public = $request->is_public;
            $user->profile_picture = $request->profile_picture;

            if(isset($request->first_name) & isset($request->last_name))
            {
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
            }

            $response = new CreateUserResponseModel();

            // create the user
            if($user->create())
            {
                $response->id = $user->id;

                $response->_code = 201; // Created
                $response->_content = $response->getObject();
            }
            // if unable to create the user, tell the user
            else
            {
                $response->_code = 503; // Service unavailable
                $response->_content = array("message" => "Unable to create user.");
            }

            return $response->emit();
        }
    }

    // Request
    class CreateUserRequestModel
    {
        public $username;
        public $email;
        public $is_public;
        public $password_hash;
        public $profile_picture;

        public $first_name;
        public $last_name;

        public function validateData()
        {
            return 
                isset($this->username) && 
                isset($this->email) && 
                isset($this->is_public) && 
                isset($this->password_hash);
        }
    }
    
    // Response
    class CreateUserResponseModel extends ResponseModel
    {
        public $id;
    }
?>