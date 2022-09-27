<?php
require('modulo_insertar_datos.php');
require('modulo_retornar_consulta.php');

echo "<h1>Insertar/Modificar datos de forma modular.</h1>";

// $insert = 'INSERT INTO usuario (username) VALUES("chompiras");';
// $update = 'UPDATE usuario SET username="mas_cambio" WHERE id=9;';
$select = 'SELECT * FROM usuario;';

// insertar_modificar($insert);
// insertar_modificar($update);

$listado = consultar_varios($select);

foreach ($listado as $dato) {
	echo "<p>".$dato['id'].".- ".$dato['username']."</p>";
}
?>