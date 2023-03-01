<?php

class ErrorController
{
    private $messageerror;

    private function loadView($view)
    {
        if (isset($_SESSION['active'])) {
            include_once 'views/layout/header.php';
            include_once 'views/layout/navbar.php';
            include_once 'views/layout/sidebar.php';
            require_once "views/error/$view.php";
            include_once 'views/layout/footer.php';
        } else {
            header(LOCATION_LOGIN);
        }
    }

    public function index()
    {
        Utils::comprobarSesion();
        $this->loadView('index');
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
