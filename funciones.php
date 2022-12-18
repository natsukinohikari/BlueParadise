<?php
/**
 * Función que arregla los datos recibidos de un input
 * 
 * @param type $data Datos recibidos
 * @return type Datos corregidos correctamente
 */
function test_input($data) {
    $data = trim($data); //Elimina los espacios de los laterales de la string
    $data = stripslashes($data); // Elimina las barras invertidas
    $data = htmlspecialchars($data); // Convierte caracteres especiales en entidades HTML
    return $data;
}

/**
 * Función que comprueba si un correo introducido es válido
 * 
 * @param type $email correo
 * @return boolean True si es válido; false en caso contrario
 */
function validarEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

/**
 * Función que comprueba la fecha introducida por un usuario
 * 
 * @param string $fecha Fecha en formato cadena de texto
 * @return boolean True si la fecha es correcta
 */
function validarFecha($fecha) {
    $fecha = explode('-', $fecha);
    return checkdate($fecha[1], $fecha[2], $fecha[0]);
}

/**
 * Función que comprueba si un número de teléfono dado lo es realmente 
 * 
 * @param type $tlf teléfono
 * @return boolean true si es un número de teléfono, false si no
 */
function es_num_tlf($tlf) {
    $patron = '/^(6|8|9)[0-9]{8}$/';
    $caracteres = array(" ", "-");
    $telefono = str_replace($caracteres,"", $tlf);
    if (!ctype_digit($telefono)) {
        return false;
    }
    if (!preg_match($patron, $telefono)) {
        return false;
    }
    return true;
}

/**
 * Función que comprueba si no hay errores en la subida del archivo
 * 
 * @param type $fich archivo a subir
 * @return boolean true si hubo error, false en caso contraio
 */
function comprobarErrores($fich) {
    if (!isset($fich['error'])) {
        $error = true;
    }
    switch ($fich['error']) {
        case UPLOAD_ERR_OK:
            $error = false;
            break;
        case UPLOAD_ERR_NO_FILE:
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
        default:
            $error = true;
    }
    return $error;
}

/**
 * Función que mueve los archivos a una carpeta del disco duro, cuyo nombre es 
 * el id del usuario y conserva el nombre original de los archivos
 * 
 * @param type $id ID del usuario
 * @param type $array Array superglobal $_FILES
 * @return boolean true si ha ido bien, false si no
 */
function moverArchivo($id, $array) {
    $error = false;
    if ($array['imagen']['size'] > 10000000) {
        $error = false;
    }
    if (!$error) {
        $ruta = getRutaImagenes($id);
        if (!file_exists($ruta)) {
            mkdir($ruta, 0775, true);
        }
        $error = comprobarErrores($array['imagen']);
        if (!$error) {
            $origin = $array['imagen']['tmp_name'];
            $destino = "$ruta" . DIRECTORY_SEPARATOR . $array['imagen']['name'];
            $error = move_uploaded_file($origin, $destino);
        }
    }
    return $error;
}

/**
 * Función con la ruta de la carpeta de un usuario en disco
 * 
 * @param type $id ID del usuario
 * @return type ruta de las carpetas
 */
function getRutaImagenes($id) {
    return __DIR__ . DIRECTORY_SEPARATOR . "imagenes" . DIRECTORY_SEPARATOR . "$id";
}