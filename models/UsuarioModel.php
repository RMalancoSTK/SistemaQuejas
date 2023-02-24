<?php
class UsuarioModel
{
    private $idusuario;
    private $nombre;
    private $correo;
    private $usuario;
    private $password;
    private $estado;
    private $rol;
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function getIdusuario()
    {
        return $this->idusuario;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function getUsuario()
    {
        return $this->usuario;
    }

    public function getPassword()
    {
        return password_hash($this->password, PASSWORD_BCRYPT, ['cost' => 4]);
    }

    public function getEstado()
    {
        return $this->estado;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }

    public function setUsuario($usuario)
    {
        $this->usuario = $usuario;
    }

    public function setPassword($password)
    {
        $this->password = $password;
    }

    public function setEstado($estado)
    {
        $this->estado = $estado;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
    }

    public function existeUsuario($usuario)
    {
        // PDO Statement
        $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
        $statement = $this->db->prepare($sql);
        $statement->bindParam(':usuario', $usuario);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
