<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== "SI") {
    // Usamos "./" para que busque el index de la carpeta public de Laravel
    header("Location: ./"); 
    exit();
}
?>