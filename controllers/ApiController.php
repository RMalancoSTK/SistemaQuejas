<?php
require_once 'models/ApiModel.php';

class ApiController
{
    private $apiModel;

    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }

    public function obtenerBaseURL()
    {
        echo json_encode(array('status' => 'ok', 'base_url' => BASE_URL));
    }
}
