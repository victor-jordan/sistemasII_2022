<?php
require_once('modulo_retornar_conexion.php');

function insertar_modificar($sentencia){
    if($conexion = conectar()){
        mysqli_query($conexion, $sentencia);
        return true;
    } else {
        return false;
    }
}
?>