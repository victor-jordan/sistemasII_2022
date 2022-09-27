<?php
require_once('modulo_retornar_conexion.php');

function consultar($consulta){
    if($conexion = conectar()){
        $resultado = mysqli_query($conexion, $consulta);
        if($fila = mysqli_fetch_assoc($resultado)){
            return $fila;
        } else {
            return "No se encontró";
        }
    } else {
        // exit();
        die("Ocurrió un error: ".mysqli_connect_error());
    }
}

function consultar_varios($consulta){
    if($conexion = conectar()){
        $resultado = mysqli_query($conexion, $consulta);
        $devolver = array();
        while($fila = mysqli_fetch_assoc($resultado)){
            array_push($devolver, $fila);
        }
        return $devolver;
    } else {
        // exit();
        die("Ocurrió un error: ".mysqli_connect_error());
    }
}
?>