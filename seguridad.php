<?php
// Comprobamos si no hay una sesión activa antes de iniciarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Comprobamos la variable que definimos en control.php
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== "SI") {
    header("Location: index.php?error=no_auth");
    exit();
}
?>