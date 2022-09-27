<?php
/*
Clase para conexión de base de datos
*/
require(__DIR__.'\..\utiles\db_config.php');

class ctrlConexion{
    private $_connection;
    private $_host;
    private $_username;
    private $_password;
    private $_database;

    function __construct(){
        // $this->_host = $servidor;
        // $this->_username = $usuario;
        // $this->_password = $clave;
        // $this->_database = $bdnombre;
        $this->_host = "localhost";
        $this->_username = "root";
        $this->_password = "";
        $this->_database = "colegio";

        try{
            // creamos la conexion pasando una cadena indicando el driver a ser utilizado por PDO.
            $cadena_conexion = "mysql:host={$this->_host};dbname=".$this->_database;
            $this->_connection = new PDO($cadena_conexion,$this->_username,$this->_password);

            // le indicamos a PDO que debe capturar los errores o excepciones si ocurren.
            $this->_connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            // si algo falla mostramos el error
            echo "Falló algo: ".$e->getMessage();
        }
    }

    public function getConexion(){
        return $this->_connection;
    }

    public function verDatos(){
        return "mysql:host={$this->_host};dbname=".$this->_database.",".$this->_username.",".$this->_password;
    }

    public function __destruct(){
        if($this->_connection){
            $this->_connection = null;
        }
    }
}
?>