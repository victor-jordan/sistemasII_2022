<?php
class mdlAuditoria{
    var $id;
    var $fecha;
    var $tabla;
    var $accion;
    var $usuario;

    public function datosAuditoria(){
        return "{$this->fecha}-{$this->tabla} {$this->accion}";
    }

    public function usuarioAuditado(){
        require_once(__DIR__.'\..\controladores\ctrl_usuario.php');

        $objUsuario = new ctrlUsuario();
        $objUsuario->obtenerUno($this->usuario);

        // fb($objUsuario->usuario, FirePHP::INFO);

        return $objUsuario->usuario;
    }
}
?>