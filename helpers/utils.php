<?php

require_once 'models/QuejasModel.php';
class Utils
{
    public static function comprobarSesion()
    {
        if (!isset($_SESSION['active'])) {
            header("Location:" . BASE_URL);
        }
    }

    public static function isAdmin()
    {
        if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 1) {
            header(LOCATION_BASE_URL);
        }
    }

    public static function isUser()
    {
        if (!isset($_SESSION['idrol']) || $_SESSION['idrol'] != 2) {
            header(LOCATION_BASE_URL);
        }
    }

    public static function showMessages($type)
    {
        if (isset($_SESSION[$type])) {
            echo '<script>$(function () {
                toastr.' . $type . '("' . $_SESSION[$type] . '");
              });</script>';
            unset($_SESSION[$type]);
        }
    }

    public static function getBreadCrumbs()
    {
        $url = $_SERVER['REQUEST_URI'];
        $url = explode('/', $url);
        $url = array_filter($url);
        $url = array_slice($url, 0);
        $breadCrumbs = '';
        foreach ($url as $key => $value) {
            if ($key == 0) {
                $breadCrumbs .= '<li class="breadcrumb-item"><a href="' . BASE_URL . '">Inicio</a></li>';
            } else {
                $breadCrumbs .= '<li class="breadcrumb-item active">' . ucfirst($value) . '</li>';
            }
        }
        return $breadCrumbs;
    }
    public static function setActive($path)
    {
        $actual_path = $_SERVER['REQUEST_URI'];
        if (strpos($actual_path, $path) !== false) {
            echo 'active';
        }
    }

    public static function setMenuOpen($path)
    {
        $actual_path = $_SERVER['REQUEST_URI'];
        if (strpos($actual_path, $path) !== false) {
            echo 'menu-open';
        }
    }
}
