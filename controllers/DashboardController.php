<?php
require_once 'models/QuejasModel.php';

class DashboardController extends Controller
{
    private $quejasModel;

    public function __construct()
    {
        $this->quejasModel = new QuejasModel();
    }

    public function index()
    {
        if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 1) {
            $this->loadView('dashboard/user');
        } else {
            $this->loadView('dashboard/admin');
        }
    }

    public function inicio()
    {
        header(LOCATION_DASHBOARD);
    }

    public function getTotalQuejas()
    {
        return $this->quejasModel->getTotalQuejas();
    }

    public function getTotalQuejasPendientes()
    {
        return $this->quejasModel->getTotalQuejasPendientes();
    }

    public function getTotalQuejasAtendidas()
    {
        return $this->quejasModel->getTotalQuejasAtendidas();
    }

    public function getTotalQuejasRechazadas()
    {
        return $this->quejasModel->getTotalQuejasRechazadas();
    }

    public function getPorcentajeQuejasPendientes()
    {
        $total = $this->getTotalQuejas();
        $pendientes = $this->getTotalQuejasPendientes();
        return number_format(($pendientes * 100) / $total, 2);
    }

    public function getPorcentajeQuejasAtendidas()
    {
        $total = $this->getTotalQuejas();
        $atendidas = $this->getTotalQuejasAtendidas();
        return number_format(($atendidas * 100) / $total, 2);
    }

    public function getPorcentajeQuejasRechazadas()
    {
        $total = $this->getTotalQuejas();
        $rechazadas = $this->getTotalQuejasRechazadas();
        return number_format(($rechazadas * 100) / $total, 2);
    }

    public function getUltimasQuejas()
    {
        $ultimasQuejas = $this->quejasModel->getUltimasQuejas();
        $ultimasQuejas = array_map(function ($queja) {
            return (object) $queja;
        }, $ultimasQuejas);
        return $ultimasQuejas;
    }

    public function obtenerquejas()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $arreglo = array();
            $query = $this->quejasModel->quejasdelmesactual();
            while ($data = $query->fetch(PDO::FETCH_ASSOC)) {
                $arreglo[] = $data;
            }
            echo json_encode($arreglo);
            die();
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Método no permitido'));
            die();
        }
    }

    public function getMiTotalRegistros($idusuario)
    {
        return $this->quejasModel->getMiTotalRegistros($idusuario);
    }

    public function getMiTotalRegistrosPendientes($idusuario)
    {
        return $this->quejasModel->getMiTotalRegistrosPendientes($idusuario);
    }

    public function getMiTotalRegistrosAtendidos($idusuario)
    {
        return $this->quejasModel->getMiTotalRegistrosAtendidos($idusuario);
    }

    public function getMiTotalRegistrosRechazados($idusuario)
    {
        return $this->quejasModel->getMiTotalRegistrosRechazados($idusuario);
    }

    public function getUltimasQuejasUsuario($idusuario)
    {
        $ultimasQuejas = $this->quejasModel->getUltimasQuejasUsuario($idusuario);
        $ultimasQuejas = array_map(function ($queja) {
            return (object) $queja;
        }, $ultimasQuejas);
        return $ultimasQuejas;
    }
}
