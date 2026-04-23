<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['idCliente'];
    $dni = $_POST['dni'];
    $nombre = $_POST['nombre'];
    $apellido1 = $_POST['apellido1'];
    $apellido2 = $_POST['apellido2'];
    $email = $_POST['email'];

    // Usamos MySQLi con bind_param para mayor seguridad
    $sql = "UPDATE clientes SET DNI=?, Nombre=?, Apellido1=?, Apellido2=?, Email=? WHERE id_cliente=?";
    $stmt = $conexion->prepare($sql);
    
    // "sssssi" significa 5 strings y 1 integer
    $stmt->bind_param("sssssi", $dni, $nombre, $apellido1, $apellido2, $email, $id);
    
    if($stmt->execute()) {
        header("Location: listar_clientes.php");
        exit();
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
}
?>