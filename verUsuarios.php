<?php
session_start();
session_regenerate_id();
require 'funciones.php';
include 'autoload.php';

use Basedatos\Funciones as db;

if (!isset($_SESSION["usuario"]["correo"]) || $_SESSION["usuario"]["rol"] !== "Administrador") {
   header('Location: index.php');
} else {
    $db = new db;
    $datos = $db->obtenerPerfiles();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Blue Paradise - Lista de usuarios</title>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/verUsuarios.css">
        <link rel="stylesheet" href="css/footer.css">
        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    </head>
    <body>
        <?php require 'header.php';?>
        <div id="principal">
            <h2>Lista de usuarios</h2>
            <?php
            $texto = '<table class="table table-bordered"><thead class="table-primary"><tr><th>Nombre completo</th>'
                    .'<th>Fecha de nacimiento</th><th>Dirección</th><th>Teléfono</th><th>Rol</th><th></th></tr></thead><tbody>';
            foreach ($datos as $value) {
                $texto .= '<tr><td>' . $value["nombre"] . ' ' . $value["apellidos"] . '</td><td>' . $value["fecha_nacimiento"] . '</td><td>'
                        . $value["direccion"] . '</td><td>' . $value["telefono"] . '</td><td>' . $value["tipo"] . '</td>'
                        . '<td><a href="editarRol.php?idUsuario=' . $value["id_usuario"] . '&nombre=' . $value["nombre"] . 
                        '&apellidos=' . $value["apellidos"] .'&rol=' . $value["tipo"] .'">Editar rol</a></td></tr>';
            }
            $texto .= '</tbody></table>';
            echo $texto;
            ?>
        </div>
        <?php require 'footer.php';?>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    </body>
</html>
<?php
}
?>