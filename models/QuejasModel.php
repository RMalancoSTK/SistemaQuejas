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

    public function quejasdelmesactual()
    {
        return $this->db->query("SELECT numeros.dia AS dia,
        COALESCE(COUNT(CASE WHEN quejas.idestado = 1 THEN quejas.idqueja END), 0) AS totalpendientes,
        COALESCE(COUNT(CASE WHEN quejas.idestado = 2 THEN quejas.idqueja END), 0) AS totalatendidas,
        COALESCE(COUNT(CASE WHEN quejas.idestado = 3 THEN quejas.idqueja END), 0) AS totalrechazadas
        FROM (
        SELECT 1 AS dia UNION SELECT 2 UNION SELECT 3 UNION SELECT 4 UNION SELECT 5 UNION SELECT 6 UNION
        SELECT 7 UNION SELECT 8 UNION SELECT 9 UNION SELECT 10 UNION SELECT 11 UNION SELECT 12 UNION
        SELECT 13 UNION SELECT 14 UNION SELECT 15 UNION SELECT 16 UNION SELECT 17 UNION SELECT 18 UNION
        SELECT 19 UNION SELECT 20 UNION SELECT 21 UNION SELECT 22 UNION SELECT 23 UNION SELECT 24 UNION
        SELECT 25 UNION SELECT 26 UNION SELECT 27 UNION SELECT 28 UNION SELECT 29 UNION SELECT 30 UNION
        SELECT 31
        ) AS numeros
        LEFT JOIN quejas ON DAY(quejas.fechacreacion) = numeros.dia AND MONTH(quejas.fechacreacion) = MONTH(NOW())
        WHERE numeros.dia <= DAY(LAST_DAY(NOW()))
        GROUP BY numeros.dia;");
    }

    public function getMiTotalRegistros($idusuario)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total FROM quejas WHERE idusuario = $idusuario");
        $row = $query->fetchObject();
        return $row->total;
    }

    public function getMiTotalRegistrosPendientes($idusuario)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total
        FROM quejas q
        INNER JOIN estados e ON q.idestado = e.idestado
        WHERE e.nombre = 'Pendiente' AND q.idusuario = $idusuario;");
        $row = $query->fetchObject();
        return $row->total;
    }

    public function getMiTotalRegistrosAtendidos($idusuario)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total
        FROM quejas q
        INNER JOIN estados e ON q.idestado = e.idestado
        WHERE e.nombre = 'Atendido' AND q.idusuario = $idusuario;");
        $row = $query->fetchObject();
        return $row->total;
    }

    public function getMiTotalRegistrosRechazados($idusuario)
    {
        $query = $this->db->query("SELECT COUNT(*) AS total
        FROM quejas q
        INNER JOIN estados e ON q.idestado = e.idestado
        WHERE e.nombre = 'Rechazado' AND q.idusuario = $idusuario;");
        $row = $query->fetchObject();
        return $row->total;
    }

    public function getUltimasQuejasUsuario($idusuario)
    {
        $query = $this->db->query("SELECT q.idqueja,u.nombre AS usuario, d.nombre AS departamento, q.asunto, q.fechacreacion, e.nombre AS estado
        FROM quejas q
        INNER JOIN estados e ON q.idestado = e.idestado
        INNER JOIN usuarios u ON q.idusuario = u.idusuario
        INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
        WHERE q.idusuario = $idusuario
        ORDER BY q.fechacreacion DESC
        LIMIT 5;");
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getCategorias()
    {
        $query = $this->db->query("SELECT * FROM categorias WHERE estado = 1;");
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getTurnos()
    {
        $query = $this->db->query("SELECT * FROM turnos WHERE estado = 1;");
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function getEstados()
    {
        $query = $this->db->query("SELECT * FROM estados WHERE estado = 1;");
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    public function saveQueja($idusuario, $idestado, $idcategoria, $idturno, $asunto, $descripcion, $fechacreacion, $estado)
    {
        $query = $this->db->prepare("INSERT INTO `quejas` (idusuario, idestado, idcategoria, idturno, asunto, descripcion, fechacreacion, fechaactualizacion, estado) 
        VALUES ( :idusuario, :idestado, :idcategoria, :idturno, :asunto, :descripcion, :fechacreacion, :fechaactualizacion, :estado);");
        $query->bindValue(":idusuario", (int) $idusuario, PDO::PARAM_INT);
        $query->bindValue(":idestado", (int) $idestado, PDO::PARAM_INT);
        $query->bindValue(":idcategoria", (int) $idcategoria, PDO::PARAM_INT);
        $query->bindValue(":idturno", (int) $idturno, PDO::PARAM_INT);
        $query->bindValue(":asunto", (string) $asunto, PDO::PARAM_STR);
        $query->bindValue(":descripcion", (string) $descripcion, PDO::PARAM_STR);
        $query->bindValue(":fechacreacion", $fechacreacion, PDO::PARAM_STR);
        $query->bindValue(":fechaactualizacion", $fechacreacion, PDO::PARAM_STR);
        $query->bindValue(":estado", (int) $estado, PDO::PARAM_INT);

        $query->execute();
        return $this->db->lastInsertId();
    }

    public function saveArchivo($idqueja, $nombrearchivo, $tipoarchivo, $tamanoarchivo, $ruta, $fechacreacion, $estado)
    {
        $query = $this->db->prepare("INSERT INTO `archivos` (idqueja, nombrearchivo, tipoarchivo, tamanoarchivo, ruta, fechacreacion, fechaactualizacion, estado)
        SELECT :idqueja, :nombrearchivo, :tipoarchivo, :tamanoarchivo, :ruta, :fechacreacion, :fechaactualizacion, :estado
        WHERE NOT EXISTS (SELECT * FROM archivos WHERE idqueja = :idqueja AND nombrearchivo = :nombrearchivo);");
        $query->bindValue(":idqueja", (int) $idqueja, PDO::PARAM_INT);
        $query->bindValue(":nombrearchivo", (string) $nombrearchivo, PDO::PARAM_STR);
        $query->bindValue(":tipoarchivo", (string) $tipoarchivo, PDO::PARAM_STR);
        $query->bindValue(":tamanoarchivo", (int) $tamanoarchivo, PDO::PARAM_INT);
        $query->bindValue(":ruta", (string) $ruta, PDO::PARAM_STR);
        $query->bindValue(":fechacreacion", $fechacreacion, PDO::PARAM_STR);
        $query->bindValue(":fechaactualizacion", $fechacreacion, PDO::PARAM_STR);
        $query->bindValue(":estado", (int) $estado, PDO::PARAM_INT);
        return $query->execute();
    }

    public function getQueja($idqueja)
    {
        $query = $this->db->query("SELECT q.idqueja, q.idusuario, q.idestado, q.idcategoria, q.idturno, q.asunto, q.descripcion, q.fechacreacion, q.fechaactualizacion, q.estado,
        u.nombre AS usuario, d.nombre AS departamento, c.nombre AS categoria, t.nombre AS turno, e.nombre AS estado, CONCAT(u.nombre, ' ', u.apellido) AS nombrecompleto
        FROM quejas q
        INNER JOIN usuarios u ON q.idusuario = u.idusuario
        INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
        INNER JOIN categorias c ON q.idcategoria = c.idcategoria
        INNER JOIN turnos t ON q.idturno = t.idturno
        INNER JOIN estados e ON q.idestado = e.idestado
        WHERE q.idqueja = $idqueja;");
        return $query->fetch(PDO::FETCH_OBJ);
    }

    public function updateQueja($idqueja, $idcategoria, $idturno, $asunto, $descripcion, $fechaactualizacion)
    {
        $query = $this->db->prepare("UPDATE quejas SET idcategoria = :idcategoria, idturno = :idturno, asunto = :asunto, descripcion = :descripcion, fechaactualizacion = :fechaactualizacion WHERE idqueja = :idqueja;");
        $query->bindValue(":idqueja", (int) $idqueja, PDO::PARAM_INT);
        $query->bindValue(":idcategoria", (int) $idcategoria, PDO::PARAM_INT);
        $query->bindValue(":idturno", (int) $idturno, PDO::PARAM_INT);
        $query->bindValue(":asunto", (string) $asunto, PDO::PARAM_STR);
        $query->bindValue(":descripcion", (string) $descripcion, PDO::PARAM_STR);
        $query->bindValue(":fechaactualizacion", $fechaactualizacion, PDO::PARAM_STR);
        return $query->execute();
    }

    public function cambiarEstadoQueja($idqueja, $fechaactualizacion, $idestado)
    {
        $query = $this->db->prepare("UPDATE quejas SET fechaactualizacion = :fechaactualizacion, idestado = :idestado WHERE idqueja = :idqueja;");
        $query->bindValue(":idqueja", (int) $idqueja, PDO::PARAM_INT);
        $query->bindValue(":fechaactualizacion", $fechaactualizacion, PDO::PARAM_STR);
        $query->bindValue(":idestado", (int) $idestado, PDO::PARAM_INT);

        return $query->execute();
    }

    public function getQuejas()
    {
        $query = $this->db->query("SELECT q.idqueja AS Id, DATE_FORMAT(q.fechacreacion, '%d/%m/%Y') AS Fecha, CONCAT(u.nombre, ' ', u.apellido) AS Quien_Registra,q.asunto as Asunto, d.nombre AS Departamento, c.nombre AS Tipo, e.nombre AS Estado, q.estado AS EstadoId
        FROM quejas q
        INNER JOIN usuarios u ON q.idusuario = u.idusuario
        INNER JOIN categorias c ON q.idcategoria = c.idcategoria
        INNER JOIN estados e ON q.idestado = e.idestado
        INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
        ORDER BY q.fechacreacion DESC");
        return $query->fetchAll(PDO::FETCH_OBJ);
    }
}
