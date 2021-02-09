<?php
    include_once "api/shared/responseModel.php";
    include_once "api/objects/message.php";

    class DeleteMessageRequest
    {
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }

        public function delete($request)
        {
            $message = new Message($this->db);
            $message->id = $request->id;

            $response = new DeleteMessageResponseModel();
            $response->success = $message->delete();

            if($response->success)
            {
                $response->_code = 200; // Ok
                $response->_content = array("message" => "Message was deleted", "success" => true);
            }
            else
            {
                $response->_code = 503; // service unavailable
                $response->_content = array("message" => "Unable to delete message", "success" => false);
            }

            return $response->emit();
        }
    }

    class DeleteMessageRequestModel
    {
        public $id;
    }

    class DeleteMessageResponseModel extends ResponseModel
    {
        public $success;
    }
?>
