<?php
// Espacio donde se localizan las funciones de la base de datos
namespace Basedatos;

use Traits\Fechas as log;
use Basedatos\Conexion as con;
use Interfaces\Camarotes as cam;

// Clase que almacena las funciones de la base de datos
class Funciones extends con implements cam {
    
    use log; // Trait
    
    /**
     * Función que comprobará si los datos son correctos al intentar hacer un login.
     * Si lo son, devolverá un array con el id del usuario, su correo y su nombre
     * 
     * @param type $correo correo
     * @param type $clave contraseña
     * @return type la informacion en array; false si no
     */
    public function comprobarUsuario($correo, $clave) {
        $dev = false;
        $puntero = $this->conectar();
        $hash = $this->recuperarContraHash($correo);
        if (password_verify($clave, $hash)) {
            $sql = "SELECT U.id_usuario, U.correo, U.nombre, U.puntos, R.tipo FROM USUARIOS AS U INNER JOIN ROLES AS R ON U.id_rol = R.id_rol WHERE correo = ?";
            $stmt = $puntero->prepare($sql);
            $stmt->bindValue(1, $correo);
            $stmt->execute();
            if ($stmt->rowCount() === 1) {
                $dev = $stmt->fetch();
            }
        }
        unset($puntero);
        return $dev;
    }
    
    /**
     * Función que devolverá la contraseña del usuario que intenta hacer un login de forma encriptada
     * 
     * @param type $correo Correo del usuario
     * @return type false si no hay clave; clave si está
     */
    public function recuperarContraHash($correo) {
        $clave = false;
        $puntero = $this->conectar();
        $sql = "SELECT clave FROM USUARIOS WHERE correo = ?";
        $stmt = $puntero->prepare($sql);
        $stmt->bindValue(1, $correo);
        $stmt->execute();
        $resultado = $stmt->fetch();
        if ($resultado !== false) {
            $clave = $resultado['clave'];
        }
        unset($puntero);
        return $clave;
    }
    
    /**
     * Función que añadirá un nuevo usuario 
     * 
     * @param type $datos Datos
     * @param type $tipos Tipos para el array datos
     */
    public function anadirPerfil($datos) {
        $puntero = $this->conectar();
        $sql = "INSERT INTO USUARIOS (correo, clave, nombre, apellidos, fecha_nacimiento, direccion, telefono, puntos, imagen, id_rol) VALUES"
                . "(:correo, :clave, :nombre, :apellidos, :fecha_nacimiento, :direccion, :telefono, :puntos, :imagen, :id_rol)";
        $stmt = $puntero->prepare($sql);
        foreach ($datos as $key => $value) {
            $stmt->bindValue(":$key", $value);            
        }
        $stmt->execute();
        unset($puntero);
    }
    
    /**
     * Función que actualizará los datos del perfil
     * 
     * @return type true si ha ido bien, false si no
     */
    public function actualizarPerfil($data, $id) {
        $puntero = $this->conectar();
        try {
            $puntero->beginTransaction();
            foreach ($data as $key => $value) {
                $sql = "UPDATE USUARIOS SET $key = ? WHERE id_usuario = ?";
                $stmt = $puntero->prepare($sql);
                $stmt->bindValue(1, $value);
                $stmt->bindValue(2, $id);
                $stmt->execute();
            }
            $puntero->commit();
            unset($puntero);
            return true;
        } catch (\PDOException $ex) {
            $puntero->rollBack();
            unset($puntero);
            return false;
        }
    }
    
    /**
     * Función que devuelve el último ID insertado de la tabla reservas
     * 
     * @return type último ID
     */
    function ultimoIDReserva() {
        $puntero = $this->conectar();
        $sql = "SELECT MAX(id_reserva) FROM RESERVAS";
        $stmt = $puntero->prepare($sql);
        $stmt->execute();
        $fila = $stmt->fetch();
        if ($fila !== false) {
            $id = trim($fila[0]);
        }
        unset($puntero);
        return $id;
    }
    
    /**
     * Función que devuelve el último ID insertado de la tabla usuarios
     * 
     * @return type último ID
     */
    function ultimoIDUsuario() {
        $puntero = $this->conectar();
        $sql = "SELECT MAX(id_usuario) FROM USUARIOS";
        $stmt = $puntero->prepare($sql);
        $stmt->execute();
        $fila = $stmt->fetch();
        if ($fila !== false) {
            $id = trim($fila[0]);
        }
        unset($puntero);
        return $id;
    }
    
    /**
     * Función que recupera la ruta de una imagen asociada al ID
     * 
     * @param type $id ID del usuario
     * @return type Ruta de la imagen
     */
    function obtenerImagen($id) {
        $puntero = $this->conectar();
        $sql = "SELECT imagen FROM USUARIOS WHERE id_usuario = $id";
        $stmt = $puntero->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetch();
        if ($datos !== false) {
            unset($puntero);
            return $datos;
        } else {
            unset($puntero);
            return false;
        }
    }
    
    /**
     * Función que registra la fecha en la que el usuario ha iniciado sesión 
     * o modificado sus datos
     * 
     * @param type $id ID del usuario
     * @param type $tipo Texto con el tipo de acción realizada
     */
    function guardarAcciones($id, $tipo) {
        $puntero = $this->conectar();
        $sql = "INSERT INTO ACCIONES (fecha, tipo, id_usuario) VALUES (?, ?, ?)";
        $stmt = $puntero->prepare($sql);
        $stmt->bindValue(1, $this->getFechaHora());
        $stmt->bindValue(2, $tipo);
        $stmt->bindValue(3, $id);
        $stmt->execute();
        unset($puntero);
    }
    
    /**
     * Función que obtiene los datos del perfil asociado a un ID
     * 
     * @param type $id ID del usuario
     * @return int Datos del perfil
     */
    function obtenerDatosPerfil($id) {
        $puntero = $this->conectar();
        $sql = "SELECT nombre, apellidos, fecha_nacimiento, direccion, telefono, puntos FROM USUARIOS WHERE id_usuario = $id";
        $stmt = $puntero->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetch();
        if ($datos !== false) {
            unset($puntero);
            return $datos;
        } else {
            unset($puntero);
            return false;
        }
    }
    
    /**
     * Función que obtiene todos los datos de los perfiles registrados
     * 
     * @return int Datos de los perfiles
     */
    function obtenerPerfiles() {
        $puntero = $this->conectar();
        $sql = "SELECT U.id_usuario, U.correo, U.nombre, U.apellidos, U.fecha_nacimiento, U.direccion, U.telefono, R.tipo FROM USUARIOS AS U INNER JOIN ROLES AS R ON U.id_rol = R.id_rol";
        $stmt = $puntero->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetchAll();
        if ($datos !== false) {
            unset($puntero);
            return $datos;
        } else {
            unset($puntero);
            return false;
        }
    }
    
    /**
     * Función que recuperará los datos de los cruceros
     *  
     * @return type false si no hay cruceros o los datos de lo solicitado
     */
    function obtenerInfoCruceros() {
        $puntero = $this->conectar();
        $sql = "SELECT C.id_crucero, C.nombre, R.id_ruta, R.itinerario, R.coste, CR.salida, CR.llegada, CR.id_crucero_ruta FROM CRUCEROS AS C" 
                . " INNER JOIN CRUCEROS_RUTAS AS CR ON C.id_crucero = CR.id_crucero"
                . " INNER JOIN RUTAS AS R ON CR.id_ruta = R.id_ruta"
                . " INNER JOIN ZONAS AS Z ON R.id_zona = Z.id_zona";
        $stmt = $puntero->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetchAll();
        if ($datos !== false) {
            unset($puntero);
            return $datos;
        } else {
            unset($puntero);
            return false;
        }
    }
    
    /**
     * Función que recuperará los datos de los camarotes asociados a un crucero
     *  
     * @return type false si no hay cruceros o los datos de lo solicitado
     */
    function obtenerInfoCamarotes($id) {
        $puntero = $this->conectar();
        $sql = "SELECT CC.id_camarote_crucero, CC.id_camarote, CC.cantidad, CM.* FROM CAMAROTES_CRUCEROS AS CC" 
                . " INNER JOIN CAMAROTES AS CM ON CC.id_camarote = CM.id_camarote"
                . " WHERE CC.id_crucero = ?";
        $stmt = $puntero->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->execute();
        $datos = $stmt->fetchAll();
        if ($datos !== false) {
            unset($puntero);
            return $datos;
        } else {
            unset($puntero);
            return false;
        }
    }
    
    /**
     * Función que añade una reserva a la base de datos
     * 
     * @param type $usuario ID del usuario
     * @param type $idcamarotecrucero ID del camarote del crucero
     * @param type $precio Precio de la reserva
     * @param type $idruta Ruta de la reserva
     * @param type $puntero Conexión a la base de datos
     */
    private function hacerReserva($usuario, $idcamarotecrucero, $precio, $idruta, $puntero) {
        $sql = "INSERT INTO RESERVAS (fecha, precio, id_camarote_crucero, id_usuario, id_ruta) VALUES (?, ?, ?, ?, ?)";
        $stmt = $puntero->prepare($sql);
        $stmt->bindValue(1, $this->getFechaHora());
        $stmt->bindValue(2, $precio);
        $stmt->bindValue(3, $idcamarotecrucero);
        $stmt->bindValue(4, $usuario);
        $stmt->bindValue(5, $idruta);
        $stmt->execute();
    }
    
    /**
     * Función que sirve para actualizar los puntos del usuario tras una reserva
     * 
     * @param type $usuario ID del usuario
     * @param type $puntero Conexión a la base de datos
     */
    private function actualizarPuntosUsuario($puntos, $usuario, $puntero) {
        $sql = "UPDATE USUARIOS SET puntos = ? WHERE id_usuario = ?";
        $stmt = $puntero->prepare($sql);
        $stmt->bindValue(1, $puntos);
        $stmt->bindValue(2, $usuario);
        $stmt->execute();
    }
    
    /**
     * Función que actualiza los camarotes restantes
     * 
     * @param type $puntero Conexión a la BBDD
     * @param type $idcamarotecrucero ID
     * @param type $cantidad Cantidad
     */
    private function actualizarCamarotesRestantes($puntero, $idcamarotecrucero, $cantidad) {
        $sql = "UPDATE CAMAROTES_CRUCEROS SET cantidad = ? WHERE id_camarote_crucero = ?";
        $stmt = $puntero->prepare($sql);
        $stmt->bindValue(1, $cantidad);
        $stmt->bindValue(2, $idcamarotecrucero);
        $stmt->execute();
    }
    
    /**
     * Función que realizará toda la adición a la base de datos de una reserva, así como actualización de datos
     * 
     * @param type $usuario ID del usuario
     * @param type $idcamarotecrucero ID del camarote del crucero
     * @param type $precio Precio de la reserva
     * @param type $idruta Ruta de la reserva
     */
    function Reserva($usuario, $idcamarotecrucero, $precio, $idruta, $puntos, $ncamarotes) {
        $puntero = $this->conectar();
        try {
            $puntero->beginTransaction();
            $this->hacerReserva($usuario, $idcamarotecrucero, $precio, $idruta, $puntero);
            $this->actualizarPuntosUsuario($puntos, $usuario, $puntero);
            $this->actualizarCamarotesRestantes($puntero, $idcamarotecrucero, $ncamarotes);
            $puntero->commit();
            unset($puntero);
            return true;
        } catch (\PDOException $ex) {
            $puntero->rollBack();
            unset($puntero);
            return false;
        }
    }
    
    /**
     * Función que recuperará los roles existentes
     *  
     * @return type false si no hay cruceros o los roles
     */
    function obtenerRoles() {
        $puntero = $this->conectar();
        $sql = "SELECT id_rol, tipo FROM ROLES";
        $stmt = $puntero->prepare($sql);
        $stmt->execute();
        $datos = $stmt->fetchAll();
        if ($datos !== false) {
            unset($puntero);
            return $datos;
        } else {
            unset($puntero);
            return false;
        }
    }
    
    /**
     * Función que actualizará el rol de un usuario
     * 
     * @param type $id_rol ID del rol
     * @param type $id_usuario ID del usuario a actualizar
     */
    function actualizarRolUsuario($id_rol, $id_usuario) {
        $puntero = $this->conectar();
        $sql = "UPDATE USUARIOS SET id_rol = ? WHERE id_usuario = ?";
        $stmt = $puntero->prepare($sql);
        $stmt->bindValue(1, $id_rol);
        $stmt->bindValue(2, $id_usuario);
        $stmt->execute();
        unset($puntero);
    }

    /**
     * Función que añadirá un camarote
     * 
     * @param type $datos Datos a insertar
     */
    public function anadirCamarote($datos) {
        $puntero = $this->conectar();
        $sql = "INSERT INTO CAMAROTES (numerocamas, descripcion, coste) VALUES (?, ?, ?)";
        $stmt = $puntero->prepare($sql);
        for ($i = 1; $i <= count($datos); $i++) {
            $stmt->bindValue($i, $datos[$i - 1]);
        }
        $stmt->execute();
        unset($puntero);
    }

    /**
     * Función que modificará la información de un camarote
     * 
     * @param type $id ID
     * @param type $datos Datos con la información a modificar
     */
    public function modificarCamarote($id, $datos) {
        $puntero = $this->conectar();
        try {
            $puntero->beginTransaction();
            foreach ($datos as $key => $value) {
                $sql = "UPDATE CAMAROTES SET $key = ? WHERE id_camarote = ?";
                $stmt = $puntero->prepare($sql);
                $stmt->bindValue(1, $value);
                $stmt->bindValue(2, $id);
                $stmt->execute();
            }
            $puntero->commit();
            unset($puntero);
            return true;
        } catch (\PDOException $ex) {
            $puntero->rollBack();
            unset($puntero);
            return false;
        }
    }

    /**
     * Función que añadirá un camarote a un crucero
     * 
     * @param type $datos Datos a insertar
     */
    public function anadirCamaroteCrucero($datos) {
        $puntero = $this->conectar();
        $sql = "INSERT INTO CAMAROTES_CRUCEROS (id_camarote, id_crucero, cantidad) VALUES (?, ?, ?)";
        $stmt = $puntero->prepare($sql);
        for ($i = 1; $i <= count($datos); $i++) {
            $stmt->bindValue($i, $datos[$i - 1]);
        }
        $stmt->execute();
        unset($puntero);
    }
}