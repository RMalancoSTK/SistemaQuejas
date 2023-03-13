<?php

class Controller
{
    protected $dataSession;
    private $primerdiadelmesactual;
    private $ultimodiadelmesactual;

    public function __construct()
    {
        $this->dataSession = [];
        $this->primerdiadelmesactual = date('01-M-Y');
        $this->ultimodiadelmesactual = date('t-M-Y');
    }

    public function loadView($view)
    {
        include_once 'views/layout/header.php';
        include_once 'views/layout/navbar.php';
        include_once 'views/layout/sidebar.php';
        require_once "views/$view.php";
        include_once 'views/layout/footer.php';
    }
}
