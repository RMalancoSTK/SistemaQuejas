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
            header(LOCATION_LOGIN);
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
                    header(LOCATION_QUEJAS);
                }
            } else {
                header(LOCATION_QUEJAS);
            }
        } else {
            header(LOCATION_QUEJAS);
        }
    }

    public function misquejas()
    {
        // Utils::isUser();
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
                header(LOCATION_QUEJAS);
            }
        } else {
            header(LOCATION_QUEJAS);
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

            if (
                !isset($_POST['idcategoria'], $_POST['idturno'], $_POST['asunto'], $_POST['descripcion'])
            ) {
                $_SESSION['error'] = 'Todos los campos son obligatorios';
                header(LOCATION_QUEJAS_CREAR);
                exit();
            }

            $idusuario = $_SESSION['idusuario'];
            $idestado = 1;
            $idcategoria = $this->limpiarDatos($_POST['idcategoria']);
            $idturno = $this->limpiarDatos($_POST['idturno']);
            $asunto = $this->limpiarDatos($_POST['asunto']);
            $descripcion = $this->limpiarDatos($_POST['descripcion']);
            $fechacreacion = $this->limpiarDatos($_POST['fechacreacion']);
            $estado = 1;

            if (isset($_GET['idqueja'])) {
                $idqueja = $this->limpiarDatos($_GET['idqueja']);
                $fechaactualizacion = date('Y-m-d H:i:s');
                $queja = $this->quejasModel->updateQueja($idqueja, $idcategoria, $idturno, $asunto, $descripcion, $fechaactualizacion);
                if ($queja) {
                    $_SESSION['success'] = 'Queja actualizada correctamente';
                    header(LOCATION_QUEJAS_MISQUEJAS);
                    exit();
                } else {
                    $_SESSION['error'] = 'No se pudo actualizar la queja';
                    header(LOCATION_QUEJAS_EDITAR . $idqueja);
                    exit();
                }
            } else {
                $queja = $this->quejasModel->saveQueja($idusuario, $idestado, $idcategoria, $idturno, $asunto, $descripcion, $fechacreacion, $estado);
                if ($queja) {
                    if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
                        $idqueja = $this->quejasModel->lastInsertId();
                        $nombrearchivo = $_FILES["archivo"]["name"];
                        $tipoarchivo = $_FILES["archivo"]["type"];
                        $tamanoarchivo = $_FILES["archivo"]["size"];
                        $temparchivo = $_FILES["archivo"]["tmp_name"];

                        if ($tamanoarchivo > 2000000) {
                            $_SESSION['error'] = 'El archivo no debe pesar mas de 2MB';
                            header(LOCATION_QUEJAS_EDITAR . $idqueja);
                            exit();
                        }

                        $carpeta = "uploads/$idqueja"; // Carpeta donde se guardará el archivo

                        if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }

                        $ruta = $carpeta . '/' . $nombrearchivo;
                        move_uploaded_file($temparchivo, $ruta);

                        $this->quejasModel->saveArchivo($idqueja, $nombrearchivo, $tipoarchivo, $tamanoarchivo, $ruta, $fechacreacion, $estado);
                        $_SESSION['success'] = 'Queja registrada correctamente';
                        header(LOCATION_QUEJAS_MISQUEJAS);
                        exit();
                    } else {
                        $_SESSION['success'] = 'Queja registrada correctamente';
                        header(LOCATION_QUEJAS_MISQUEJAS);
                        exit();
                    }
                } else {
                    $_SESSION['error'] = 'No se pudo registrar la queja';
                    header(LOCATION_QUEJAS_CREAR);
                }
            }
        } else {
            header(LOCATION_QUEJAS_CREAR);
        }
    }

    private function limpiarDatos($datos)
    {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
    }
}
