<?php
session_start();

// Comprobamos la variable que definimos en control.php
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== "SI") {
    header("Location: index.php?error=no_auth");
    exit();
}
?>