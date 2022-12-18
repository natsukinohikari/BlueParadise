<?php
session_start();
session_regenerate_id();
require 'funciones.php';
include 'autoload.php';

use Basedatos\Funciones as db;

if (!isset($_SESSION["usuario"]["correo"])) {
   header('Location: index.php');
} else {
    $db = new db;
    $datos = $db->obtenerDatosPerfil($_SESSION["usuario"]["id"]);
    $imagenBD = $db->obtenerImagen($_SESSION["usuario"]["id"]);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Mi Perfil</title>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/perfil.css">
        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <?php require 'header.php';?>
        <div id="principal">
            <div id="imagen">
                <img src="imagenes/<?php echo $_SESSION["usuario"]["id"] . DIRECTORY_SEPARATOR . $imagenBD[0];?>" alt="" id="img_perfil">
            </div>
            <div>
                <div id="agrupamiento">
                    <h4>Nombre: </h4>
                    <p><?php echo $datos[0]?></p>
                </div>
                <div id="agrupamiento">
                    <h4>Apellidos: </h4>
                    <p><?php echo $datos[1]?></p>
                </div>
                <div id="agrupamiento">
                    <h4>Fecha de nacimiento: </h4>
                    <p><?php echo $datos[2]?></p>
                </div>
                <div id="agrupamiento">
                    <h4>Dirección: </h4>
                    <p><?php echo $datos[3]?></p>
                </div>
                <div id="agrupamiento">
                    <h4>Teléfono: </h4>
                    <p><?php echo $datos[4]?></p>
                </div>
                <div id="agrupamiento">
                    <h4>Puntos: </h4>
                    <p><?php echo $datos[5]?></p>
                </div>
            </div>
        </div>
        <p class="error"><?php if (isset($_GET["error"])) echo "No se pudo actualizar el perfil";?></p>
        <a href="editarPerfil.php" class="enlace_editar">Editar perfil>>></a>
        <?php require 'footer.php';?>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
<?php
}
?>
