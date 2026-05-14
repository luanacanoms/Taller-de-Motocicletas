<?php
// 1. Usamos tu candado de seguridad estándar [cite: 72]
include("seguridad.php");
require_once("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'] ?? ''; 
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $anyo = $_POST['anyo'] ?? '';
    $color = $_POST['color'] ?? '';

    $sql = "UPDATE motocicletas SET Marca=?, Modelo=?, Anyo=?, Color=? WHERE Matricula=?";
    $stmt = $conexion->prepare($sql);
    
    $stmt->bind_param("ssiss", $marca, $modelo, $anyo, $color, $matricula);
    
    if($stmt->execute()){
        header("Location: listar_motos.php");
        exit();
    } else {
        echo "Error al actualizar la moto: " . $conexion->error;
    }
} else {
    header("Location: listar_motos.php");
    exit();
}
?>