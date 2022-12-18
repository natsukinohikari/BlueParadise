<?php
session_start();
session_regenerate_id();
require 'funciones.php';
include 'autoload.php';
use Basedatos\Funciones as db;

$db = new db;
$datosRoles = $db->obtenerRoles();

if (isset($_GET["idUsuario"])) {
    $idUsuario = $_GET["idUsuario"];
}

if (isset($_GET["nombre"])) {
    $nombre = $_GET["nombre"];
}

if (isset($_GET["apellidos"])) {
    $apellidos = $_GET["apellidos"];
}

if (isset($_GET["rol"])) {
    $rol = $_GET["rol"];
}

if (!isset($_SESSION["usuario"]["correo"]) || $_SESSION["usuario"]["rol"] !== "Administrador" || !isset($idUsuario)) {
    header('Location: index.php');
} else if ($rol === "Administrador") {
    header('Location: verUsuarios.php');
} 

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    $id_usuario = $_POST["id_Usuario"];
    $rol = $_POST["role"];
    $db->actualizarRolUsuario($rol, $id_usuario);
    $db->guardarAcciones($_SESSION["usuario"]["id"], "Modificación de rol a usuarios");
    header('Location: verUsuarios.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/editarRol.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Blue Paradise - Edición de rol</title>
</head>
<body>
    <?php require 'header.php';?>
    <div id="contenedor">
        <h2>EDICIÓN DE ROL DE USUARIO</h2>
            <form id="formulario" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div class="control">
                    <label for="id">ID del Usuario: <?php echo $idUsuario?></label>
                    <input type="text" name="id_Usuario" id="idUsuario" value="<?php if (isset($idUsuario)) echo $idUsuario;?>" hidden>
                </div>
                <div class="control">
                    <label for="nombre">Nombre: <?php echo $nombre?></label>
                </div>
                <div class="control">
                    <label for="correo">Apellidos: <?php echo $apellidos?></label>
                </div>
                <div class="control">
                    <label for="rol">Rol:</label>
                    <select name="role">
                        <?php 
                        foreach ($datosRoles as $value) {
                            echo '<option value="' . $value["id_rol"] .'">' . $value["tipo"] . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" id="submit" name="submit">ACTUALIZAR</button>
            </form> 
    </div>
    <?php require 'footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>