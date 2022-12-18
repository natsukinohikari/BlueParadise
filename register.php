<?php
session_start();
require 'funciones.php';
include 'autoload.php';
use Basedatos\Funciones as db;

if (isset($_SESSION["usuario"]["correo"])) {
    header('Location: index.php');
} else {
    if ($_SERVER['REQUEST_METHOD'] === "POST") {
        $email = test_input($_POST["correo"]);
        $pass = test_input($_POST["contra"]);
        $passrep = test_input($_POST["repetircontra"]);
        $nombre = test_input($_POST["nombre"]);
        $apellidos = test_input($_POST["apellidos"]);
        $fecha_nac = test_input($_POST["nacimiento"]);
        $direccion = test_input($_POST["direccion"]);
        $telefono = test_input($_POST["tlf"]);
        $puntos = (int) 0;
        $rol = 2;
        if (!empty($email) && !empty($pass) && !empty($passrep) && !empty($nombre) && !empty($apellidos) && !empty($fecha_nac) && !empty($direccion) && !empty($telefono)) {
            if (validarEmail($email)) {
                if (strcmp($pass, $passrep) === 0) {
                    $passcode = password_hash($pass, PASSWORD_DEFAULT);
                    if (validarFecha($fecha_nac)) {
                        if (es_num_tlf($telefono)) {
                            $bd = new db;
                            $lastid = $bd->ultimoIDUsuario() + 1;
                            if (moverArchivo($lastid, $_FILES)) {
                                $registro = array('correo' => $email, 'clave' => $passcode, 'nombre' => $nombre, 'apellidos' => $apellidos, 'fecha_nacimiento' => $fecha_nac, 'direccion' => $direccion, 'telefono' => $telefono, 'puntos' => $puntos, 'imagen' => $_FILES['imagen']['name'], 'id_rol' => $rol);
                                $bd->anadirPerfil($registro);
                                $datos = $bd->comprobarUsuario($email, $pass);
                                if ($datos !== false) {
                                    $_SESSION["usuario"]["id"] = $datos[0];
                                    $_SESSION["usuario"]["correo"] = $datos[1];
                                    $_SESSION["usuario"]["nombre"] = $datos[2];
                                    $_SESSION["usuario"]["puntos"] = $datos[3];
                                    $_SESSION["usuario"]["rol"] = $datos[4];
                                    $bd->guardarAcciones($datos[0], "Acceso");
                                    header('Location: index.php');
                                }
                            }
                        }
                    }
                }
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Blue Paradise - Registro</title>
</head>
<body>
    <header>
        <a href="index.php"><img src="images/logo.jpg" alt="" id="logo"></a>
    </header>
    <div id="contenedor">
        <div id="contenido">
            <div id="formulario">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post" enctype="multipart/form-data">
                    <h2>REGISTRO</h2>
                    <div class="control">
                        <label for="correo">Correo</label>
                        <input type="email" name="correo" id="correo" value="<?php if (isset($email)) echo $email;?>" required>
                    </div>
                    <div class="control">
                        <label for="contra">Contraseña</label>
                        <input type="password" name="contra" id="contra" required>
                    </div>
                    <div class="control">
                        <label for="repetircontra">Repetir contraseña</label>
                        <input type="password" name="repetircontra" id="repetircontra" required>
                    </div>
                    <div class="control">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" value="<?php if (isset($nombre)) echo $nombre;?>" required>
                    </div>
                    <div class="control">
                        <label for="apellidos">Apellidos</label>
                        <input type="text" name="apellidos" id="apellidos" value="<?php if (isset($apellidos)) echo $apellidos;?>" required>
                    </div>
                    <div class="control">
                        <label for="nacimiento">Fecha de nacimiento</label>
                        <input type="date" name="nacimiento" id="nacimiento" value="<?php if (isset($fecha_nac)) echo $fecha_nac;?>" required>
                    </div>
                    <div class="control">
                        <label for="direccion">Dirección</label>
                        <input type="text" name="direccion" id="direccion" value="<?php if (isset($direccion)) echo $direccion;?>" required>
                    </div>
                    <div class="control">
                        <label for="tlf">Teléfono</label>
                        <input type="text" name="tlf" id="tlf" value="<?php if (isset($telefono)) echo $telefono;?>" required>
                    </div>
                    <div class="control">
                        <label for="imagen">Imagen</label>
                        <input type="file" name="imagen" id="imagen" required>
                    </div>
                    <button type="submit" id="submit" name="submit">REGISTRARSE</button>
                </form> 
            </div>
            <div id="imagen">
                <img src="images/crucero_register.jpg" alt="" id="img">
            </div>
        </div>
    </div>
    <?php require 'footer.php';?>
</body>
</html>
<?php
}
?>