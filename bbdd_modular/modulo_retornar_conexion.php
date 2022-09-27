<?php
function conectar(){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "test";

    $conexion = mysqli_connect($servername, $username, $password, $dbname);

    if(mysqli_connect_errno($conexion)){
        echo "Falló la conexión: ".mysqli_connect_error();
        return null;
    } else {
        return $conexion;
    }
}
?>