<?php
include("conexion.php");
$conexion = dbConnect();

// Recibimos el ID que viene del formulario o enlace
$idCliente = $_POST['idCliente']; 

$error = 0;
try {
    // Usamos tu estilo de consulta, pero con prepare para seguridad
    $sentencia = $conexion->prepare("DELETE FROM clientes WHERE id_cliente = :id");
    $sentencia->execute([':id' => $idCliente]);
    
} catch(PDOException $e) {
    $error = 1;
}

// Mantenemos tu lógica de validación de error
if ($error == 0) {
    echo "<br><br> El (Los) Cliente(s) se ha(n) eliminado correctamente.";
} else {
    echo "<br><br> Hubo un error al eliminar el cliente.";
}
?>