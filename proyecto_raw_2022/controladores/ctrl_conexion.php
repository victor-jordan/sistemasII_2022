<?php
/**
* Clase para conexión de base de datos
**/
set_include_path(dirname(dirname(__FILE__)).'/lib'.PATH_SEPARATOR.get_include_path());

require('FirePHPCore/fb.php');
include(__DIR__.'\..\utiles\db_config.php');

class ctrlConexion{
    private $_connection;
    private $_host;
    private $_usuario;
    private $_clave;
    private $_database;

    function __construct(){
        global $srv;
        global $usr;
        global $clv;
        global $bdn;

        $this->_host = $srv;
        $this->_usuario = $usr;
        $this->_clave = $clv;
        $this->_database = $bdn;

        // $this->_host = "localhost";
        // $this->_usuario = "root";
        // $this->_clave = "";
        // $this->_database = "colegio";

        try{
            // creamos la conexion pasando una cadena indicando el driver a ser utilizado por PDO.
            $cadena_conexion = "mysql:host={$this->_host};dbname=".$this->_database;
            $this->_connection = new PDO($cadena_conexion,$this->_usuario,$this->_clave);

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