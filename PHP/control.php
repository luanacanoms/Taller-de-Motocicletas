<?php
session_start();
if(isset($_POST['reset'])){
    session_unset(); session_destroy();
    header("Location: index.php"); exit();
}

$usuario = $_POST["usuario"] ?? ''; 
$contrasena = $_POST["password"] ?? ''; 

if($usuario == 'admin' && $contrasena == '1234'){
    $_SESSION['username'] = $usuario;
    $_SESSION['autenticado'] = "SI"; 
    header("Location: menu.php");
    exit();
} else {
    echo '<script>alert("Usuario o contraseña incorrectos");</script>';
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
?>