<?php
function dbConnect(){
    $host = 'localhost';
    $db = 'taller_motocicletas';
    $user = 'root';
    $pwd = '';
    
    $conexion = new PDO("mysql:host=$host;dbname=$db", $user, $pwd);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    echo "¡Conexión establecida correctamente!"; // Si ves esto, la conexión funciona
    return $conexion;
}
?>