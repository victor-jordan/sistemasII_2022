<?php
require_once(__DIR__.'\..\controladores\ctrl_usuario.php');
require_once(__DIR__.'\..\modelos\mdl_usuario.php');
require(__DIR__.'\..\utiles\limpiar_datos.php');

$ctrlUsuarios = new ctrlUsuario();
$ctrlUsuarios->obtenerTodos();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $accion = $_POST['accion'];
    $usuario = new mdlUsuario();
    $usuario->username = limpiarDatos($_POST['username']);
    $usuario->nombre = limpiarDatos($_POST['nombre']);
    $usuario->apellido = limpiarDatos($_POST['apellido']);
    
    if (isset($_POST['activo'])) {
        $usuario->activo = true;
    } else{
        $usuario->activo = false;
    }

    if ($accion == 'insertar') {
        $usuario->password = limpiarDatos($_POST['password']);
    } else {
        $usuario->id = limpiarDatos($_POST['id']);
    }

    if($accion != 'eliminar'){
        $resultado = $ctrlUsuarios->upsertUsuario($usuario, $accion);
    } else{
        $resultado = $ctrlUsuarios->eliminarUsuario($usuario);
    }

}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/mvp.css/1.6.3/mvp.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" integrity="sha512-5A8nwdMOWrSz20fDsjczgUidUBR8liPYU+WymTZP1lmY9G6Oc7HlZv156XqnsgNUzTyMefFTcsFH/tnJE/+xBg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Vista Usuarios</title>
    <style>
        button.registro{
            font-size: 70%;
            width: 20%;
            height: 20%;
        }
        #mensaje{
            background-color: red;
            position: relative;
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
    <div id="mensaje">
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo $resultado;
        header("Refresh:3");
    }
?>
    </div>
    <div id="formulario">
        <form method="POST" action="">
            <h3 id="titulo_formulario">Agregar Usuario</h3>
            <label for="username">Username:<input type="text" name="username"></label>
            <label for="username">Pasword:<input type="password" name="password"></label>
            <label for="username">Nombre:<input type="text" name="nombre"></label>
            <label for="username">Apellido:<input type="text" name="apellido"></label>
            <label for="username">Activo <input type="checkbox" name="activo" checked></label>
            <!-- Campos escondidos para manejar la acción del formulario y el identificador del elemento cuando vamos a modificar -->
            <input type="hidden" id="identificador" name="id" value="">
            <input type="hidden" id="accion" name="accion" value="insertar">
            <button id="boton_accion">Insertar</button>
        </form>
    </div>

    <div id="lista">
    <h1>Listado de Usuarios</h1>
    <table>
        <thead>
            <tr><th>id</th><th>username</th><th>nombre</th><th>apellido</th><th>activo</th><th>accion</th></tr>
        </thead>
        <tbody>
<?php
    foreach($ctrlUsuarios -> usuarios as $usuario){
        echo "<tr><td>{$usuario->id}</td><td>{$usuario->username}</td><td>{$usuario->nombre}</td><td>{$usuario->apellido}</td><td>".(($usuario -> activo) ? "✓" : "✗")."<span style='display:none;'>".(($usuario -> activo) ? "1" : "0")."</span></td><td><button class='registro' onclick='javascript:eliminarRegistro(this.parentElement.parentElement)'><i class='fa fa-trash-o' aria-hidden='true' title='Borrar'></i></button></form><button class='registro' onclick='javascript:llenarForm(this.parentElement.parentElement);'><i class='fa fa-pencil' aria-hidden='true' title='Editar'></i></i></button></td></tr>";
    }
    $ctrlUsuarios = null;
?>
        </tbody>
    </table>
    </div>
<script type="text/javascript">
    function llenarForm(row){
        var fila=row.cells;
        document.getElementById('identificador').value = fila[0].innerHTML;
        document.getElementsByName('username')[0].value = fila[1].innerHTML;
        document.getElementsByName('password')[0].disabled = true;
        document.getElementsByName('nombre')[0].value = fila[2].innerHTML;
        document.getElementsByName('apellido')[0].value = fila[3].innerHTML;
        // Tomamos el valor del span escondido que se encuentra en un segundo nivel de etiquetas html
        if(fila[4].childNodes[1].childNodes[0].data == '1') {
            document.getElementsByName("activo")[0].checked = true;
        }else{
            document.getElementsByName("activo")[0].checked = false;
        }
        document.getElementById('accion').value = "modificar";
        document.getElementById('boton_accion').innerHTML = "Modificar";
        document.getElementById('titulo_formulario').innerHTML = "Modificar Usuario Nº " + fila[0].innerHTML;
    }
</script>
<script type="text/javascript">
    function eliminarRegistro(row){
        var fila=row.cells;
        $.post(".", {identificador: fila[0].innerHTML, username: fila[1].innerHTML, nombre: fila[2].innerHTML, apellido: fila[3].innerHTML});
    }
</script>
</body>
</html>