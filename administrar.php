<?php
session_start();
session_regenerate_id();

include 'funciones.php';
include 'autoload.php';
use Basedatos\Funciones as db;

$db = new db;

if (!isset($_SESSION["usuario"]["correo"]) || $_SESSION["usuario"]["rol"] !== "Administrador") {
    header('Location: index.php');
} else {
    if (isset($_POST["agendar"])) {
        $numcamas = test_input($_POST["camas"]);
        $descrip = test_input($_POST["descrip"]);
        $precio = test_input($_POST["coste"]);
        if (is_numeric($numcamas)) {
            if (is_string($descrip)) {
                if (is_numeric($precio)) {
                    $data = array($numcamas, $descrip, $precio);
                    $db->anadirCamarote($data);
                } else {
                    $error = "<span>Precio inválido</span>";
                }
            } else {
                $error = "<span>Descripción inválida</span>";
            }
        } else {
            $error = "<span>Cama: Número inválido</span>";
        }
    } else if (isset($_POST["crucero"])) {
        $idcamarote = test_input($_POST["idcamarote"]);
        $idcrucero = test_input($_POST["idcrucero"]);
        $cantidad = test_input($_POST["cantidad"]);
        if (is_numeric($idcamarote)) {
            if (is_numeric($idcrucero)) {
                if (is_numeric($cantidad)) {
                    $data = array($idcamarote, $idcrucero, $cantidad);
                    $db->anadirCamaroteCrucero($data);
                } else {
                    $err = "<span>Cantidad inválida</span>";
                }
            } else {
                $err = "<span>ID Crucero inválido</span>";
            }
        } else {
            $err = "<span>ID Camarote inválido</span>";
        }
    } else if (isset($_POST["modificar"])) {
        $datos = array();
        $id = test_input($_POST["id"]);
        if (!empty($id) && is_numeric($id)) {
            if (!empty($_POST["camas"])) {
                $numcamas = test_input($_POST["camas"]);
                if (is_numeric($numcamas)) {
                    $datos["numerocamas"] = $numcamas;
                } else {
                    $er = "<span>Cama inválida</span>";
                }
            }
            if (!empty($_POST["descrip"])) {
                $descrip = test_input($_POST["descrip"]);
                if (is_string($descrip)) {
                    $datos["descripcion"] = $descrip;
                } else {
                    $er = "<span>Descripción incorrecta</span>";
                }
            }
            if (!empty($_POST["coste"])) {
                $precio = test_input($_POST["coste"]);
                if (is_numeric($precio)) {
                    $datos["coste"] = $precio;
                } else {
                    $er = "<span>Coste inválido</span>";
                }
            }
            if (!$db->modificarCamarote($id, $datos)) {
                $er = "<span>El ID no existe o no se pudo hacer la operación</span>";
            }
        } else {
            $er = "<span>ID inválido o no especificado</span>";
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
    <link rel="stylesheet" href="css/administracion.css">
    <link rel="stylesheet" href="css/footer.css">
    <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Blue Paradise - Administración</title>
</head>
<body>
    <?php require 'header.php';?>
    <div class="contenedor">
        <div id="agrup">
            <h3>Añadir camarote <?php if (isset($error)) echo $error;?></h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div>
                    <label for="camas">Número de camas:</label>
                    <input type="number" name="camas" id="camas">
                </div>
                <div>
                    <label for="descrip">Descripción:</label>
                    <input type="text" name="descrip" id="descrip">
                </div>
                <div>
                    <label for="coste">Coste:</label>
                    <input type="text" name="coste" id="coste">
                </div>
                <button type="submit" name="agendar" id="submit">Añadir</button>
            </form>
        </div>
        <div id="agrup">
            <h3>Añadir camarote a crucero <?php if (isset($err)) echo $err;?></h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div>
                    <label for="idcamarote">ID Camarote:</label>
                    <input type="number" name="idcamarote" id="idcamarote">
                </div>
                <div>
                    <label for="idcrucero">ID Crucero:</label>
                    <input type="number" name="idcrucero" id="idcrucero">
                </div>
                <div>
                    <label for="cantidad">Cantidad:</label>
                    <input type="text" name="cantidad" id="cantidad">
                </div>
                <button type="submit" name="crucero" id="submit">Añadir</button>
            </form>
        </div>
        <div id="agrup">
            <h3>Modificar camarote <?php if (isset($er)) echo $er;?></h3>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method="post">
                <div>
                    <label for="id">ID (a partir de 1000):</label>
                    <input type="text" name="id" id="id">
                </div>
                <div>
                    <label for="camas">Número de camas:</label>
                    <input type="number" name="camas" id="camas">
                </div>
                <div>
                    <label for="descrip">Descripción:</label>
                    <input type="text" name="descrip" id="descrip">
                </div>
                <div>
                    <label for="coste">Coste:</label>
                    <input type="text" name="coste" id="coste">
                </div>
                <button type="submit" name="modificar" id="submit">Modificar</button>
            </form>
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