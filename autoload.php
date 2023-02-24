<?php

function controllers_autoload($classname)
{
    if (file_exists('controllers/' . $classname . '.php')) {
        require_once 'controllers/' . $classname . '.php';
    } elseif (file_exists('models/' . $classname . '.php')) {
        require_once 'models/' . $classname . '.php';
    } elseif (file_exists('helpers/' . $classname . '.php')) {
        require_once 'helpers/' . $classname . '.php';
    }
}
spl_autoload_register('controllers_autoload');
