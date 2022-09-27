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
        $this->usuario = new mdlUsuario();
        $conexion = new ctrlConexion();

        $consulta = "select id, username, password, nombre, apellido, activo from usuario where username = '{$usuario}' and password = '{$clave}';";

        try {
            $resultado = $conexion->getConexion()->query($consulta);
            if ($resultado->rowcount()>0) {
                $login = $resultado->fetch(PDO::FETCH_ASSOC);
                $this->usuario->id = $login['id'];
                $this->usuario->username = $login['username'];
                $this->usuario->nombre = $login['nombre'];
                $this->usuario->apellido = $login['apellido'];
                $this->usuario->activo = boolval($login['activo']);
            }
        } catch (PDOException $e){
            // si algo falla mostramos el error
            echo "Usuario o clave incorrectos.";
            $this->usuario = null;
        }        
        // return $this->usuario;
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
            echo "Falló algo: ".$e->getMessage();
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

    public function insertarUsuario(mdlUsuario $objeto){
        try{
            $this->usuario = $objeto;
            $bd = new ctrlConexion();
            $conexion = $bd->getConexion();
            $sentencia = "INSERT INTO usuario (username, password, nombre, apellido, activo) VALUES ('%s', '%s', '%s', '%s', %d);";
            $ejecutar = sprintf($sentencia, $this->usuario->username, $this->usuario->password, $this->usuario->nombre, $this->usuario->apellido, $this->usuario->activo);
            $conexion->beginTransaction();
            $conexion->exec($ejecutar);
            $conexion->commit();

            // Indicamos la auditoria de esta acción
            // $ob_audit = new mdlAuditoria();
            // $ob_audit->fecha = date("Y-m-d H:i:s");
            // $ob_audit->fecha = date("Y-m-d");
            // $ob_audit->tabla = 'usuario';
            // $ob_audit->accion = 'Creado: ' . $this->usuario->username;

            // $ct_audit = new ctrlAuditoria;
            // $ct_audit->insertarRegistro($ob_audit);
            
            return "Usuario: " . $this->usuario->username . " creado correctamente";
        } catch (PDOException $e){
            // Si algo falla, deshacemos la transacción y mostramos el error
            $conexion->rollback(); // termina la transacción
            return "Falla:" . $e->getMessage();
        }
        $conexion->__destruct();
    }

    
}
?>