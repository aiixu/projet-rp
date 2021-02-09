<?php
    include_once "api/shared/responseModel.php";
    include_once "api/objects/message.php";

    class GetMessageRequest
    {
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }

        public function get($request)
        {
            $message = new Message($this->db);
            $message->id = $request->id;
            
            $response = new GetMessageResponseModel();

            if($message->getOne())
            {
                $response->sender_id   = $message->sender_id;
                $response->receiver_id = $message->receiver_id;
                $response->text        = $message->text;
                $response->date        = $message->date;

                $response->_code = 200; // Ok
                $response->_content = $response->getObject();
            }
            else
            {
                $response->_code = 404; // Not found
                $response->_content = array("message" => "Message doesn't exists.");
            }

            return $response->emit();
        }
    }

    class GetMessageRequestModel
    {
        public $id;
    }

    class GetMessageResponseModel extends ResponseModel
    {
        public $sender_id;
        public $receiver_id;
        public $text;
        public $date;
    }
?>