<?php
class mdlInformacionInscripcion{
    var $id;
    var $alumno_inscripto;
    var $fecha_inscripcion;
    var $trasladado;
    var $observacion;

    public function representacion(){
        return "{$this->alumno_inscripto}-{$this->fecha_inscripcion}";
    }
}
?>