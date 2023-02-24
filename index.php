<?php
session_start();
require_once 'autoload.php';
require_once 'config/parameters.php';
require_once 'config/database.php';
require_once 'helpers/utils.php';

// controlador frontal
function showError($messageerror)
{
    $error = new ErrorController();
    $error->setError404($messageerror);
    $error->index();
}

if (isset($_GET['controller']) && $_GET['controller'] == 'error') {
    showError(ERROR_PAGE);
    exit();
}

// comprobar si existe el controlador
if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'] . 'Controller';
} elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $nombre_controlador = CONTROLLER_DEFAULT;
} else {
    showError(ERROR_PAGE);
    exit();
}

// comprobar si existe el método
if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();
    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $metodo = new ReflectionMethod($nombre_controlador, $_GET['action']);
        if ($metodo->isPrivate()) {
            header(LOCATION_BASE_URL);
        } else {
            $action = $_GET['action'];
            $controlador->$action();
        }
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $action_default = ACTION_DEFAULT;
        $controlador->$action_default();
    } else {
        showError(ERROR_PAGE);
    }
} else {
    showError(ERROR_PAGE);
}
// fin del controlador frontal
