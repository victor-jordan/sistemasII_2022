<?php
require_once(__DIR__.'\..\controladores\ctrl_usuario.php');
require(__DIR__.'\..\utiles\limpiar_datos.php');

$ctrlUsuarios = new ctrlUsuario();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = $_POST['user'];
    $pass = $_POST['pass'];
    $mensaje = $ctrlUsuarios->autenticarUsuario($user, $pass);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/mvp.css/1.6.3/mvp.min.css">
    <style>
        #mensaje{
            background-color: red;
            position: relative;
        }
    </style>
    <title>Acceso al sistema</title>
</head>
<body>
<div id="mensaje">
<?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        echo $mensaje;
        // header("Refresh:3");
    }
?>
</div>
<form action="" method="POST">
  <div class="imgcontainer">
    <img src="https://encrypted-tbn3.gstatic.com/images?q=tbn:ANd9GcS2LsyQzL4G5tyQEBNahy4cn9VdD-tqMyC-78yELWVRmY86sEuH" alt="Avatar" class="avatar">
  </div>

  <div>
    <label><b>Usuario</b></label>
    <input type="text" placeholder="El usuario" name="user" required>

    <label><b>Contraseña</b></label>
    <input type="password" placeholder="La contraseña" name="pass" required>
        
    <button type="submit">Login</button>
</form>
</body>
</html>