<?php
// Siempre iniciamos la sesión primero
session_start();

// 1. Lógica de Cierre de Sesión (Prioridad alta)
if(isset($_POST['reset'])){
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit();
}

// 2. Lógica de Login
$usuario = $_POST["usuario"] ?? ''; // Usamos ?? para evitar errores si no existe
$contrasena = $_POST["senha"] ?? '';

if($usuario == 'admin' && $contrasena == '123'){
    $_SESSION['username'] = $usuario;
    $_SESSION['autenticado'] = "SI"; // Esto es lo que verifica tu seguridad.php
    header("Location: menu.php");
    exit();
} else {
    // Si falla el login, volvemos al inicio
    echo '<script>alert("Usuario o contraseña incorrectos");</script>';
    echo '<meta http-equiv="refresh" content="0;url=index.php">';
    exit();
}
?>