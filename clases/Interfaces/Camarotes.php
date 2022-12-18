<?php
namespace Interfaces;

// Interfaz camarotes
interface Camarotes {
    
    /**
     * Función que modificará la información de un camarote
     * @param type $id ID
     */
    public function modificarCamarote($id, $datos);
    
    /**
     * Función que añadirá un camarote
     */
    public function anadirCamarote($datos);
    
    /**
     * Función que añadirá un camarote a un crucero
     */
    public function anadirCamaroteCrucero($datos);
}

