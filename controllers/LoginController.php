<?php

require_once 'models/UsuarioModel.php';

class LoginController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    public function index()
    {
        require_once 'views/login/index.php';
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header(LOCATION_LOGIN);
        }

        $usuario = Utils::encryptData(Utils::limpiarDatos($_POST['usuario']));
        $password = Utils::limpiarDatos($_POST['password']);
        $this->usuarioModel->setUsuario($usuario);
        $existeUsuario = $this->usuarioModel->existeUsuario();

        if (!$existeUsuario) {
            $_SESSION['error_login'] = ERROR_LOGIN_NO_EXISTE;
            header(LOCATION_LOGIN);
        }

        $verify = password_verify($password, $existeUsuario['password']);

        if (!$verify) {
            $_SESSION['error_login'] = ERROR_LOGIN;
            header(LOCATION_LOGIN);
        }

        if ($existeUsuario['estado'] == 0) {
            $_SESSION['error_login'] = ERROR_LOGIN_NO_ACTIVO;
            header(LOCATION_LOGIN);
            die();
        }

        $_SESSION['active'] = true;
        $_SESSION['idusuario'] = $existeUsuario['idusuario'];
        $_SESSION['nombre'] = $existeUsuario['nombre'];
        $_SESSION['departamento'] = $existeUsuario['departamento'];
        $_SESSION['usuario'] = $existeUsuario['usuario'];
        $_SESSION['idrol'] = $existeUsuario['idrol'];
        $_SESSION['rol'] = $existeUsuario['rol'];

        header(LOCATION_BASE_URL);
    }

    public function cerrar()
    {
        session_destroy();
        header(LOCATION_LOGIN);
    }
}
