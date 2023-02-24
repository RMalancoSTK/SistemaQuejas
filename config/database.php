<?php

class Database
{
    public static function connect()
    {
        try {
            // conexion a la base de datos por metodo PDO
            $db = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $db->exec("SET CHARACTER SET " . DB_CHAR);
            return $db;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public static function disconnect()
    {
        $db = null;
    }
}
