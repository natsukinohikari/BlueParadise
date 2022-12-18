<?php
session_start();
include 'funciones.php';
include 'autoload.php';
use Basedatos\Funciones as db;

if (isset($_SESSION["usuario"]["correo"])) {
    header('Location: index.php');
} else {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $email = test_input($_POST["email"]);
        $pass = test_input(($_POST["password"]));
        if (!empty($email) || !empty($pass)) {
            if (validarEmail($email)) {
                $bd = new db;
                $datos = $bd->comprobarUsuario($email, $pass);
                if ($datos !== false) {
                    $_SESSION["usuario"]["id"] = $datos[0];
                    $_SESSION["usuario"]["correo"] = $datos[1];
                    $_SESSION["usuario"]["nombre"] = $datos[2];
                    $_SESSION["usuario"]["puntos"] = $datos[3];
                    $_SESSION["usuario"]["rol"] = $datos[4];
                    $bd->guardarAcciones($datos[0], "Acceso");
                    header('Location: index.php');
                } else {
                    $err = "<span>&#x25B2 Datos incorrectos</span>";
                }
            } else {
                $err = "<span>&#x25B2 Correo inválido</span>";
            }
        } else{
            $err = "<span>&#x25B2 No has introducido el correo o la contraseña</span>";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Expires" content="0">
    <meta http-equiv="Last-Modified" content="0">
    <meta http-equiv="Cache-Control" content="no-cache, mustrevalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Blue Paradise - Login</title>
</head>
<body>
    <header>
        <a href="index.php"><img src="images/logo.jpg" alt="" id="logo"></a>
    </header>
    <div id="contenedor">
        <div id="contenido">
            <div id="imagen">
                <img src="images/crucero_login.jpg" alt="" id="img">
            </div>
            <div id="formulario">
                <h2>ACCEDE CON TU PERFIL</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <div class="control">
                        <label for="email">Correo <?php if (isset($err)) echo $err;?></label>
                        <input type="email" id="email" name="email" value="<?php if (isset($_POST["email"])) echo $_POST["email"]; ?>" required>
                    </div>
                    <div class="control">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit" id="submit" name="submit">INICIAR SESIÓN</button>
                </form>
                <hr>
                <div>
                    <p>¿No tienes cuenta? <a href="register.php" class="enlace">Regístrese aquí</a></p>
                    <p>¿No recuerdas la contraseña? <a href="" class="enlace">Pulse aquí</a></p>
                </div>
            </div>
        </div>
    </div>
    <?php require 'footer.php';?>
</body>
</html>
<?php
}
?>