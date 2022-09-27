<?php
class mdlDocumentosExpedidos{
    var $id;
    var $alumno_afectado;
    var $arancel_cobrado;
    var $fecha_proceso;
    var $pago_parcial;
    var $saldo;
    var $tipo_documento;

    public function representacion(){
        return "{$this->alumno_afectado}-{$this->arancel_cobrado}";
    }
}
?>