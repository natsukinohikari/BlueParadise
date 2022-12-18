<?php

// Uso de la librería de PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

require dirname(__FILE__) . "/vendor/autoload.php";

/**
 * Función que envía un correo de confirmación a quien ha hecho la reserva, con 
 * el número de reserva
 * 
 * @param type $reserva Número de reserva
 * @param type $correo Correo del usuario
 * @return type Correo de confirmación
 */
function enviar_correos($datos, $reserva, $correo) {
    $cuerpo = crear_correo($datos, $reserva, $correo);
    $correo_reserva = "";
    return enviar_correo("$correo, $correo_reserva",
            $cuerpo, "Reserva $reserva confirmado");
}

/**
 * Crea el cuerpo del correo que se mandará
 * 
 * @param type $reserva Número de reserva
 * @param type $correo Correo del usuario
 * @return string Mensaje
 */
function crear_correo($datos, $reserva, $correo) {
    $texto = "<h1>Reserva nº $reserva</h1><h2>Usuario: $correo </h2>";
    $texto .= "Detalle de la reserva:";
    foreach ($datos as $key => $dato) {
        $texto .= "<h3>$key: $dato</h3>";
    }
    return $texto;
}

/**
 * Función que envía el correo
 * 
 * @param type $lista_correos Correo de quién solicita la reserva y el responsable del departamento
 * @param type $cuerpo Cuerpo del correo
 * @param type $asunto Asunto
 * @return boolean true si salió bien, mensaje de error si hubo algún fallo
 */
function enviar_correo($lista_correos, $cuerpo, $asunto = "") {
    $res = leer_configCorreo(dirname(__FILE__) . "/config/correo.xml", dirname(__FILE__) . "/config/correo.xsd");
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "tls";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 587;
    $mail->Username = $res[0];  //usuario de gmail
    $mail->Password = $res[1]; //contraseña de gmail          
    $mail->SetFrom('usuario_correo@gmail.com', 'Sistema de reservas');
    $mail->Subject = utf8_decode($asunto);
    $mail->MsgHTML($cuerpo);
    $correos = explode(",", $lista_correos);
    foreach ($correos as $correo) {
        $mail->AddAddress($correo, $correo);
    }
    if (!$mail->Send()) {
        return $mail->ErrorInfo;
    } else {
        return TRUE;
    }
}

/**
 * Función que comprueba si un archivo es válido y devuelve los datos del 
 * usuario que manda el correo
 * 
 * @param type $nombre Archivo de configuración con los datos
 * @param type $esquema Archivo de configuración que valida al anterior
 * @return type Datos del usuario que manda el correo
 * @throws InvalidArgumentException Si el archivo no está bien
 */
function leer_configCorreo($nombre, $esquema) {
    $config = new DOMDocument();
    $config->load($nombre);
    $res = $config->schemaValidate($esquema);
    if ($res === FALSE) {
        throw new InvalidArgumentException("Revise fichero de configuración");
    }
    $datos = simplexml_load_file($nombre);
    $usu = $datos->xpath("//usuario");
    $clave = $datos->xpath("//clave");
    $resul = [];
    $resul[] = $usu[0];
    $resul[] = $clave[0];
    return $resul;
}

