<?php
    include_once "api/shared/responseModel.php";

    class LogoutUserRequest
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
                echo json_encode(array("message" => "Unable to logout. Request is incomplete."));

                return false;
            }

            $user  = new User($this->db);
            $user->username = $request->username;

            $response = new LogoutUserResponseModel();
            $response->success = $user->logout();

            // create the message
            if($response->success)
            {
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

    class LogoutUserRequestModel
    {
        public $username;

        public function validateData()
        {
            return
                isset($this->username);
        }
    }

    class LogoutUserResponseModel extends ResponseModel
    {
        public $success;
    }
?>