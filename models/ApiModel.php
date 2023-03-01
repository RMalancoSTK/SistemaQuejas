<?php

class ApiModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
}
