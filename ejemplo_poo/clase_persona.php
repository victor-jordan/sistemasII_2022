<?php
/* Creamos una clase Persona */
class Persona
{
    public $nombre;
    private $edad;
    protected $cic;
    const SEXO = "mujer";

    function __construct($_nombre, $_edad)
    {
        $this->nombre = $_nombre;
        $this->edad = $_edad;
    }

    function setEdad($valor){
        $this->edad = $valor;
    }

    private function getEdad(){
        return $this->edad;
    }

    public function decirEdad(){
        return $this->getEdad();
    }

    // function __destruct(){
    //     echo "Objeto {$this->nombre} destruido.<br>";
    // }

    public function Presentarme(){
        return "Me llamo {$this->nombre} y tengo {$this->edad} años.";
    }
}

/* Heredamos de la clase Persona en otra clase */

class Juan extends Persona
{
    public $apellido;
    // automáticamente hereda los atributos y los métodos __construct y Presentarme
    // escribimos un metodo propio de Juan
    function __construct($_apellido, $_edad, $_nombre="Juan"){
        $this->nombre = $_nombre;
        $this->apellido = $_apellido;
        $this->edad = $_edad;
    }

    public function Presentarme(){
        return "Me llamo {$this->nombre} {$this->apellido} y tengo {$this->edad} años.";
    }   

    public function DecirHola(){
        echo "Soy " . self::SEXO. " y " .$this->Presentarme();
    }
}

final class Claudia extends Juan
{
    function __construct($_nombre="Claudia", $_apellido="Cano", $_edad=8){
        $this->nombre = $_nombre;
        $this->apellido = $_apellido;
        $this->edad = $_edad;
    }

    public function DecirHola(){
        echo "El polimorfismo. ".$this->Presentarme();
    }
}

// class bebe extends Claudia{
//     function __destruct(){
//         echo "bebe muerto";
//     }
// }

// Demostración de checkeo de instancia
function modulo($objeto){
    if ($objeto instanceof Persona) {
        echo "Es una persona <br>";
        var_dump($objeto instanceof Persona);
        echo "<br>";
        var_dump($objeto);
    } else{
        echo "No es una persona <br>";
        var_dump($objeto instanceof Persona);
        echo "<br>";
        var_dump($objeto);
    }
}

// $una_persona = new Persona('Carmen',28);

// $juan = new Juan("Cano",33);

// $analia = new Analia();

// $kape = "Juan";

// echo $una_persona->Presentarme();
// echo "<br>";
// $juan->DecirHola();
// echo "<br>";
// $analia->DecirHola();
// echo "<br>";
// $analia_mayor = new Analia("Petrona", "Caceres", 20);
// $analia_mayor->DecirHola();
// echo "<br>";

// modulo($kape);

$pepito = new Juan("pepito", 25);
$pepito->nombre = "josesito";
// $pepito->cic = "3552487";
// $pepito->edad = 36;
// echo $pepito->nombre . " " . strval($pepito->edad);

// $pepito->setEdad(36);
// echo $pepito->nombre . " " . strval($pepito->decirEdad());
// echo $pepito->nombre . " es " . $pepito::SEXO;
echo $pepito->DecirHola();



?>