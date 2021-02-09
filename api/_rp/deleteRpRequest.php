<?php
    include_once "api/objects/rp.php";
    include_once "api/shared/responseModel.php";

    class DeleteRpRequest
    {
        private $db;

        function __construct($conn)
        {
            $this->db = $conn;
        }

        public function delete($request)
        {
            $rp = new Rp($this->db);
            $rp->id = $request->id;

            $response = new DeleteRpResponseModel();
            $response->success = $rp->delete();

            if($rp->delete())
            {
                $response->code = 200; // Ok
                $response->content = array("message" => "The Rp was deleted.", "success" => true);
            }
            // if unable to delete the rp
            else
            {
                $response->code = 503; //Service unavailable
                $response->content = array("message" => "Unable to delete the Rp.", "success" => false);
            }

            return $response->emit();
        }
    }

    // Request
    class DeleteRpRequestModel
    {
        public $id;
    }

    // Response
    class DeleteRpResponseModel extends ResponseModel
    {
        public $success;
    }
?>