<?php
/*
Clase que permitira manipular los objetos de usuarios, del mismo modo permitira capturar procesos de login
*/
require_once('ctrl_conexion.php');
require_once('ctrl_auditoria.php');
require_once(__DIR__.'\..\modelos\mdl_auditoria.php');
require_once(__DIR__.'\..\modelos\mdl_usuario.php');

class ctrlUsuario{
    public $usuario;
    public $usuarios;

    public static function autenticarUsuario($usuario, $clave){
        /**
         * Esta clase será la que vaya hasta la base de datos para verificar 
         * que el usuario es quien dice ser, tiene lo mínimo para hacer esa 
         * verificación.
         * Además establecerá la sesión con los datos que se utilizarán durante
         * el uso del sistema.
         * **/
        $objeto = new mdlUsuario();
        $conexion = new ctrlConexion();

        $consulta = "select id, username, password, nombre, apellido, activo from usuario where username = '{$usuario}' and password = '{$clave}';";

        try {
            $resultado = $conexion->getConexion()->query($consulta);
            if ($resultado->rowcount()>0) {
                $login = $resultado->fetch(PDO::FETCH_ASSOC);
                $objeto->id = $login['id'];
                $objeto->username = $login['username'];
                $objeto->nombre = $login['nombre'];
                $objeto->apellido = $login['apellido'];
                $objeto->activo = boolval($login['activo']);
            }
        } catch (PDOException $e){
            // si algo falla mostramos el error
            echo "Usuario o clave incorrectos.";
            $objeto = null;
        }

        if ($objeto == null or $objeto->activo == false) {
            $mensaje = "No existe usuario o está inactivo. Contactar con el Administrador.";
        } else {
            $_SESSION['username'] = $objeto->username;
            $_SESSION['usuario_nombre_completo'] = $objeto->nombreCompleto();
            $mensaje = "Acceso correcto.";
            fb($_SESSION['username'], FirePHP::INFO);
            fb($_SESSION['usuario_nombre_completo'], FirePHP::INFO);
        }


        return $mensaje;
    }
    
    public function obtenerUno($id){
        $this->usuario = new mdlUsuario();
        $conexion = new ctrlConexion();

        $consulta = "select id, username, password, nombre, apellido, activo from usuario where id = {$id};";

        try {
            $resultado = $conexion->getConexion()->query($consulta);
            if ($resultado->rowcount()>0) {
                $registro = $resultado->fetch(PDO::FETCH_ASSOC);
                $this->usuario->id = $registro['id'];
                $this->usuario->username = $registro['username'];
                $this->usuario->password = $registro['password'];
                $this->usuario->nombre = $registro['nombre'];
                $this->usuario->apellido = $registro['apellido'];
                $this->usuario->activo = boolval($registro['activo']);
            }
        } catch (PDOException $e){
            // si algo falla mostramos el error
            echo "Falló algo en usu obtener 1: ".$e->getMessage();
        }

        $conexion->__destruct();
    }

    public function obtenerTodos(){
        $this->usuarios = array();
        $conexion = new ctrlConexion();
        $instanciaUsuario = new mdlUsuario();
        $consulta = "select id, username, password, nombre, apellido, activo from usuario;";
        try{
            $resultado = $conexion->getConexion()->query($consulta);
            while ($fila = $resultado->fetch(PDO::FETCH_ASSOC)) {
                $instanciaUsuario->id = $fila['id'];
                $instanciaUsuario->username = $fila['username'];
                $instanciaUsuario->password = $fila['password'];
                $instanciaUsuario->nombre = $fila['nombre'];
                $instanciaUsuario->apellido = $fila['apellido'];
                $instanciaUsuario->activo = boolval($fila['activo']);
                $this->usuarios[] = $instanciaUsuario;
                $instanciaUsuario = new mdlUsuario();
            }
        }  catch (PDOException $e){
            // Si algo falla mostramos el error
            echo "Falla:" . $e->getMessage();
        }
        $conexion->__destruct();
    }

    public function upsertUsuario(mdlUsuario $objeto, $accion){
        try{
            $this->usuario = $objeto;
            $bd = new ctrlConexion();
            $conexion = $bd->getConexion();
            if ($accion=='insertar') {
                $sentencia = "INSERT INTO usuario (username, password, nombre, apellido, activo) VALUES ('%s', '%s', '%s', '%s', %d);";
                $ejecutar = sprintf($sentencia, $this->usuario->username, $this->usuario->password, $this->usuario->nombre, $this->usuario->apellido, $this->usuario->activo);
                $respuesta = "Usuario: ".$this->usuario->username." creado correctamente";
            } else {
                $sentencia = "UPDATE usuario SET username = '%s', nombre = '%s', apellido = '%s', activo = %d WHERE id = %d;";
                $ejecutar = sprintf($sentencia, $this->usuario->username, $this->usuario->nombre, $this->usuario->apellido, $this->usuario->activo, $this->usuario->id);
                $respuesta = "Usuario: ".$this->usuario->username." modificado correctamente";
            }

            // fb($ejecutar, FirePHP::LOG);

            $conexion->beginTransaction();
            $conexion->exec($ejecutar);
            $conexion->commit();

            // Indicamos la auditoria de esta acción
            $ob_audit = new mdlAuditoria();
            // $ob_audit->fecha = date("Y-m-d H:i:s");
            $ob_audit->fecha = date("Y-m-d");
            $ob_audit->tabla = 'usuario';
            if ($accion=='insertar') {
                $ob_audit->accion = 'Creado: '.$this->usuario->username;
            } else{
                $ob_audit->accion = 'Modificado: '.$this->usuario->username;
            }
            $ob_audit->usuario = 1;

            $ct_audit = new ctrlAuditoria;
            $ct_audit->insertarRegistro($ob_audit);
            
            return $respuesta;
        } catch (PDOException $e){
            // Si algo falla, deshacemos la transacción y mostramos el error
            $conexion->rollback(); // termina la transacción
            return "Falla:" . $e->getMessage();
        }
        $conexion->__destruct();
    }

    public function eliminarUsuario(mdlUsuario $objeto){
         try{
             $this->usuario = $objeto;
             $bd = new ctrlConexion();
             $conexion = $bd->getConexion();
             $sentencia = "DELETE FROM usuario WHERE id = %d;";
             $ejecutar = sprintf($sentencia, $this->usuario->id);
             $respuesta = "Usuario: ".$this->usuario->username." eliminado correctamente";
             
            // fb($ejecutar, FirePHP::SUCCESS);

            $conexion->beginTransaction();
            $conexion->exec($ejecutar);
            $conexion->commit();

            // Indicamos la auditoria de esta acción
            $ob_audit = new mdlAuditoria();
            // $ob_audit->fecha = date("Y-m-d H:i:s");
            $ob_audit->fecha = date("Y-m-d");
            $ob_audit->tabla = 'usuario';
            $ob_audit->accion = 'Eliminado: '.$this->usuario->username;
            $ob_audit->usuario = 1;

            $ct_audit = new ctrlAuditoria;
            $ct_audit->insertarRegistro($ob_audit);
            
            return $respuesta;
         } catch (PDOException $e){
            // Si algo falla, deshacemos la transacción y mostramos el error
            $conexion->rollback(); // termina la transacción
            return "Falla:" . $e->getMessage();
         }
         $conexion->__destruct();
    }
}
?>