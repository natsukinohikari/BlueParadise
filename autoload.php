<?php

/**
 * Función de autocarga anónima que cargará toda la gestión de la web
 */
spl_autoload_register(function ($clase) {
    $file = __DIR__ . DIRECTORY_SEPARATOR ."clases" . DIRECTORY_SEPARATOR . $clase .'.php';
    if (file_exists($file)) {
        include $file;
    } else {
        include __DIR__ . DIRECTORY_SEPARATOR . $clase . '.php';
    }
});
