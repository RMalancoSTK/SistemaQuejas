<?php

class DashboardModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
}
