<?php

class ApiModel
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getMisQuejas($idusuario)
    {
        return $this->db->query("SELECT q.idqueja AS Id, DATE_FORMAT(q.fechacreacion, '%d/%m/%Y') AS Fecha, CONCAT(u.nombre, ' ', u.apellido) AS 'Quien Registra',q.asunto as Asunto, d.nombre AS Departamento, c.nombre AS Tipo, e.nombre AS Estado, q.estado AS EstadoId
        FROM quejas q
        INNER JOIN usuarios u ON q.idusuario = u.idusuario
        INNER JOIN categorias c ON q.idcategoria = c.idcategoria
        INNER JOIN estados e ON q.idestado = e.idestado
        INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
        WHERE u.idusuario = $idusuario
        ORDER BY q.fechacreacion DESC");
    }

    public function getQuejas()
    {
        return $this->db->query("SELECT q.idqueja AS Id, DATE_FORMAT(q.fechacreacion, '%d/%m/%Y') AS Fecha, CONCAT(u.nombre, ' ', u.apellido) AS 'Quien Registra',q.asunto as Asunto, d.nombre AS Departamento, c.nombre AS Tipo, e.nombre AS Estado, q.estado AS EstadoId
        FROM quejas q
        INNER JOIN usuarios u ON q.idusuario = u.idusuario
        INNER JOIN categorias c ON q.idcategoria = c.idcategoria
        INNER JOIN estados e ON q.idestado = e.idestado
        INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
        ORDER BY q.fechacreacion DESC");
    }

    public function getUsuarios()
    {
        return $this->db->query("SELECT u.idusuario, u.usuario, u.nombre, u.apellido, d.nombre AS departamento, r.rol AS rol, u.estado
        FROM usuarios u
        INNER JOIN departamentos d ON u.iddepartamento = d.iddepartamento
        INNER JOIN roles r ON u.idrol = r.idrol
        WHERE u.idusuario <> 1;");
    }

    public function listarUsuarios($idusuario)
    {
        return $this->db->query("SELECT u.idusuario, u.usuario, u.nombre, u.email as correo, r.rol AS rol, u.estado
        FROM usuarios u
        INNER JOIN roles r ON u.idrol = r.idrol
        WHERE u.idusuario <> $idusuario;");
    }

    public function eliminarQueja($idqueja)
    {
        return $this->db->query("DELETE FROM quejas WHERE idqueja = $idqueja");
    }

    public function getComentarios($idqueja)
    {
        return $this->db->query("SELECT c.idcomentario, c.comentario,
        CONCAT(DATE_FORMAT(c.fechacreacion, '%h:%i %p'), ' ',
               IF(DATE(c.fechacreacion) = DATE(NOW()), 'Hoy', DATE_FORMAT(c.fechacreacion, '%d %b %Y'))) AS Fecha,
        CONCAT(u.nombre, ' ', u.apellido) AS nombreusuario
        FROM comentarios c
        INNER JOIN usuarios u ON c.idusuario = u.idusuario
        WHERE c.idqueja = $idqueja
        ORDER BY c.fechacreacion DESC;");
    }

    public function contadorComentarios($idqueja)
    {
        return $this->db->query("SELECT COUNT(*) AS total
        FROM comentarios c
        INNER JOIN usuarios u ON c.idusuario = u.idusuario
        WHERE c.idqueja = $idqueja
        ORDER BY c.fechacreacion DESC;");
    }

    public function comentar($idqueja, $comentario, $idusuario, $fechacreacion)
    {
        return $this->db->query("INSERT INTO comentarios (idqueja, idusuario, comentario, fechacreacion, fechaactualizacion, estado) 
        VALUES ($idqueja, $idusuario, '$comentario', '$fechacreacion', '$fechacreacion', 1);");
    }

    public function getArchivos($idqueja)
    {
        return $this->db->query("SELECT a.idarchivo, a.nombrearchivo, a.ruta, a.tipoarchivo, a.estado
        FROM archivos a
        WHERE a.idqueja = $idqueja;");
    }
}
