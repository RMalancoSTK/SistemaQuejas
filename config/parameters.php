<?php
// definimos la zona horaria
date_default_timezone_set('America/Mexico_City');

// Constantes de la configuración de la base de datos
define("DB_HOST", "localhost");
define("DB_NAME", "db_quejas");
define("DB_USER", "root");
define("DB_PASS", "");
define("DB_CHAR", "utf8");

// Constantes de la configuración de la aplicación
define("CONTROLLER_DEFAULT", "DashboardController");
define("ACTION_DEFAULT", "inicio");
define("BASE_URL", getBaseUrl());

define("SECRET_KEY", "quejas");

function getBaseUrl()
{
    $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
    $host     = $_SERVER['HTTP_HOST'];
    $script   = $_SERVER['SCRIPT_NAME'];
    $dir      = $_SERVER['SERVER_PORT'] == 8080 ? rtrim(dirname($script), '/\\') : '';
    return $protocol . $host . $dir . '/';
}

// Constantes los headers "'Location: '" de la aplicación
define("LOCATION_BASE_URL", "Location: " . BASE_URL); // Redirecciona a la página principal
define("LOCATION_LOGIN", "Location: " . BASE_URL . "login/index"); // Redirecciona a la página de login
define("LOCATION_DASHBOARD", "Location: " . BASE_URL . "dashboard/index"); // Redirecciona a la página de dashboard
define("LOCATION_QUEJAS_CREAR", "Location: " . BASE_URL . "quejas/crear"); // Redirecciona a la página de crear quejas
define("LOCATION_QUEJAS_MISQUEJAS", "Location: " . BASE_URL . "quejas/misquejas"); // Redirecciona a la página de mis quejas
define("LOCATION_QUEJAS_EDITAR", "Location: " . BASE_URL . "quejas/editar"); // Redirecciona a la página de editar quejas
define("LOCATION_QUEJAS", "Location: " . BASE_URL . "quejas/index"); // Redirecciona a la página de quejas
define("LOCATION_USUARIO_PERFIL", "Location: " . BASE_URL . "usuarios/perfil"); // Redirecciona a la página de perfil de usuario

// MENSAJES DE ERRORES Y EXITOS
// Mensajes de error
// ---------------------------------------------------------------
define("ERROR_LOGIN", "Usuario o Contraseña Incorrectos");
define("ERROR_LOGIN_VACIO", "Usuario o Contraseña Vacios");
define("ERROR_LOGIN_INACTIVO", "Usuario Inactivo");
define("ERROR_LOGIN_BLOQUEADO", "Usuario Bloqueado");
define("ERROR_LOGIN_INTENTOS", "Ha superado el número de intentos");
define("ERROR_LOGIN_NO_EXISTE", "El usuario no existe");
define("ERROR_LOGIN_CLAVE", "La clave es incorrecta");
define("ERROR_LOGIN_ACTIVO", "El usuario ya está activo");
define("ERROR_LOGIN_NO_ACTIVO", "El usuario no está activo");
define("ERROR_LOGIN_NO_BLOQUEADO", "El usuario no está bloqueado");
define("ERROR_LOGIN_NO_CLAVE", "La clave no se ha cambiado");
define("ERROR_LOGIN_IGUALES", "La clave nueva no puede ser igual a la actual");
define("ERROR_PAGE", "La página que buscas no existe");
define("ERROR_PRIVATE", "El método que buscas no existe");
define("ERROR_LOGIN_TIPO_CAMBIO", "El tipo de cambio no existe");
define('ERROR_LOGIN_EXISTE', 'El usuario ya existe');
define('ERROR_USUARIO_REGISTRADO', 'El usuario no se ha registrado correctamente');
define('ERROR_USUARIO_EXISTE', 'El usuario ya existe');
define('ERROR_USUARIO_EDITADO', 'Sin cambios en el usuario');
define('ERROR_USUARIO_NO_EXISTE', 'El usuario no existe');
define('ERROR_PASSWORD_EDITADO', 'No se ha editado la contraseña');
define('ERROR_USUARIO_DESACTIVADO', 'No se ha desactivado el usuario');
define('ERROR_USUARIO_ACTIVADO', 'No se ha activado el usuario');
define('ERROR_USUARIO_ELIMINADO', 'No se ha eliminado el usuario');
define('ERROR_PERMISOS_GUARDADOS', 'No se han guardado los permisos');
define('ERROR_OBTENER_PERMISOS', 'No se han obtenido los permisos');
define('ERROR_OBTENER_USUARIOS_PERMISOS', 'No se han obtenido los usuarios con permisos');

// ---------------------------------------------------------------
// Mensajes de exito
// ---------------------------------------------------------------
define("EXITO_LOGIN", "Bienvenido al Sistema");
define("EXITO_LOGIN_ACTIVO", "El usuario se ha activado correctamente");
define("EXITO_LOGIN_BLOQUEADO", "El usuario se ha bloqueado correctamente");
define("EXITO_LOGIN_DESBLOQUEADO", "El usuario se ha desbloqueado correctamente");
define("EXITO_LOGIN_CLAVE", "La clave se ha cambiado correctamente");
define("EXITO_USUARIO_REGISTRADO", "El usuario se ha registrado correctamente");
define("EXITO_USUARIO_EDITADO", "El usuario se ha editado correctamente");
define("EXITO_PASSWORD_EDITADO", "La contraseña se ha editado correctamente");
define("EXITO_USUARIO_DESACTIVADO", "El usuario se ha desactivado correctamente");
define("EXITO_USUARIO_ACTIVADO", "El usuario se ha activado correctamente");
define("EXITO_USUARIO_ELIMINADO", "El usuario se ha eliminado correctamente");
define('EXITO_PERMISOS_GUARDADOS', 'Los permisos se han guardado correctamente');
define('EXITO_USUARIO_SIN_PERMISOS', 'El usuario ya no cuenta con permisos en esta categoría');
