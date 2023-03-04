<?php
require_once 'models/QuejasModel.php';

class QuejasController
{
    private $quejasModel;
    private $idqueja;
    private $queja;

    public function __construct()
    {
        $this->quejasModel = new QuejasModel();
    }

    private function loadView($view)
    {
        if (isset($_SESSION['active'])) {
            include_once 'views/layout/header.php';
            include_once 'views/layout/navbar.php';
            include_once 'views/layout/sidebar.php';
            require_once "views/quejas/$view.php";
            include_once 'views/layout/footer.php';
        } else {
            Utils::redirect(LOCATION_LOGIN);
        }
    }

    public function index()
    {
        Utils::isAdmin();
        $this->loadView('index');
    }

    public function crear()
    {
        $this->loadView('crear');
    }

    public function editar()
    {
        $this->idqueja = isset($_GET['idqueja']) ? $_GET['idqueja'] : false;
        if ($this->idqueja) {
            $this->queja = $this->quejasModel->getQueja($this->idqueja);
            if ($this->queja) {
                if ($_SESSION['idusuario'] == $this->queja->idusuario) {
                    $this->loadView('crear');
                } else {
                    Utils::redirect(LOCATION_QUEJAS);
                }
            } else {
                Utils::redirect(LOCATION_QUEJAS);
            }
        } else {
            Utils::redirect(LOCATION_QUEJAS);
        }
    }

    public function misquejas()
    {
        $this->loadView('misquejas');
    }

    public function ver()
    {
        $this->idqueja = isset($_GET['idqueja']) ? $_GET['idqueja'] : false;
        if ($this->idqueja) {
            $this->queja = $this->quejasModel->getQueja($this->idqueja);
            if ($this->queja) {
                $this->loadView('ver');
            } else {
                Utils::redirect(LOCATION_QUEJAS);
            }
        } else {
            Utils::redirect(LOCATION_QUEJAS);
        }
    }



    public function getCategorias()
    {
        $categorias = $this->quejasModel->getCategorias();
        $categorias = array_map(function ($categoria) {
            return (object) $categoria;
        }, $categorias);
        return $categorias;
    }

    public function getTurnos()
    {
        $turnos = $this->quejasModel->getTurnos();
        $turnos = array_map(function ($turno) {
            return (object) $turno;
        }, $turnos);
        return $turnos;
    }

    public function getEstados()
    {
        $estados = $this->quejasModel->getEstados();
        $estados = array_map(function ($estado) {
            return (object) $estado;
        }, $estados);
        return $estados;
    }

    public function save()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->procesarFormularioGuardarQueja();
        } else {
            Utils::redirect(LOCATION_QUEJAS_CREAR);
        }
    }

    public function procesarFormularioGuardarQueja()
    {
        Utils::validateFields(['idcategoria', 'idturno', 'asunto', 'descripcion', 'fechacreacion'], $_POST, LOCATION_QUEJAS_CREAR);

        $idusuario = $_SESSION['idusuario'];
        $idcategoria = Utils::limpiarDatos($_POST['idcategoria']);
        $idturno = Utils::limpiarDatos($_POST['idturno']);
        $asunto = Utils::limpiarDatos($_POST['asunto']);
        $descripcion = Utils::limpiarDatos($_POST['descripcion']);
        $fechacreacion = Utils::limpiarDatos($_POST['fechacreacion']);
        $idestado = 1;
        $estado = 1;

        if (isset($_GET['idqueja'])) {
            $this->actualizarQueja($idcategoria, $idturno, $asunto, $descripcion);
        } else {
            $this->guardarQueja($idusuario, $idestado, $idcategoria, $idturno, $asunto, $descripcion, $fechacreacion, $estado);
        }
    }

    private function actualizarQueja($idcategoria, $idturno, $asunto, $descripcion)
    {
        $idqueja = Utils::limpiarDatos($_GET['idqueja']);
        $fechaactualizacion = date('Y-m-d H:i:s');
        $queja = $this->quejasModel->updateQueja($idqueja, $idcategoria, $idturno, $asunto, $descripcion, $fechaactualizacion);
        if ($queja) {
            Utils::setSuccessMessage('Queja actualizada correctamente');
            Utils::redirect(LOCATION_QUEJAS_MISQUEJAS);
            exit();
        } else {
            Utils::setErrorMessage('No se pudo actualizar la queja');
            Utils::redirect(LOCATION_QUEJAS_MISQUEJAS);
            exit();
        }
    }

    private function guardarQueja($idusuario, $idestado, $idcategoria, $idturno, $asunto, $descripcion, $fechacreacion, $estado)
    {
        $queja = $this->quejasModel->saveQueja($idusuario, $idestado, $idcategoria, $idturno, $asunto, $descripcion, $fechacreacion, $estado);

        if ($queja) {
            $this->guardarArchivo($queja, $fechacreacion, $estado);
        } else {
            Utils::setErrorMessage('No se pudo registrar la queja');
            Utils::redirect(LOCATION_QUEJAS_CREAR);
        }
    }

    private function guardarArchivo($queja, $fechacreacion, $estado)
    {
        if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
            $idqueja = $queja;
            $nombrearchivo = $_FILES["archivo"]["name"];
            $tipoarchivo = $_FILES["archivo"]["type"];
            $tamanoarchivo = $_FILES["archivo"]["size"];
            $temparchivo = $_FILES["archivo"]["tmp_name"];

            if ($tamanoarchivo > 2000000) {
                Utils::setErrorMessage('El archivo no debe pesar mas de 2MB');
                Utils::redirect(LOCATION_QUEJAS_EDITAR . '&idqueja=' . $idqueja);
                exit();
            }

            $carpeta = "uploads/$idqueja"; // Carpeta donde se guardará el archivo

            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            $ruta = $carpeta . '/' . $nombrearchivo;
            move_uploaded_file($temparchivo, $ruta);

            $this->quejasModel->saveArchivo($idqueja, $nombrearchivo, $tipoarchivo, $tamanoarchivo, $ruta, $fechacreacion, $estado);
            Utils::setSuccessMessage('Queja registrada correctamente');
            Utils::redirect(LOCATION_QUEJAS_MISQUEJAS);
            exit();
        } else {
            Utils::setSuccessMessage('Queja registrada correctamente');
            Utils::redirect(LOCATION_QUEJAS_MISQUEJAS);
            exit();
        }
    }

    public function atender()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->atenderQueja();
        } else {
            Utils::redirect(LOCATION_QUEJAS);
        }
    }

    public function rechazar()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $this->rechazarQueja();
        } else {
            Utils::redirect(LOCATION_QUEJAS);
        }
    }

    private function atenderQueja()
    {
        if (isset($_GET['idqueja'])) {
            $idqueja = Utils::limpiarDatos($_GET['idqueja']);
            $queja = $this->quejasModel->getQueja($idqueja);
            $idestado = 2; // Atendida
            $message = 'Queja atendida correctamente';
            if ($queja) {
                if (isset($_SESSION['idrol']) && $_SESSION['idrol'] == 1) {
                    $this->cambiarEstadoQueja($idqueja, $idestado, $message);
                } else {
                    Utils::redirect(LOCATION_QUEJAS);
                }
            } else {
                Utils::redirect(LOCATION_QUEJAS);
            }
        } else {
            Utils::redirect(LOCATION_QUEJAS);
        }
    }

    private function rechazarQueja()
    {
        if (isset($_GET['idqueja'])) {
            $idqueja = Utils::limpiarDatos($_GET['idqueja']);
            $queja = $this->quejasModel->getQueja($idqueja);
            $idestado = 3; // Rechazada
            $message = 'Queja rechazada correctamente';
            if ($queja) {
                if (isset($_SESSION['idrol']) && $_SESSION['idrol'] == 1) {
                    $this->cambiarEstadoQueja($idqueja, $idestado, $message);
                } else {
                    Utils::redirect(LOCATION_QUEJAS);
                }
            } else {
                Utils::redirect(LOCATION_QUEJAS);
            }
        } else {
            Utils::redirect(LOCATION_QUEJAS);
        }
    }

    private function cambiarEstadoQueja($idqueja, $idestado, $message)
    {
        $fechaactualizacion = date('Y-m-d H:i:s');
        $queja = $this->quejasModel->cambiarEstadoQueja($idqueja, $fechaactualizacion, $idestado);
        if ($queja) {
            utils::setSuccessMessage($message);
        } else {
            utils::setErrorMessage('No se pudo actualizar la queja');
        }
        utils::redirect(LOCATION_QUEJAS);
    }

    public function getQuejas()
    {
        $quejas = $this->quejasModel->getQuejas();
        $quejas = array_map(function ($queja) {
            return (object) $queja;
        }, $quejas);
        return $quejas;
    }
}
