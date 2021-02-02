<?php
    include_once "api/objects/ticket.php";
    include_once "api/shared/responseModel.php";

    class CreateTicketRequest
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
                echo json_encode(array("message" => "Unable to create ticket. Request is incomplete."));

                return false;
            }
            
            $ticket = new Ticket($this->db);

            $ticket->sender_mail = $request->sender_mail;
            $ticket->sender_name = $request->sender_name;
            $ticket->message = $request->message;

            $response = new CreateTicketResponseModel();

            // create the ticket
            if($ticket->create())
            {
                $response->id = $ticket->id;

                $response->code = 201; // Created
                $response->content = $response->getObject();
            }
            // if unable to create the ticket, tell the user
            else
            {
                $response->code = 503; // Service unavailable
                $response->content = array("message" => "Unable to create ticket.");
            }

            return $response->emit();
        }
    }

    // Request
    class CreateTicketRequestModel
    {
        public $sender_mail;
        public $sender_name;
        public $message;

        public function validateData()
        {
            return 
                isset($this->sender_mail) && 
                isset($this->sender_name) && 
                isset($this->message);
        }
    }
    
    // Response
    class CreateTicketResponseModel extends ResponseModel
    {
        public $id;
    }
?>