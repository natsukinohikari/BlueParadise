<?php
// Página que cierra sesión y se carga todas las variables e información de la misma
session_start();
if (isset($_SESSION["usuario"]["correo"])) {
    session_unset();
    session_destroy();
    header('Location: index.php');
} else {
    header('Location: index.php');
}



