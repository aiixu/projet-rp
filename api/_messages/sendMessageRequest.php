<?php
    include_once "api/shared/responseModel.php";
    include_once "api/objects/message.php";

    class SendMessageRequest
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
                echo json_encode(array("message" => "Unable to create message. Request is incomplete."));

                return false;
            }

            $message = new Message($this->db);

            $message->sender_id = $request->sender_id;
            $message->receiver_id = $request->receiver_id;
            $message->text = $request->text;

            $response = new SendMessageResponseModel();

            // create the message
            if($message->create())
            {
                // success
                $response->id = $message->id;

                $response->code = 201; // created
                $response->content = $response->getObject();
            }
            else
            {
                // fail
                $response->code = 503; // service unavailable
                $response->content = array("message" => "Unable to send the message.");
            }

            return $response->emit();
        }
    }

    // request
    class SendMessageRequestModel
    {
        public $sender_id;
        public $receiver_id;
        public $text;

        public function validateData()
        {
            return 
                isset($this->sender_id) &&
                isset($this->receiver_id) &&
                isset($this->text);
        }
    }

    // response
    class SendMessageResponseModel extends ResponseModel
    {
        public $id;
    }
?>



