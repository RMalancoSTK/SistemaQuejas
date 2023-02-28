<?php

class ApiModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getTotalQuejas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM quejas");
        $row = $query->fetchObject();
        return $row->total;
    }
}
