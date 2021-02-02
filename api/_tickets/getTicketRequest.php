<?php
    include_once "api/objects/ticket.php";
    include_once "api/shared/responseModel.php";

    class GetTicketRequest
    {
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }

        public function get($request)
        {
            $ticket = new Ticket($this->db);    
            $ticket->id = $request->id;
            $ticket->getOne();

            $response = new GetTicketResponseModel();

            if(isset($ticket->sender_mail))
            {
                $response->sender_mail = $ticket->sender_mail;
                $response->sender_name = $ticket->sender_name;
                $response->message = $ticket->message;

                $response->code = 200; // Ok
                $response->content = $response->getObject();
            }
            else
            {
                $response->code = 404; // Service unavailable
                $response->content = array("message" => "The ticket does not exist.");
            }
            
            return $response->emit();
        }
    }
    
    // Request
    class GetTicketRequestModel
    {
        public $id;
    }

    // Response
    class GetTicketResponseModel extends ResponseModel
    { 
        public $sender_mail;
        public $sender_name;
        public $message;
    }
?>