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

    public function guardarUsuario($idrol, $iddepartamento, $nombre, $apellido, $email, $usuario, $password, $estado)
    {
        $sql = "INSERT INTO `usuarios` (idrol, iddepartamento, nombre, apellido, email, usuario, password, estado)
        VALUES (:idrol, :iddepartamento, :nombre, :apellido, :email, :usuario, :password, :estado);";
        $statement = $this->db->prepare($sql);

        $statement->bindValue(':idrol', (int) $idrol, PDO::PARAM_INT);
        $statement->bindValue(':iddepartamento', (int) $iddepartamento, PDO::PARAM_INT);
        $statement->bindValue(':nombre', (string) $nombre, PDO::PARAM_STR);
        $statement->bindValue(':apellido', (string) $apellido, PDO::PARAM_STR);
        $statement->bindValue(':email', (string) $email, PDO::PARAM_STR);
        $statement->bindValue(':usuario', (string) $usuario, PDO::PARAM_STR);
        $statement->bindValue(':password', (string) $password, PDO::PARAM_STR);
        $statement->bindValue(':estado', (int) $estado, PDO::PARAM_INT);

        $statement->execute();
        return $statement->rowCount();
    }

    public function actualizarUsuario($idusuario, $idrol, $iddepartamento, $nombre, $apellido, $email)
    {
        $sql = "UPDATE usuarios SET idrol = :idrol, iddepartamento = :iddepartamento, nombre = :nombre, apellido = :apellido, email = :email WHERE idusuario = :idusuario AND idusuario <> 1;";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':idusuario', (int) $idusuario, PDO::PARAM_INT);
        $statement->bindValue(':idrol', (int) $idrol, PDO::PARAM_INT);
        $statement->bindValue(':iddepartamento', (int) $iddepartamento, PDO::PARAM_INT);
        $statement->bindValue(':nombre', (string) $nombre, PDO::PARAM_STR);
        $statement->bindValue(':apellido', (string) $apellido, PDO::PARAM_STR);
        $statement->bindValue(':email', (string) $email, PDO::PARAM_STR);
        $statement->execute();
        return $statement->rowCount();
    }

    public function getUsuario($idusuario)
    {
        return $this->db->query("SELECT u.idusuario, u.idrol, u.iddepartamento, u.nombre, u.apellido, u.email, u.usuario, u.password, u.estado
        FROM usuarios u
        WHERE u.idusuario = $idusuario;");
    }

    public function guardarPassword($idusuario, $passwordhash)
    {
        $sql = "UPDATE usuarios SET password = :password WHERE idusuario = :idusuario;";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':idusuario', (int) $idusuario, PDO::PARAM_INT);
        $statement->bindValue(':password', (string) $passwordhash, PDO::PARAM_STR);

        $statement->execute();
        return $statement->rowCount();
    }

    public function desactivarUsuario($idusuario, $estado)
    {
        $sql = "UPDATE usuarios SET estado = :estado WHERE idusuario = :idusuario AND idusuario <> 1;";
        $statement = $this->db->prepare($sql);
        $statement->bindValue(':idusuario', (int) $idusuario, PDO::PARAM_INT);
        $statement->bindValue(':estado', (int) $estado, PDO::PARAM_INT);

        $statement->execute();
        return $statement->rowCount();
    }
}
