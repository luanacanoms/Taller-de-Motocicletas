<?php
// conexion.php

function dbConnect(){
    $host = '127.0.0.1';
    $port = '3307'; // Tu puerto de MariaDB/MySQL
    $db   = 'taller_motocicletas';
    $user = 'root';
    $pwd  = '';
    
    // Conexión usando MySQLi (compatible con tu dashboard)
    $conexion = mysqli_connect($host, $user, $pwd, $db, $port);
    
    if (!$conexion) {
        die("Error de conexión: " . mysqli_connect_error());
    }

    mysqli_set_charset($conexion, "utf8");
    return $conexion; 
}

// Creamos la conexión global
$conexion = dbConnect(); 
?>