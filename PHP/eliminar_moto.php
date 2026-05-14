<?php
include("seguridad.php");
require_once("conexion.php");
$conexion = dbConnect();

if (isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];

    $sql = "DELETE FROM motocicletas WHERE Matricula = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $matricula);
    
    if ($stmt->execute()) {
        header("Location: listar_motos.php");
        exit();
    } else {
        header("Location: listar_motos.php?error=1");
        exit();
    }
} else {
    header("Location: listar_motos.php");
    exit();
}
?>