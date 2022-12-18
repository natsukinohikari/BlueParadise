<?php

if (isset($_GET["crucero"])) {
    $crucero = $_GET["crucero"];
}

if (isset($_GET["nombrecrucero"])) {
    $nombrecrucero = $_GET["nombrecrucero"];
}

if (isset($_GET["camarote"])) {
    $camarote = $_GET["camarote"];
}

if (isset($_GET["costecamarote"])) {
    $costecamarote = round($_GET["costecamarote"], 2);
}

if (isset($_GET["ruta"])) {
    $ruta = $_GET["ruta"];
}

if (isset($_GET["itinerario"])) {
    $itinerario = $_GET["itinerario"];
}

if (isset($_GET["salida"])) {
    $salida = $_GET["salida"];
}

if (isset($_GET["llegada"])) {
    $llegada = $_GET["llegada"];
}

if (isset($_GET["costeruta"])) {
    $costeruta = round($_GET["costeruta"], 2);
}

if (isset($_GET["camas"])) {
    $camas = $_GET["camas"];
}

if (isset($_GET["idcamarotecrucero"])) {
    $idcamarotecrucero = $_GET["idcamarotecrucero"];
}

if (isset($_GET["idcruceroruta"])) {
    $idcruceroruta = $_GET["idcruceroruta"];
}

if (isset($_GET["tipocamarote"])) {
    $tipocamarote = $_GET["tipocamarote"];
}

if (isset($_GET["cantidad"])) {
    $cantidad = $_GET["cantidad"];
}