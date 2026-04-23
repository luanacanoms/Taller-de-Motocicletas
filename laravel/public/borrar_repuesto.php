<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

// Verificamos que nos hayan pasado un ID por la URL
if (isset($_GET['id'])) {
    $referencia = $_GET['id'];
    
    try {
        $sql = "DELETE FROM Repuestos WHERE Referencia = :ref";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':ref' => $referencia]);
        
        // Redirigimos de vuelta a la tabla automáticamente
        header("Location: listar_repuestos.php");
        exit();
        
    } catch(PDOException $e) {
        echo "Error al borrar el repuesto: " . $e->getMessage();
        echo "<br><a href='listar_repuestos.php'>Volver</a>";
    }
} else {
    header("Location: listar_repuestos.php");
    exit();
}
?>