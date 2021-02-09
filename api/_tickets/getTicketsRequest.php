<?php
    include_once "api/config/core.php";

    include_once "api/objects/ticket.php";

    include_once "api/shared/utilities.php";
    include_once "api/shared/responseModel.php";

    class GetTicketsRequest
    {       
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }

        function get($request)
        {    
            global $records_per_page;
            global $home_url;
            
            $ticket = new Ticket($this->db);

            $from_record_num = ($records_per_page * $request->page) - $records_per_page;

            // query tickets
            $stmt = $ticket->search($request->query, $from_record_num, $records_per_page);

            $num = $stmt->rowCount();
            $count = $ticket->searchCount($request->query);

            $response = new GetTicketsResponseModel();

            // check if table isn't empty
            if($num > 0)
            {
                // tickets array
                $response->tickets = array();
                $response->pages = array();

                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    // extract row
                    extract($row);

                    $response_ticket = new GetTicketsTicketResponseModel();

                    $response_ticket->sender_mail = $sender_mail;
                    $response_ticket->sender_name = $sender_name;
                    $response_ticket->message = $message;

                    array_push($response->tickets, $response_ticket->getObject());
                }
    
                // include paging
                $page_url = $home_url . "tickets?";
                if($request->query !== "")
                {
                    $page_url .= "query=$request->query&";
                }

                $paging = Utilities::getPaging($request->page, $count, $records_per_page, $page_url);
                
                $response->pages = $paging;
                $response->_code = 200; // Ok
                $response->_content = $response->getObject();
            }
            else
            {
                $response->_code = 404; // Not Found
                $response->_content = array("message" => "No tickets found.");
            }

            return $response->emit();
        }
    }
    
    class GetTicketsRequestModel
    {
        public $page;
        public $query;
    }

    // Response
    class GetTicketsResponseModel extends ResponseModel
    {
        public $tickets;
        public $pages;
    }
    
    // Response
    class GetTicketsTicketResponseModel extends ResponseModel
    {
        public $sender_mail;
        public $sender_name;
        public $message;
    }
?>