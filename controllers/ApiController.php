<?php
require_once 'models/ApiModel.php';
require_once 'models/QuejasModel.php';

class ApiController
{
    private $apiModel;

    public function __construct()
    {
        $this->apiModel = new ApiModel();
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
}
