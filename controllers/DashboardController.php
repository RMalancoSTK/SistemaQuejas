<?php
require_once 'models/QuejasModel.php';

class DashboardController
{
    private $quejasModel;
    private $primerdiadelmesactual;
    private $ultimodiadelmesactual;

    public function __construct()
    {
        $this->quejasModel = new QuejasModel();
        $this->primerdiadelmesactual = date('01-M-Y');
        $this->ultimodiadelmesactual = date('t-M-Y');
    }

    public function index()
    {
        if (isset($_SESSION['active'])) {
            include_once 'views/layout/header.php';
            include_once 'views/layout/navbar.php';
            include_once 'views/layout/sidebar.php';
            require_once 'views/dashboard/index.php';
            include_once 'views/layout/footer.php';
        } else {
            header(LOCATION_LOGIN);
        }
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
        return ($pendientes * 100) / $total;
    }

    public function getPorcentajeQuejasAtendidas()
    {
        $total = $this->getTotalQuejas();
        $atendidas = $this->getTotalQuejasAtendidas();
        return ($atendidas * 100) / $total;
    }

    public function getPorcentajeQuejasRechazadas()
    {
        $total = $this->getTotalQuejas();
        $rechazadas = $this->getTotalQuejasRechazadas();
        return ($rechazadas * 100) / $total;
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
            $idestado = $_POST['idestado'];

            if (!isset($idestado) || empty($idestado)) {
                echo json_encode(array('status' => 'error', 'message' => 'El id del estado es requerido'));
                die();
            }

            $arreglo = array();
            $query = $this->quejasModel->quejasdelmesactual($idestado);
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
}
