<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = $_POST['descripcion'] ?? '';
    $importe = $_POST['importe'] ?? 0;
    $ganancia = $_POST['ganancia'] ?? 0;

    $foto = '';
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] == 0) {
        $foto = file_get_contents($_FILES['fotografia']['tmp_name']);
    }

    $sql = "INSERT INTO repuestos (Descripcion, Importe, Ganancia, Fotografia) VALUES (?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("sdds", $descripcion, $importe, $ganancia, $foto);
        $stmt->execute();
    }
    
    header("Location: listar_repuestos.php");
    exit();
}
?>