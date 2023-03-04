<?php
require_once 'models/ApiModel.php';
require_once 'models/QuejasModel.php';

class ApiController
{
    private $apiModel;
    private $quejasModel;

    public function __construct()
    {
        $this->apiModel = new ApiModel();
        $this->quejasModel = new QuejasModel();
    }

    public function obtenerBaseURL()
    {
        echo json_encode(array('status' => 'ok', 'base_url' => BASE_URL));
    }

    public function getMisQuejas()
    {
        $idusuario = $_SESSION['idusuario'];
        $arreglo = array();
        $query = $this->apiModel->getMisQuejas($idusuario);
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }
        echo json_encode($arreglo);
        die();
    }

    public function getQuejas()
    {
        $arreglo = array();
        $query = $this->apiModel->getQuejas();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }
        echo json_encode($arreglo);
        die();
    }

    public function getusuarios()
    {
        $arreglo = array();
        $query = $this->apiModel->getUsuarios();
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }
        echo json_encode($arreglo);
        die();
    }

    public function listarusuarios()
    {
        $idusuario = 1;
        $arreglo = array();
        $query = $this->apiModel->listarUsuarios($idusuario);
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }
        echo json_encode($arreglo);
        die();
    }

    public function eliminarQueja()
    {
        $idqueja = $_POST['idqueja'];
        $query = $this->apiModel->eliminarQueja($idqueja);
        if ($query) {
            echo json_encode(array('status' => 'ok', 'message' => 'Queja eliminada correctamente'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No se pudo eliminar la queja'));
        }
        die();
    }

    public function getcomentarios()
    {
        $idqueja = $_POST['idqueja'];
        $arreglo = array();
        $query = $this->apiModel->getComentarios($idqueja);
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }
        echo json_encode(array('status' => 'ok', 'data' => $arreglo));
        die();
    }

    public function contadorComentarios()
    {
        $idqueja = $_POST['idqueja'];
        $query = $this->apiModel->contadorComentarios($idqueja);
        $data = $query->fetch(PDO::FETCH_ASSOC);
        echo json_encode(array('status' => 'ok', 'data' => $data));
        die();
    }

    public function comentar()
    {
        $idqueja = $_POST['idqueja'];
        $comentario = $_POST['comentario'];
        $idusuario = $_SESSION['idusuario'];
        $fechacreacion = date('Y-m-d H:i:s');

        if (empty($comentario) || !isset($comentario)) {
            echo json_encode(array('status' => 'error', 'message' => 'El comentario no puede estar vacio'));
            die();
        }

        $query = $this->apiModel->comentar($idqueja, $comentario, $idusuario, $fechacreacion);
        if ($query) {
            echo json_encode(array('status' => 'ok', 'message' => 'Comentario registrado correctamente'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No se pudo registrar el comentario'));
        }
        die();
    }

    public function getarchivos()
    {
        $idqueja = $_POST['idqueja'];
        $arreglo = array();
        $query = $this->apiModel->getArchivos($idqueja);
        while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
            $arreglo[] = $data;
        }
        echo json_encode(array('status' => 'ok', 'data' => $arreglo));
        die();
    }

    public function subirArchivo()
    {
        if (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] == 0) {
            $idqueja = $_POST['idqueja'];
            $nombrearchivo = $_FILES["archivo"]["name"];
            $tipoarchivo = $_FILES["archivo"]["type"];
            $tamanoarchivo = $_FILES["archivo"]["size"];
            $temparchivo = $_FILES["archivo"]["tmp_name"];
            $fechacreacion = date('Y-m-d H:i:s');
            $estado = 1;

            if ($tamanoarchivo > 2000000) {
                echo json_encode(array('status' => 'error', 'message' => 'El archivo no debe pesar mas de 2MB'));
                die();
            }

            $carpeta = "uploads/$idqueja"; // Carpeta donde se guardará el archivo

            if (!file_exists($carpeta)) {
                mkdir($carpeta, 0777, true);
            }

            $ruta = $carpeta . '/' . $nombrearchivo;
            move_uploaded_file($temparchivo, $ruta);

            $this->quejasModel->saveArchivo($idqueja, $nombrearchivo, $tipoarchivo, $tamanoarchivo, $ruta, $fechacreacion, $estado);
            echo json_encode(array('status' => 'ok', 'message' => 'Archivo subido correctamente'));
            die();
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No se pudo subir el archivo'));
            die();
        }
    }

    public function atenderQueja()
    {
        $idqueja = $_POST['idqueja'];
        $estado = $_POST['estado'];
        $fechaactualizacion = date('Y-m-d H:i:s');
        $query = $this->quejasModel->cambiarEstadoQueja($idqueja, $fechaactualizacion, $estado);
        if ($query) {
            echo json_encode(array('status' => 'ok', 'message' => 'Queja atendida correctamente'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No se pudo atender la queja'));
        }
    }

    public function rechazarQueja()
    {
        $idqueja = $_POST['idqueja'];
        $estado = $_POST['estado'];
        $fechaactualizacion = date('Y-m-d H:i:s');
        $query = $this->quejasModel->cambiarEstadoQueja($idqueja, $fechaactualizacion, $estado);
        if ($query) {
            echo json_encode(array('status' => 'ok', 'message' => 'Queja rechazada correctamente'));
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'No se pudo rechazar la queja'));
        }
    }
}
