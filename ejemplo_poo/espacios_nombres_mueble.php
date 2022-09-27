<?php
/*
Namespaces o Espacios de Nombres
*/
namespace Furniture;
class Table{
	public $color = "";
	public $material = "";

	public function datosMesa(){
		echo "<h1>Mesa '{$this->color}' de {$this->material}</h1>";
	}
}

// $tabla = new Table();
// $tabla->title = "Muestra";
// $tabla->numRows = 7;

// $tabla->construirTabla();
?>