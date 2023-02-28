<?php
require_once 'models/ApiModel.php';

class ApiController
{
    private $apiModel;

    public function __construct()
    {
        $this->apiModel = new ApiModel();
    }
}
