<?php

require_once 'models/UsuarioModel.php';

class UsuariosController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    private function loadView($view)
    {
        if (isset($_SESSION['active'])) {
            include_once 'views/layout/header.php';
            include_once 'views/layout/navbar.php';
            include_once 'views/layout/sidebar.php';
            require_once "views/usuarios/$view.php";
            include_once 'views/layout/footer.php';
        } else {
            Utils::redirect(LOCATION_LOGIN);
        }
    }

    public function listar()
    {
        Utils::isAdmin();
        $this->loadView('listar');
    }
}
