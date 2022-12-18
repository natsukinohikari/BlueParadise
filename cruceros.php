<?php
session_start();
session_regenerate_id();

include 'autoload.php';
use Basedatos\Funciones as db;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/cruceros.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Blue Paradise - Cruceros</title>
</head>
<body>
    <?php require 'header.php';?>
    <div class="contenedor">
        <div id="centrar">
            <div>
                <?php
                $db = new db;
                $datos = $db->obtenerInfoCruceros();
                foreach ($datos as $value) {
                    echo '<div class="datos"><img src="images/crucero_preview.jpg" alt="" id="img_barco">';
                    echo '<div><h2>' . $value["nombre"] . '</h2><p>Ruta: ' . $value["itinerario"] . '</p><p>Salida: ' . $value["salida"] . 
                            '</p><p>Llegada: ' . $value["llegada"] . '</p><p>Precio: <span class="costo">' . $value["coste"] . '€</span></p>';
                    $destinos = explode("-", $value["itinerario"]);
                    $inicio = $destinos[0];
                    $fin = $destinos[count($destinos) - 1];
                    echo '<a href="camarotes.php?crucero=' . $value["id_crucero"] . '&nombrecrucero=' . $value["nombre"] . '&ruta=' . $value["id_crucero_ruta"] . 
                            '&costeruta=' . $value["coste"] . '&itinerario=' . $inicio . '-' . $fin . '&salida=' . $value["salida"] . 
                            '&llegada=' . $value["llegada"] . '&idcruceroruta=' . $value["id_crucero_ruta"] .'">Ver camarotes disponibles</a></div></div>';
                }
                ?>
            </div>
        </div>
    </div>
    <?php require 'footer.php';?>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>