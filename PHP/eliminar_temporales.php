<?php
include("conexion.php");
$conexion = dbConnect();

$idCliente = $_POST['idCliente']; 

$error = 0;
try {
    $sentencia = $conexion->prepare("DELETE FROM clientes WHERE id_cliente = :id");
    $sentencia->execute([':id' => $idCliente]);
    
} catch(PDOException $e) {
    $error = 1;
}

if ($error == 0) {
    echo "<br><br> El (Los) Cliente(s) se ha(n) eliminado correctamente.";
} else {
    echo "<br><br> Hubo un error al eliminar el cliente.";
}
?>