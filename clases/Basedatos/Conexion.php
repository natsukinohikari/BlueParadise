<?php
namespace Basedatos;

// Clase Conexion
class Conexion {
    
    // Atributos de la clase
    private $ip;
    private $nombre;
    private $usuario;
    private $pass;
    
    /**
     * Función que intentará realizar una conexión con la base de datos
     * 
     * @return type conexión con la base de datos
     */
    protected function conectar() {
        try {
            $res = $this->leer_config(dirname(__FILE__) . "/../../config/configuracion.xml", dirname(__FILE__) . "/../../config/configuracion.xsd");
            $conexion = new \PDO($res[0], $res[1], $res[2]);
            return $conexion;
        } catch (\PDOException $ex) {
            die("Error: " . $ex->getMessage());
        }
    }
    
    /**
     * Función que recoge la información a la BBDD de un archivo externo
     * 
     * @param type $fichero_config_BBDD Archivo de configuración
     * @param type $esquema Archivo que valida el anterior
     * @return type Datos para la conexión a la base de datos en forma de array
     * @throws InvalidArgumentException Mensaje de error si el archivo de configuración no es válido
     */
    private function leer_config($fichero_config_BBDD, $esquema) {
        $config = new \DOMDocument();
        $config->load($fichero_config_BBDD);
        $res = $config->schemaValidate($esquema);
        if ($res === FALSE) {
            throw new \InvalidArgumentException("Revise el fichero de configuración");
        }
        $datos = simplexml_load_file($fichero_config_BBDD);
        $this->ip = $datos->xpath("//ip");
        $this->nombre = $datos->xpath("//nombre");
        $this->usuario = $datos->xpath("//usuario");
        $this->pass = $datos->xpath("//clave");
        $cad = sprintf("mysql:dbname=%s;host=%s", $this->nombre[0], $this->ip[0]);
        $resul = [];
        $resul[] = $cad;
        $resul[] = $this->usuario[0];
        $resul[] = $this->pass[0];
        return $resul;
    }
}