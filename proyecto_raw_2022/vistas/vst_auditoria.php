<?php
require_once(__DIR__.'\..\controladores\ctrl_auditoria.php');

$ctrlAuditoria = new ctrlAuditoria();
$ctrlAuditoria->obtenerTodos();

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/mvp.css/1.6.3/mvp.min.css">
    <title>Vista Auditoría</title>
    <style>
        #mensaje{
            background-color: red;
            float: right;
        }
        #formulario{
            float: left;
            width: 50%;
        }
        #lista{
            float: left;
            width: 50%;
        }
    </style>
</head>
<body>
    <div id="lista" style="width: 100%;">
    <h1>Registros de Auditoría</h1>
    <table>
        <thead>
            <tr><th>#</th><th>fecha</th><th>tabla auditada</th><th>accion</th><th>usuario</th></tr>
        </thead>
        <tbody>
<?php
    foreach($ctrlAuditoria->auditorias as $registro){
        echo "<tr><td>{$registro->id}</td><td>{$registro->fecha}</td><td>{$registro->tabla}</td><td>{$registro->accion}</td><td>".($registro->usuarioAuditado())."</td></tr>";
        // echo "<tr><td>{$registro->id}</td><td>{$registro->fecha}</td><td>{$registro->tabla}</td><td>{$registro->accion}</td><td>{$registro->usuario}</td></tr>";
    }
    $ctrlAuditoria = null;
?>
        </tbody>
    </table>
    </div>
</body>
</html>