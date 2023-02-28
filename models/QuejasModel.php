<?php
class QuejasModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getTotalQuejas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM quejas");
        $row = $query->fetchObject();
        return $row->total;
    }

    public function getTotalQuejasPendientes()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total
        FROM quejas q
        INNER JOIN estados e ON q.idestado = e.idestado
        WHERE e.nombre = 'Pendiente';");
        $row = $query->fetchObject();
        return $row->total;
    }

    public function getTotalQuejasAtendidas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total
        FROM quejas q
        INNER JOIN estados e ON q.idestado = e.idestado
        WHERE e.nombre = 'Atendido';");
        $row = $query->fetchObject();
        return $row->total;
    }

    public function getTotalQuejasRechazadas()
    {
        $query = $this->db->query("SELECT COUNT(*) AS total
        FROM quejas q
        INNER JOIN estados e ON q.idestado = e.idestado
        WHERE e.nombre = 'Rechazado';");
        $row = $query->fetchObject();
        return $row->total;
    }

    public function getUltimasQuejas()
    {
        $query = $this->db->query("SELECT q.idqueja,u.nombre AS usuario, d.nombre AS departamento, q.asunto, q.fechacreacion, e.nombre AS estado
        FROM quejas q
        INNER JOIN estados e ON q.idestado = e.idestado
        INNER JOIN usuarios u ON q.idusuario = u.idusuario
        INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
        ORDER BY q.fechacreacion DESC
        LIMIT 5;");
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function quejasdelmesactual($idestado)
    {
        return $this->db->query("SELECT DAY(fechacreacion) AS dia, COUNT(*) AS total
        FROM quejas
        WHERE fechacreacion BETWEEN DATE_FORMAT(NOW(),'%Y-%m-01') AND DATE_FORMAT(LAST_DAY(NOW()),'%Y-%m-%d')
        AND idestado = $idestado
        GROUP BY dia;");
    }
}
