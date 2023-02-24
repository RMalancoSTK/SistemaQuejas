<?php

class ErrorController
{
    private $messageerror;

    public function index()
    {
        Utils::comprobarSesion();
        include_once 'views/layout/header.php';
        include_once 'views/layout/navbar.php';
        include_once 'views/layout/sidebar.php';
        require_once 'views/error/index.php';
        include_once 'views/layout/footer.php';
    }

    public function getError404()
    {
        return $this->messageerror;
    }

    public function setError404($messageerror)
    {
        $this->messageerror = $messageerror;
    }
}
