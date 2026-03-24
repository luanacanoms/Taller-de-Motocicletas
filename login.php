<?php
session_start();
include("conexion.php");

$pdo = dbConnect(); 
echo " - Variable \$pdo creada con éxito.";
exit(); // Detenemos aquí para no procesar nada más
?>