<?php
class mdlAlumno{
    var $id;
    var $nombre;
    var $apellido;
    var $cic;
    var $fecha_nacimiento;

    public function nombreCompleto(){
        return "{$this->nombre} {$this->apellido}";
    }
}
?>