<?php

namespace Traits;

trait Fechas {
    
    /**
     * Función que devolverá una fecha con un determinado formato
     * 
     * @return type fecha
     */
    function getFechaHora() {
        return date("Y-m-d H:i:s");
    }
}
