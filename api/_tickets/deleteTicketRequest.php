<?php
    include_once "api/objects/ticket.php";
    include_once "api/shared/responseModel.php";

    class DeleteTicketRequest
    {
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }

        public function delete($request)
        {
            $ticket = new Ticket($this->db);    
            $ticket->id = $request->id;

            $response = new DeleteTicketResponseModel();
            $response->success = $ticket->delete();

            if($ticket->delete())
            {
                $response->_code = 200; // Ok
                $response->_content = array("message" => "The ticket was deleted.", "success" => true);
            }
            // if unable to delete the ticket
            else
            {
                $response->_code = 503; // Service unavailable
                $response->_content = array("message" => "Unable to delete the ticket.", "success" => false);
            }
            
            return $response->emit();
        }
    }
    
    // Request
    class DeleteTicketRequestModel
    {
        public $id;
    }

    // Response
    class DeleteTicketResponseModel extends ResponseModel
    { 
        public $success;
    }
?>