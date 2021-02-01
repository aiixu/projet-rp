<?php
    include_once "api/objects/user.php";
    include_once "api/shared/responseModel.php";

    class DeleteUserRequest
    {
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }

        public function delete($request)
        {
            $user = new User($this->db);    
            $user->id = $request->id;

            $response = new DeleteUserResponseModel();
            $response->success = $user->delete();

            if($user->delete())
            {
                $response->code = 200; // Ok
                $response->content = array("message" => "User was deleted.", "success" => true);
            }
            // if unable to delete the user
            else
            {
                $response->code = 503; // Service unavailable
                $response->content = array("message" => "Unable to delete user.", "success" => false);
            }
            
            return $response->emit();
        }
    }
    
    // Request
    class DeleteUserRequestModel
    {
        public $id;
    }

    // Response
    class DeleteUserResponseModel extends ResponseModel
    { 
        public $success;
    }
?>