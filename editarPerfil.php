<?php
session_start();
session_regenerate_id();
require 'funciones.php';
include 'autoload.php';
use Basedatos\Funciones as db;

if (!isset($_SESSION["usuario"]["correo"])) {
    header('Location: index.php');
} else {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $datos = array();
        if (!empty($_POST["nombre"])) {
            $nombre = test_input($_POST["nombre"]);
            $datos["nombre"] = $nombre;
        }
        if (!empty($_POST["apellidos"])) {
            $apellidos = test_input($_POST["apellidos"]);
            $datos["apellidos"] = $apellidos;
        }
        if (!empty($_POST["nacimiento"])) {
            if (validarFecha($_POST["nacimiento"])) {
                $fecha_nac = test_input($_POST["nacimiento"]);
                $datos["fecha_nacimiento"] = $fecha_nac;
            } else {
                $error = true;
            }
        }
        if (!empty($_POST["direccion"])) {
            $direccion = test_input($_POST["direccion"]);
            $datos["direccion"] = $direccion;
        }
        if (!empty($_POST["tlf"])) {
            if (es_num_tlf($_POST["tlf"])) {
                $telefono = test_input($_POST["tlf"]);
                $datos["telefono"] = $telefono;
            } else {
                $error = true;
            }
        }
        if (isset($_FILES) && !empty($_FILES["imagen"]["name"])) {
            if (moverArchivo($_SESSION["usuario"]["id"], $_FILES)) {
                $datos["imagen"] = $_FILES['imagen']['name'];
            }
        }
        $db = new db;
        if (!$error && $db->actualizarPerfil($datos, $_SESSION["usuario"]["id"])) {
            if (isset($nombre)) {
                $_SESSION["usuario"]["nombre"] = $nombre;
            }
            $db->guardarAcciones($_SESSION["usuario"]["id"], "Modificación");
            header('Location: perfil.php');
        } else {
            header('Location: perfil.php?error=si');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/editarPerfil.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Blue Paradise - Edición de perfil</title>
</head>
<body>
    <?php require 'header.php';?>
    <div id="contenedor">
        <h2>ACTUALIZACIÓN DE PERFIL</h2>
            <form id="formulario" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">
                <div class="control">
                    <label for="nombre">Nombre</label>
                    <input type="text" name="nombre" id="nombre" value="<?php if (isset($nombre)) echo $nombre;?>">
                </div>
                <div class="control">
                    <label for="apellidos">Apellidos</label>
                    <input type="text" name="apellidos" id="apellidos" value="<?php if (isset($apellidos)) echo $apellidos;?>">
                </div>
                <div class="control">
                    <label for="nacimiento">Fecha de nacimiento</label>
                    <input type="date" name="nacimiento" id="nacimiento" value="<?php if (isset($fecha_nac)) echo $fecha_nac;?>">
                </div>
                <div class="control">
                    <label for="direccion">Dirección</label>
                    <input type="text" name="direccion" id="direccion" value="<?php if (isset($direccion)) echo $direccion;?>">
                </div>
                <div class="control">
                    <label for="tlf">Teléfono</label>
                    <input type="text" name="tlf" id="tlf" value="<?php if (isset($telefono)) echo $telefono;?>">
                </div>
                <div class="control">
                    <label for="imagen">Imagen</label>
                    <input type="file" name="imagen" id="imagen">
                </div>
                <button type="submit" id="submit" name="submit">ACTUALIZAR</button>
            </form> 
    </div>
    <?php require 'footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<?php
}
?>