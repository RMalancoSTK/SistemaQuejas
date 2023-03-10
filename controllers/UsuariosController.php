<?php

require_once 'models/UsuarioModel.php';

class UsuariosController
{
    private $usuarioModel;
    private $usuario;

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

    public function getDepartamentos()
    {
        $departamentos = $this->usuarioModel->getDepartamentos();
        $departamentos = array_map(function ($departamento) {
            return (object) $departamento;
        }, $departamentos);
        return $departamentos;
    }

    public function getRoles()
    {
        $roles = $this->usuarioModel->getRoles();
        $roles = array_map(function ($rol) {
            return (object) $rol;
        }, $roles);
        return $roles;
    }

    public function perfil()
    {
        $this->usuario = $this->usuarioModel->datosUsuario($_SESSION['idusuario']);
        if ($this->usuario) {
            $this->loadView('perfil');
        } else {
            Utils::redirect(LOCATION_LOGIN);
        }
    }

    public function editarperfil()
    {
        $idusuario = $_SESSION['idusuario'];
        if ($idusuario) {
            //traemos los datos del formulario
            $nombre = Utils::limpiarDatos($_POST['nombre']);
            $apellido = Utils::limpiarDatos($_POST['apellido']);
            $email = Utils::limpiarDatos($_POST['email']);
            //validamos los datos que no estén vacíos
            if (isset($nombre) && empty($nombre) || isset($apellido) && empty($apellido) || isset($email) && empty($email)) {
                $_SESSION['error'] = 'Todos los campos son obligatorios';
                Utils::redirect(LOCATION_USUARIO_PERFIL);
            } else {
                //validamos el email
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $_SESSION['error'] = 'El email no es valido';
                    Utils::redirect(LOCATION_USUARIO_PERFIL);
                } else {
                    //validamos que el email no exista
                    $usuario = $this->usuarioModel->datosUsuario($idusuario);
                    if ($usuario->email == $email) {
                        $this->usuarioModel->editarPerfil($idusuario, $nombre, $apellido, $email);
                        $_SESSION['success'] = 'Datos actualizados correctamente';
                        $_SESSION['nombre'] = $nombre . ' ' . $apellido;
                        Utils::redirect(LOCATION_USUARIO_PERFIL);
                    } else {
                        $usuario = $this->usuarioModel->getUsuarioByEmail($email);
                        if ($usuario) {
                            $_SESSION['error'] = 'El email ya existe';
                            Utils::redirect(LOCATION_USUARIO_PERFIL);
                        } else {
                            $this->usuarioModel->editarPerfil($idusuario, $nombre, $apellido, $email);
                            $_SESSION['success'] = 'Datos actualizados correctamente';
                            $_SESSION['nombre'] = $nombre . ' ' . $apellido;
                            Utils::redirect(LOCATION_USUARIO_PERFIL);
                        }
                    }
                }
            }
        } else {
            $_SESSION['error'] = 'No se pudo actualizar los datos';
            Utils::redirect(LOCATION_USUARIO_PERFIL);
        }
    }

    public function changePassword()
    {
        $idusuario = $_SESSION['idusuario'];
        if ($idusuario) {
            $password = Utils::limpiarDatos($_POST['password']);
            $newpassword = Utils::limpiarDatos($_POST['newpassword']);
            $confirmnewpassword = Utils::limpiarDatos($_POST['confirmnewpassword']);
            if (isset($password) && empty($password) || isset($newpassword) && empty($newpassword) || isset($confirmnewpassword) && empty($confirmnewpassword)) {
                $_SESSION['error'] = 'Todos los campos son obligatorios';
                Utils::redirect(LOCATION_USUARIO_PERFIL);
            } else {
                $usuario = $this->usuarioModel->datosUsuario($idusuario);
                $verify = password_verify($password, $usuario->password);
                if ($verify) {
                    if ($newpassword == $confirmnewpassword) {
                        $this->usuarioModel->setPassword($newpassword);
                        $this->usuarioModel->changePassword($idusuario);
                        $_SESSION['success'] = 'Contraseña actualizada correctamente';
                        Utils::redirect(LOCATION_USUARIO_PERFIL);
                    } else {
                        $_SESSION['error'] = 'Las contraseñas no coinciden';
                        Utils::redirect(LOCATION_USUARIO_PERFIL);
                    }
                } else {
                    $_SESSION['error'] = 'La contraseña actual no es correcta';
                    Utils::redirect(LOCATION_USUARIO_PERFIL);
                }
            }
        } else {
            $_SESSION['error'] = 'No se pudo actualizar la contraseña';
            Utils::redirect(LOCATION_USUARIO_PERFIL);
        }
    }
}
