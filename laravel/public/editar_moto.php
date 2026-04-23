<?php
session_start();
require_once("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recogemos los datos que envía el modal oculto
    $matricula = $_POST['matricula']; 
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anyo = $_POST['anyo'];
    $color = $_POST['color'];

    // Actualizamos la base de datos
    $sql_update = "UPDATE motocicletas SET Marca='$marca', Modelo='$modelo', Anyo='$anyo', Color='$color' WHERE Matricula='$matricula'";
    
    if(mysqli_query($conexion, $sql_update)){
        // Nos devuelve a la lista automáticamente y recarga los datos
        header("Location: listar_motos.php?success=actualizado");
        exit();
    } else {
        echo "Error al actualizar la moto: " . mysqli_error($conexion);
    }
} else {
    // Si alguien intenta entrar a la página directamente, lo expulsamos al listado
    header("Location: listar_motos.php");
    exit();
}
?>