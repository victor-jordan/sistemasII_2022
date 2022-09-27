<?php
require 'clase_interfaz.php';

abstract class Animal{
	abstract public function comer() : string;
	abstract public function moverse();
}

class Leon extends Animal{
	public $nombre;

	public function comer() : string {
		return "estoy comiendo, no molestar.<br>";
	}

	public function moverse(){
		echo "caminado<br>";
	}
}

class Gato extends Animal implements hacerRuido{
	public function comer() : string {
		return "estoy comiendo, no molestar.<br>";
	}

	public function moverse(){
		echo "caminado<br>";
	}

	public function ruido(){
		echo "Miau<br>";
	}
}

class Perro extends Animal implements hacerRuido{
	public function comer() : string {
		return "estoy comiendo, no molestar.<br>";
	}

	public function moverse(){
		echo "caminado<br>";
	}

	public function ruido(){
		echo "Guau<br>";
	}
}

class Rata extends Animal implements hacerRuido{
	public function comer() : string {
		return "estoy comiendo, no molestar.<br>";
	}

	public function moverse(){
		echo "caminado<br>";
	}

	public function ruido(){
		echo "Skuik<br>";
	}
}

$leoncito = new Leon();
$leoncito->nombre = "simba";
// echo $leoncito->comer();
// $leoncito->moverse();

// $perro = new Animal();

$michi = new Gato();
$rompe = new Perro();
$jerry = new Rata();
$animales = array($michi, $rompe, $jerry);

foreach($animales as $animal){
	$animal->ruido();
}
?>