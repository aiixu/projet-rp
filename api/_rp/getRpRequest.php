<?php
    include_once "api/shared/responseModel.php";

    class GetRpRequest
    {
        private $db;

        function __construct($db)
        {
            $this->db = $db;
        }

        public function get($request)
        {
            $rp = new RP($this->db);
            $rp->id = $request->id;
            $rp->getOne();
            
            $response = new GetRpResponseModel();

            if(isset($rp->creator_rp))
            {
                $response->creator_rp = $rp->creator_rp;
                $response->creator_name = $rp->crator_name;
                $response->creator_date = $rp->creator_date;
                $response->creator_
            }
        }
    }

    class GetRpRequestModel
    {

    }

    class GetRpResponseModel extends ResponseModel
    {
        
    }
?>