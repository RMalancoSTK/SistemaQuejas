<?php
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
            header(LOCATION_LOGIN);
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
}
