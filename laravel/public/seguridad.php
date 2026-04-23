<?php
// Iniciamos sesión de forma segura
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Comprobamos la sesión. 
 * Si no existe o no es "SI", redirigimos a la raíz (el login de Laravel)
 */
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== "SI") {
    // Usamos "./" para que busque el index de la carpeta public de Laravel
    header("Location: ./"); 
    exit();
}
?>