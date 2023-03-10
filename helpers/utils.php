<?php

require_once 'models/QuejasModel.php';
class Utils
{
    public static function deleteSession($name)
    {
        if (isset($_SESSION[$name])) {
            $_SESSION[$name] = null;
            unset($_SESSION[$name]);
        }
        return $name;
    }

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
            self::deleteSession($type);
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
        $actualpath = $_SERVER['REQUEST_URI'];
        if (strpos($actualpath, $path) !== false) {
            echo 'active';
        }
    }

    public static function setMenuOpen($path)
    {
        $actualpath = $_SERVER['REQUEST_URI'];
        if (strpos($actualpath, $path) !== false) {
            echo 'menu-open';
        }
    }

    public static function limpiarDatos($datos)
    {
        $datos = trim($datos);
        $datos = stripslashes($datos);
        $datos = htmlspecialchars($datos);
        return $datos;
    }

    public static function redirect($location)
    {
        header($location);
        exit();
    }

    public static function setSuccessMessage($message)
    {
        $_SESSION['success'] = $message;
    }

    public static function setErrorMessage($message)
    {
        $_SESSION['error'] = $message;
    }

    public static function validateFields($requiredFields, $method, $redirectLocation)
    {
        foreach ($requiredFields as $field) {
            if (!isset($method[$field]) || empty($method[$field])) {
                self::setErrorMessage('Todos los campos son obligatorios');
                self::redirect($redirectLocation);
                exit();
            }
        }
    }

    public static function validateFieldsjson($requiredFields, $method)
    {
        foreach ($requiredFields as $field) {
            if (!isset($method[$field]) || empty($method[$field])) {
                $arreglo = array('status' => 'error', 'message' => 'Todos los campos son obligatorios');
                echo json_encode($arreglo);
                die();
            }
        }
    }

    public static function encryptData($data)
    {
        $key = hash('sha256', SECRET_KEY);
        $ivLen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = openssl_random_pseudo_bytes($ivLen);
        $cipherTextRaw = openssl_encrypt($data, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $hmac = hash_hmac('sha256', $cipherTextRaw, $key, true);
        $cipherText = base64_encode($iv . $hmac . $cipherTextRaw);
        return $cipherText;
    }

    public static function decryptData($ciphertext)
    {
        $key = hash('sha256', SECRET_KEY);
        $c = base64_decode($ciphertext);
        $ivLen = openssl_cipher_iv_length($cipher = "AES-128-CBC");
        $iv = substr($c, 0, $ivLen);
        $hmac = substr($c, $ivLen, $sha2len = 32);
        $cipherTextRaw = substr($c, $ivLen + $sha2len);
        $originalPlaintext = openssl_decrypt($cipherTextRaw, $cipher, $key, OPENSSL_RAW_DATA, $iv);
        $calcMac = hash_hmac('sha256', $cipherTextRaw, $key, true);
        if (hash_equals($hmac, $calcMac)) {
            return $originalPlaintext;
        }
        return null;
    }
}
