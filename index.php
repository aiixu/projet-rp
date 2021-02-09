<?php
    include "api/Route.php";

    include "api/_users/createUserRequest.php";
    include "api/_users/getUsersRequest.php";
    include "api/_users/getUserRequest.php";
    include "api/_users/updateUserRequest.php";
    include "api/_users/deleteUserRequest.php";
    include "api/_rp/createRpRequest.php";
    include "api/_tickets/createTicketRequest.php";
    include "api/_tickets/getTicketsRequest.php";
    include "api/_tickets/getTicketRequest.php";
    include "api/_tickets/deleteTicketRequest.php";
    
    include "api/_messages/sendMessageRequest.php";
    include "api/_messages/deleteMessageRequest.php";
    include "api/_messages/getMessageRequest.php";

    include "api/config/database.php";

    // from https://stackoverflow.com/questions/57901808/cors-preflight-request-doesnt-pass-access-control-check-it-does-not-have-http
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Methods: HEAD, GET, PUT, PATCH, DELETE, OPTIONS");
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
    header('Content-Type: application/json');

    if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") 
    {
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method,Access-Control-Request-Headers, Authorization");
        header("HTTP/1.1 200 OK");
        die();
    }
    
    /// USERS

    // auth 
    Route::add("/api/users/auth", function()
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        $body = json_decode(file_get_contents("php://input"));
        echo json_encode(array("success" => true, "token" => md5($body->username . "_" . date("Y-m-s h:i:s"))));
    }, "post");

    // create user
    Route::add("/api/users", function()
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new CreateUserRequestModel();

        $request_content = json_decode(file_get_contents("php://input"));

        $request_model->username = $request_content->username;
        $request_model->email = $request_content->email;  
        $request_model->is_public = $request_content->is_public;
        $request_model->password_hash = $request_content->password_hash;
        $request_model->profile_picture = $request_content->profile_picture;

        $request_model->first_name = $request_content->first_name;
        $request_model->last_name = $request_content->last_name;

        // create and send request
        $request = new CreateUserRequest($db);
        $request->post($request_model);
    }, "post");

    // get list of users
    Route::add("/api/users", function() 
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        $request_model = new GetUsersRequestModel();
        $request_model->page = 1;
        $request_model->query = "";

        if(isset($_GET["page"]))
        {
            $request_model->page = $_GET["page"];
        }

        if(isset($_GET["query"]))
        {
            $request_model->query = $_GET["query"];
        }

        // create and send request
        $request = new GetUsersRequest($db);
        $request->get($request_model);
    }, "get");

    // get specific user
    Route::add("/api/users/([0-9]*)", function($id) 
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new GetUserRequestModel();
        $request_model->id = $id;

        $request = new GetUserRequest($db);
        $request->get($request_model);
    }, "get");

    // get specific user
    Route::add("/api/users/([0-9]*)", function($id) 
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new UpdateUserRequestModel();
        $request_model->id = $id;
        
        $request_content = json_decode(file_get_contents("php://input"));

        if(isset($request_content->username)) { $request_model->username = $request_content->username; }
        if(isset($request_content->is_public)) { $request_model->is_public = $request_content->is_public; }
        if(isset($request_content->password_hash)) { $request_model->password_hash = $request_content->password_hash; }
        if(isset($request_content->profile_picture)) { $request_model->profile_picture = $request_content->profile_picture; }

        $req = new UpdateUserRequest($db);
        $req->get($request_model);
    }, "put");

    // delete specific user
    Route::add("/api/users/([0-9]*)", function($id) 
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new DeleteUserRequestModel();
        $request_model->id = $id;

        $request = new DeleteUserRequest($db);
        $request->delete($request_model);
    }, "delete");
    

    /// TICKETS

    // create ticket
    Route::add("/api/tickets", function()
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new CreateTicketRequestModel();

        $request_content = json_decode(file_get_contents("php://input"));

        $request_model->sender_mail = $request_content->sender_mail;
        $request_model->sender_name = $request_content->sender_name;  
        $request_model->message = $request_content->message;

        // create and send request
        $request = new CreateTicketRequest($db);
        $request->post($request_model);
    }, "post");

    // get list of tickets
    Route::add("/api/tickets", function() 
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        $request_model = new GetTicketsRequestModel();
        $request_model->page = 1;
        $request_model->query = "";

        if(isset($_GET["page"]))
        {
            $request_model->page = $_GET["page"];
        }

        if(isset($_GET["query"]))
        {
            $request_model->query = $_GET["query"];
        }

        // create and send request
        $request = new GetTicketsRequest($db);
        $request->get($request_model);
    }, "get");

    // get specific ticket
    Route::add("/api/tickets/([0-9]*)", function($id) 
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new GetTicketRequestModel();
        $request_model->id = $id;

        $request = new GetTicketRequest($db);
        $request->get($request_model);
    }, "get");

    // delete specific user
    Route::add("/api/tickets/([0-9]*)", function($id) 
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new DeleteTicketRequestModel();
        $request_model->id = $id;

        $request = new DeleteTicketRequest($db);
        $request->delete($request_model);
    }, "delete");

    // send message
    Route::add("/api/messages", function()
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new SendMessageRequestModel();
        
        // transfer json -> request model
        $request_content = json_decode(file_get_contents("php://input"));

        $request_model->sender_id = $request_content->sender_id;
        $request_model->receiver_id = $request_content->receiver_id;
        $request_model->text = $request_content->text;

        // send request
        $request = new SendMessageRequest($db);
        $request->post($request_model);
    }, "post");

    // delete message
    Route::add("/api/messages/([0-9]*)", function($id)
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new DeleteMessageRequestModel();
        $request_model->id = $id;

        // send request
        $request = new DeleteMessageRequest($db);
        $request->delete($request_model);
    }, "delete");

    // get specific message
    Route::add("/api/messages/([0-9]*)", function($id)
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new GetMessageRequestModel();
        $request_model->id = $id;

        // send request
        $request = new GetMessageRequest($db);
        $request->get($request_model);
    }, "get");

    // RP

    // create rp
    Route::add("/api/users/([0-9]*)/rps", function($id)
    {
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new CreateRpRequestModel();

        $request_content = json_decode(file_get_contents("php://input"));

        $request_model->user_id = $id;
        $request_model->title = $request_content->title;  
        $request_model->is_public = $request_content->is_public;
        $request_model->content = $request_content->content;

        // create and send request
        $request = new CreateRpRequest($db);
        $request->post($request_model);
    }, "post");

    // get rp
    Route::add("/api/users/([a-z-0-9-A-Z-]*)/rps/([0-9]*)", function($username, $idRp)
    {
        $database = new Database();
        $db = $database->getConnection();
        
        $request_model = new GetRpRequestModel();
        $request_model->id = $idRp;

        $request = new GetRpRequest($db);
        $request->get($request_model);
    }, "get");

    // get rps
    Route::add("/api/rps", function()
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        $request_model = new GetRpsRequestModel();
        $request_model->page = 1;
        $request_model->query = "";
        $request_model->user_id = -1;

        if(isset($_GET["page"]))
        {
            $request_model->page = $_GET["page"];
        }

        if(isset($_GET["query"]))
        {
            $request_model->query = $_GET["query"];
        }

        if(isset($_GET["user"]))
        {
            $request_model->user_id = $_GET["user"];
        }

        // create and send request
        $request = new GetRpsRequest($db);
        $request->get($request_model);
    }, "get");

    // update rp


    // delete rp
    Route::add("/api/rps/([0-9]*)",  function($idRp)
    {
        // connect to db
        $database = new Database();
        $db = $database->getConnection();

        // initialize request
        $request_model = new DeleteRpRequestModel();
        $request_model->id = $idRp;

        // send request
        $request = new DeleteRpRequest($db);
        $request->delete($request_model); 
    }, "delete");

    Route::run("/");
?>

