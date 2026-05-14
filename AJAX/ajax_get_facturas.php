<?php
require_once("../PHP/conexion.php");
$conexion = dbConnect();

if(isset($_GET['matricula'])) {
    $matricula = $_GET['matricula'];
    $sql = "SELECT Numero_Factura, Fecha_Emision, Total FROM facturas WHERE Matricula = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0) {
        echo "<option value=''>-- Selecciona una Factura --</option>";
        while($fila = $resultado->fetch_assoc()) {
            echo "<option value='" . $fila['Numero_Factura'] . "'>" . $fila['Numero_Factura'] . " (" . $fila['Fecha_Emision'] . ") - " . $fila['Total'] . "€</option>";
        }
    } else {
        echo "<option value=''>Esta moto no tiene facturas</option>";
    }
}
?>