<?php
class mdlArancel{
    var $id;
    var $descripcion;
    var $monto;
    var $vigente;

    public function representacion(){
        return "{$this->descripcion} {$this->monto}";
    }
}
?>