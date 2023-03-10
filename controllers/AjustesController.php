<?php

require_once 'models/AjustesModel.php';

class AjustesController
{
    private $ajustesModel;

    public function __construct()
    {
        $this->ajustesModel = new AjustesModel();
    }


    private function loadView($view)
    {
        if (isset($_SESSION['active'])) {
            include_once 'views/layout/header.php';
            include_once 'views/layout/navbar.php';
            include_once 'views/layout/sidebar.php';
            require_once "views/ajustes/$view.php";
            include_once 'views/layout/footer.php';
        } else {
            Utils::redirect(LOCATION_LOGIN);
        }
    }

    public function general()
    {
        Utils::isAdmin();
        $this->loadView('general');
    }
}
