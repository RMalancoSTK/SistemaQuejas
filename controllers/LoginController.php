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
        $usuarioModel = new UsuarioModel();
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $usuario = $this->limpiarDatos($_POST['usuario']);
            $password = $this->limpiarDatos($_POST['password']);
            $usuarioModel->setUsuario($usuario);
            $usuarioModel->setPassword($password);
            $existeUsuario = $usuarioModel->existeUsuario($usuario);
            if ($existeUsuario) {
                $verify = password_verify($password, $existeUsuario['password']);
                if ($verify) {
                    if ($existeUsuario['estado'] == 0) {
                        $_SESSION['error_login'] = ERROR_LOGIN_NO_ACTIVO;
                        header(LOCATION_LOGIN);
                        die();
                    } else {
                        $_SESSION['active'] = true;
                        $_SESSION['idusuario'] = $existeUsuario['idusuario'];
                        $_SESSION['nombre'] = $existeUsuario['nombre'];
                        $_SESSION['departamento'] = $existeUsuario['departamento'];
                        $_SESSION['usuario'] = $existeUsuario['usuario'];
                        $_SESSION['idrol'] = $existeUsuario['idrol'];
                        $_SESSION['rol'] = $existeUsuario['rol'];
                        header(LOCATION_BASE_URL);
                    }
                } else {
                    $_SESSION['error_login'] = ERROR_LOGIN;
                    header(LOCATION_LOGIN);
                }
            } else {
                $_SESSION['error_login'] = ERROR_LOGIN_NO_EXISTE;
                header(LOCATION_LOGIN);
            }
        } else {
            header(LOCATION_LOGIN);
        }
    }

    private function limpiarDatos($datos)
    {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
    }

    public function cerrar()
    {
        session_destroy();
        header(LOCATION_LOGIN);
    }
}
