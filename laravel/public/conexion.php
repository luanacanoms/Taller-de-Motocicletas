<?php
// conexion.php

function dbConnect(){
    // Usamos 'localhost' sin forzar puerto para que funcione en cualquier PC/Mac (XAMPP, MAMP, etc.)
    $host = 'localhost';
    $db   = 'taller_motocicletas';
    $user = 'root';
    $pwd  = ''; // Contraseña vacía obligatoria
    
    mysqli_report(MYSQLI_REPORT_OFF); 

    // Quitamos la variable del puerto de la función
    $conexion = mysqli_connect($host, $user, $pwd, $db);
    
    if (!$conexion) {
        die("Error de conexión (" . mysqli_connect_errno() . "): " . mysqli_connect_error());
    }

    mysqli_set_charset($conexion, "utf8");
    return $conexion; 
}

$conexion = dbConnect(); 
?>