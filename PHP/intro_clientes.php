<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dni = $_POST["dni"] ?? '';
    $nombre = $_POST["nombre"] ?? '';
    $apellido1 = $_POST["apellido1"] ?? '';
    $apellido2 = $_POST["apellido2"] ?? '';
    $email = $_POST["email"] ?? '';
    
    $direccion = $_POST["direccion"] ?? '';
    $cp = $_POST["cp"] ?? '';
    $poblacion = $_POST["poblacion"] ?? '';
    $provincia = $_POST["provincia"] ?? '';
    $telefono = $_POST["telefono"] ?? '';

    $foto = '';
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] == 0) {
        $foto = file_get_contents($_FILES['fotografia']['tmp_name']);
    }

    $sql = "INSERT INTO clientes (DNI, Nombre, Apellido1, Apellido2, Direccion, CP, Poblacion, Provincia, Telefono, Email, Fotografia) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sssssssssss", $dni, $nombre, $apellido1, $apellido2, $direccion, $cp, $poblacion, $provincia, $telefono, $email, $foto);
        $stmt->execute();
    }
    
    header("Location: listar_clientes.php");
    exit();
}
?>