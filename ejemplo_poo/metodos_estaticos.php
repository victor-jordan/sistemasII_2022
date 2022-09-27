<?php
/**
 * Ejemplo de metodos estáticos o Static Methods
 */
class UnaClase{
    public static function metodoEstatico(){
        echo "Hola Mundo<br>";
    }

    public function __construct(){
        echo "Soy ". get_class($this) ."<br>";
        self::metodoEstatico();
    }
}

class OtraClase extends UnaClase{}

class pi{
    public static $valor = 3.14159;
}

echo pi::$valor;

// Instancia inicilizada
// $instancia = new UnaClase();

// Instancia anonima
// new OtraClase();
// echo $instancia->metodoEstatico()." desde instancia <br>";
// echo UnaClase::metodoEstatico()." desde clase/modelo <br>";
?>