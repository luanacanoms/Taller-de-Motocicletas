<?php
include("conexion.php");
$conexion = dbConnect();

// 1. Recogemos los datos con seguridad
$idCliente = $_POST['idCliente'];
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
// ... resto de variables ...

// 2. Usamos Prepared Statements para evitar ataques SQL Injection
$sql = "UPDATE clientes SET DNI=:dni, Nombre=:nombre, Apellido1=:apellido1, 
        Apellido2=:apellido2, Direccion=:direccion, CP=:cp, Poblacion=:poblacion, 
        Provincia=:provincia, Telefono=:telefono, Email=:email 
        WHERE id_cliente=:id";

try {
    $update = $conexion->prepare($sql);
    $update->execute([
        ':dni' => $dni,
        ':nombre' => $nombre,
        ':apellido1' => $apellido1,
        ':apellido2' => $apellido2,
        ':direccion' => $direccion,
        ':cp' => $cp,
        ':poblacion' => $poblacion,
        ':provincia' => $provincia,
        ':telefono' => $telefono,
        ':email' => $_POST['email'],
        ':id' => $idCliente
    ]);

    echo "<br><br>El cliente se ha actualizado correctamente.";
} catch (PDOException $e) {
    echo "Error al actualizar: " . $e->getMessage();
}
?>