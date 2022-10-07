<?php
/*
Controlador de la tabla auditoria para todas las operaciones
y eventos en las tablas
*/
// set_include_path(dirname(dirname(__FILE__)).'/lib'.PATH_SEPARATOR.get_include_path());


// require('FirePHPCore/fb.php');
require_once('ctrl_conexion.php');
require_once(__DIR__.'\..\modelos\mdl_auditoria.php');

class ctrlAuditoria{
    public $auditorias;

    public function obtenerTodos(){
        $this->auditorias = array();
        $conexion = new ctrlConexion();
        $instanciaAuditoria = new mdlAuditoria();

        $consulta = "select id, fecha, tabla, accion, usuario from auditoria;";

        try {
            $resultado = $conexion->getConexion()->query($consulta);
            while($registro = $resultado->fetch(PDO::FETCH_ASSOC)){
                $instanciaAuditoria->id = $registro['id'];
                $instanciaAuditoria->fecha = $registro['fecha'];
                $instanciaAuditoria->tabla = $registro['tabla'];
                $instanciaAuditoria->accion = $registro['accion'];
                $instanciaAuditoria->usuario = $registro['usuario'];
                $this->auditorias[] = $instanciaAuditoria;
                $instanciaAuditoria = new mdlAuditoria();
            }
        } catch (PDOException $e){
            // si algo falla mostramos el error
            echo "Falló algo: ".$e->getMessage();
        }

        $conexion->__destruct();
    }

    public function insertarRegistro(mdlAuditoria $objeto){
            $base_datos = new ctrlConexion();
            $conexion = $base_datos->getConexion();

            $sentencia = "INSERT INTO auditoria (fecha, tabla, accion, usuario) VALUES ('%s', '%s', '%s', %d);";
        try{
            $ejecutar = sprintf($sentencia, $objeto->fecha, $objeto->tabla, $objeto->accion, $objeto->usuario);

            // fb($ejecutar, FirePHP::INFO);

            // Usamos la caracteristica de transact SQL
            $conexion->beginTransaction();
            $conexion->exec($ejecutar);
            $conexion->commit();
        } catch (PDOException $e){
            // si algo falla mostramos el error
            echo "Falló algo: ".$e->getMessage();
            // fb("Falló algo: ".$e->getMessage(), FirePHP::ERROR);
        }
    }
}
?>