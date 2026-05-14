<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ref_original = $_POST['referencia']; 
    $descripcion = $_POST['descripcion'];
    $importe = $_POST['importe'];
    $ganancia = $_POST['ganancia'];

    $sql = "UPDATE repuestos SET Descripcion=?, Importe=?, Ganancia=? WHERE Referencia=?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sdds", $descripcion, $importe, $ganancia, $ref_original);
    
    if($stmt->execute()) {
        header("Location: listar_repuestos.php");
        exit();
    } else {
        echo "Error al actualizar: " . $conexion->error;
    }
} else {
    header("Location: listar_repuestos.php");
    exit();
}
?>