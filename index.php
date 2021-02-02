<?php
    include "api/Route.php";

    include "api/_users/createUserRequest.php";
    include "api/_users/getUsersRequest.php";
    include "api/_users/getUserRequest.php";
    include "api/_users/updateUserRequest.php";
    include "api/_users/deleteUserRequest.php";

    include "api/_tickets/createTicketRequest.php";
    include "api/_tickets/getTicketsRequest.php";
    include "api/_tickets/getTicketRequest.php";
    include "api/_tickets/deleteTicketRequest.php";

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

        if(isset($_GET["p"]))
        {
            $request_model->page = $_GET["p"];
        }

        if(isset($_GET["q"]))
        {
            $request_model->query = $_GET["q"];
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

        if(isset($_GET["p"]))
        {
            $request_model->page = $_GET["p"];
        }

        if(isset($_GET["q"]))
        {
            $request_model->query = $_GET["q"];
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

    Route::run("/");
?>