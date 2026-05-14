<?php
include("seguridad.php"); // ¡Seguridad restaurada!
require_once("conexion.php");
$conexion = dbConnect();

if (isset($_GET['id'])) {
    $id_cliente = $_GET['id'];

    $sql = "DELETE FROM clientes WHERE id_cliente = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_cliente);
    
    if ($stmt->execute()) {
        // Redirección inmediata y silenciosa
        header("Location: listar_clientes.php");
        exit();
    } else {
        header("Location: listar_clientes.php?error=1");
        exit();
    }
} else {
    header("Location: listar_clientes.php");
    exit();
}
?>