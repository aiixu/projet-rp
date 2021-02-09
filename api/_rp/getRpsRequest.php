<?php
    include_once "api/config/core.php";

    include_once "api/objects/rp.php";

    include_once "api/shared/utilities.php";
    include_once "api/shared/responseModel.php";

    class GetRpsRequest
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
            
            $rp = new Rp($this->db);

            $from_record_num = ($records_per_page * $request->page) - $records_per_page;

            // query rps
            $stmt = $rp->search($request->query, $from_record_num, $records_per_page);

            $num = $stmt->rowCount();
            $count = $rp->searchCount($request->query);

            $response = new GetRpsResponseModel();

            // check if table isn't empty
            if($num > 0)
            {
                // rps array
                $response->rps = array();
                $response->pages = array();

                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    // extract row
                    extract($row);

                    $response_rp = new GetRpsRpResponseModel();

                    $response_rp->is_public = $is_public;
                    $response_rp->content = $content;
                    $response_rp->title = $title;
                    $response_rp->date = $date;

                    array_push($response->rp, $response_rp->getObject());
                }
    
                // include paging
                $page_url = $home_url . "rp?";
                if($request->query !== "")
                {
                    $page_url .= "q=$request->query&";
                }

                $paging = Utilities::getPaging($request->page, $count, $records_per_page, $page_url);
                
                $response->pages = $paging;
                $response->code = 200; // Ok
                $response->content = $response->getObject();
            }
            else
            {
                $response->code = 404; // Not Found
                $response->content = array("message" => "No rps found.");
            }

            return $response->emit();
        }
    }
    
    class GetRpsRequestModel
    {
        public $page;
        public $query;
        public $user_id;
    }

    // Response
    class GetRpsResponseModel extends ResponseModel
    {
        public $rps;
        public $pages;
    }
    
    // Response
    class GetRpsRpResponseModel extends ResponseModel
    {
        public $is_public;
        public $content;
        public $title;
        public $date;
    }
?>