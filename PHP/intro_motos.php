<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $anyo = $_POST['anyo'] ?? 0;
    $color = $_POST['color'] ?? '';
    $id_cliente = $_POST['id_cliente'] ?? 0;
    $sql = "INSERT INTO motocicletas (Matricula, Marca, Modelo, Anyo, Color, Id_Cliente) 
            VALUES (?, ?, ?, ?, ?, ?)";
    
    $stmt = $conexion->prepare($sql);
    
    if ($stmt) {
        $stmt->bind_param("ssissi", $matricula, $marca, $modelo, $anyo, $color, $id_cliente);
        $stmt->execute();
    }
    
    header("Location: listar_motos.php");
    exit();
}
?>