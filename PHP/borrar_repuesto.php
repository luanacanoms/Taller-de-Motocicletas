<?php
include("seguridad.php");
require_once("conexion.php");
$conexion = dbConnect();

if (isset($_GET['id'])) {
    $referencia = $_GET['id'];

    // Sentencia preparada para la tabla CORRECTA
    $sql = "DELETE FROM repuestos WHERE Referencia = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $referencia);
    
    if ($stmt->execute()) {
        header("Location: listar_repuestos.php");
        exit();
    } else {
        header("Location: listar_repuestos.php?error=1");
        exit();
    }
} else {
    header("Location: listar_repuestos.php");
    exit();
}
?>