<?php
/*
Namespaces o Espacios de Nombres
*/
namespace Htmltable;
class Table{
	public $title = "";
	public $numRows = "";

	public function datosTabla(){
		echo "<h1>Tabla '{$this->title}': {$this->numRows} filas</h1>";
	}

	public function construirTabla(){
		$this->datosTabla();
		echo "<table style='border:1px solid;'>";
		for($i=1;$i<=$this->numRows;$i++){
			echo "<tr><td>fila: {$i} de {$this->numRows}<td></tr>";
		}
		echo "</table>";
	}
}

// $tabla = new Table();
// $tabla->title = "Muestra";
// $tabla->numRows = 7;

// $tabla->construirTabla();
?>