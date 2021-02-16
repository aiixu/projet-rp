<?php
    include_once "api/shared/responseModel.php";

    class LoginUserRequest
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
                echo json_encode(array("message" => "Unable to login. Request is incomplete."));

                return false;
            }

            $user  = new User($this->db);

            $user->username = $request->username;
            $user->password_hash = $request->password_hash;

            $response = new LoginUserResponseModel();
            $response->success = $user->checkLogin();

            // create the message
            if($response->success)
            {
                $response_user = new LoginUserResponseUserModel();

                $response_user->id = $user->id;

                $response_user->username = $user->username;
                $response_user->is_public = $user->is_public;
                $response_user->profile_picture = $user->profile_picture;

                $response_user->first_name = $user->first_name;
                $response_user->last_name = $user->last_name;

                $response->user = $response_user->getObject();

                $response->token = md5($response_user->username . date("d-m-Y H:i:s"));
                $response->expiration_date = date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s') . ' + 20 days'));

                try {
                    $user->logout();
                } 
                catch (Exception $e) { }
                $user->logout();
                $user->login($response->token, $response->expiration_date);

                $response->_code = 201; // created
                $response->_content = $response->getObject();
            }
            else
            {
                // fail
                $response->_code = 400; // bad request
                $response->_content = array("message" => "Can't login.", "success" => false);
            }

            return $response->emit();
        }
    }

    class LoginUserRequestModel
    {
        public $username;
        public $password_hash;

        public function validateData()
        {
            return
                isset($this->username) &&
                isset($this->password_hash);
        }
    }

    class LoginUserResponseModel extends ResponseModel
    {
        public $success;
        public $user;
        public $token;
        public $expiration_date;
    }
    
    class LoginUserResponseUserModel extends ResponseModel
    {
        public $id;
        public $username;
        public $is_public;
        public $profile_picture;

        public $first_name;
        public $last_name;
    }
?>