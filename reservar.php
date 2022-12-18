<?php
session_start();
session_regenerate_id();

require 'envio_correos.php';
include 'autoload.php';
include 'getters.php';
use Basedatos\Funciones as db;

$pbase = $costeruta + $costecamarote;
$ptotal = $pbase - round($_SESSION["usuario"]["puntos"] / 100, 2);

$db = new db;
        
if (!isset($_SESSION["usuario"]["correo"])) {
    header('Location: index.php');
} else {
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $id_ruta = $_POST["idruta"];
        $id_camarote_crucero = $_POST["idcamarotecrucero"];
        $nombre_crucero = $_POST["crucero"];
        $tipo_camarote = $_POST["camarote"];
        $ruta = $_POST["itinerario"];
        $fechaSalida = $_POST["salida"];
        $fechaLlegada = $_POST["llegada"];
        $ncamarotes = $_POST["cantidadcamarotes"] - 1;
        if (isset($_POST["usar"])) {
            $precio = $_POST["ptotal"];
            $puntos = 0;
        } else {
            $precio = $_POST["pbase"];
            $puntos = round($precio) * 3 + $_SESSION["usuario"]["puntos"];
        }
        if ($db->Reserva($_SESSION["usuario"]["id"], $id_camarote_crucero, $precio, $id_ruta, $puntos, $ncamarotes) === true) {
            $_SESSION["usuario"]["puntos"] = $puntos;
            $datos = array('Nombre_crucero' => $nombre_crucero, 'Tipo_camarote' => $tipo_camarote, 'Ruta' => $ruta, 'Salida' => $fechaSalida, 'Llegada' => $fechaLlegada, 'Precio' => $precio);
            if (enviar_correos($datos, $db->ultimoIDReserva(), $_SESSION["usuario"]["correo"])) {
                header('Location: index.php');
            }
            header('Location: index.php');
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
    <link rel="stylesheet" href="css/reserva.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Blue Paradise - Reservar</title>
</head>
<body>
    <?php include 'header.php';?>
    <div id="contenedor">
        <div id="contenido">
            <div id="imagen">
                <img src="images/camarote<?php echo $camas?>.jpg" alt="" id="img">
            </div>
            <div id="inforeserva">
                <h2>DATOS RESERVA</h2>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                    <div class="agrup" hidden>
                        <label for="idruta">ID Ruta</label>
                        <input type="text" name="idruta" id="idruta" value="<?php echo $ruta;?>">
                    </div>
                    <div class="agrup" hidden>
                        <label for="idcamarotecrucero">ID Camarote Crucero</label>
                        <input type="text" name="idcamarotecrucero" id="idcamarotecrucero" value="<?php echo $idcamarotecrucero;?>">
                    </div>
                    <div class="agrup" hidden>
                        <label for="cantidadcamarotes">Cantidad camarotes disponibles</label>
                        <input type="text" name="cantidadcamarotes" id="cantidadcamarotes" value="<?php echo $cantidad;?>">
                    </div>
                    <div class="agrup">
                        <label for="crucero">Crucero: <?php echo $nombrecrucero;?></label>
                        <input type="text" name="crucero" id="crucero" value="<?php echo $nombrecrucero;?>" hidden>
                    </div>
                    <div class="agrup">
                        <label for="camarote">Tipo camarote: <?php echo $tipocamarote;?></label>
                        <input type="text" name="camarote" id="camarote" value="<?php echo $tipocamarote;?>" hidden>
                    </div>
                    <div class="agrup">
                        <label for="itinerario">Itinerario: <?php echo $itinerario;?></label>
                        <input type="text" name="itinerario" id="itinerario" value="<?php echo $itinerario;?>" hidden>
                    </div>
                    <div class="agrup">
                        <label for="salida" hidden>Salida: <?php echo $salida;?></label>
                        <input type="text" name="salida" id="salida" value="<?php echo $salida;?>" hidden>
                    </div>
                    <div class="agrup">
                        <label for="llegada" hidden>Llegada: <?php echo $llegada;?></label>
                        <input type="text" name="llegada" id="llegada" value="<?php echo $llegada;?>" hidden>
                    </div>
                    <div class="agrup">
                        <label for="direccion">Puntos: <?php echo $_SESSION["usuario"]["puntos"];?></label>
                        <input type="text" name="puntos" id="puntos" value="<?php echo $_SESSION["usuario"]["puntos"];?>" hidden>
                    </div>
                    <div class="agrup">
                        <label for="pbase">Precio base: <?php echo $pbase;?>€</label>
                        <input class="precio" type="text" name="pbase" id="pbase" value="<?php echo $pbase;?>€" hidden>
                    </div>
                    <div class="agrup">
                        <label for="ptotal">Precio con puntos: <?php echo $ptotal;?>€</label>
                        <input class="precio" type="text" name="ptotal" id="ptotal" value="<?php echo $ptotal;?>€" hidden>
                    </div>
                    <div class="agrup">
                        <input type="checkbox" name="usar" id="checkbox">Usar puntos
                    </div>
                    <button type="submit" id="submit" name="submit">RESERVAR</button>
                </form>
            </div>
        </div>
    </div>
    <?php require 'footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>
<?php
}
?>