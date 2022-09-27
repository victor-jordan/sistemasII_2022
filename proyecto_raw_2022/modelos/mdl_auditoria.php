<?php
class mdlAuditoria{
    var $id;
    var $fecha;
    var $tabla;
    var $accion;
    var $usuario;

    public function nombreCompleto(){
        return "{$this->fecha}-{$this->tabla} {$this->accion}";
    }
}
?>