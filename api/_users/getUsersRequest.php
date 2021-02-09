<?php
    include_once "api/config/core.php";

    include_once "api/objects/user.php";

    include_once "api/shared/utilities.php";
    include_once "api/shared/responseModel.php";

    class GetUsersRequest
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
            
            $user = new User($this->db);

            $from_record_num = ($records_per_page * $request->page) - $records_per_page;

            // query users
            $stmt = $user->search($request->query, $from_record_num, $records_per_page);

            $num = $stmt->rowCount();
            $count = $user->searchCount($request->query);

            $response = new GetUsersResponseModel();

            // check if table isn't empty
            if($num > 0)
            {
                // users array
                $response->users = array();
                $response->pages = array();

                // retrieve our table contents
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
                {
                    // extract row
                    extract($row);

                    $response_user = new GetUsersUserResponseModel();

                    $response_user->username = $username;
                    $response_user->is_public = $is_public;
                    $response_user->profile_picture = $profile_picture;

                    if($is_public)
                    {
                        $response_user->first_name = $first_name;
                        $response_user->last_name = $last_name;
                    }

                    array_push($response->users, $response_user->getObject());
                }
    
                // include paging
                $page_url = $home_url . "users?";
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
                $response->_content = array("message" => "No users found.");
            }

            return $response->emit();
        }
    }
    
    class GetUsersRequestModel
    {
        public $page;
        public $query;
    }

    // Response
    class GetUsersResponseModel extends ResponseModel
    {
        public $users;
        public $pages;
    }
    
    // Response
    class GetUsersUserResponseModel extends ResponseModel
    {
        public $username;
        public $is_public;
        public $profile_picture;

        public $first_name;
        public $last_name;
    }
?>