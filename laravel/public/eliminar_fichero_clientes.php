<?php
include("conexion.php");
$conexion = dbConnect();

// 1. Verificamos que se hayan enviado clientes para borrar
if (!empty($_POST['borrar'])) {
    $array_borrados = $_POST['borrar'];
    $error = 0;

    // 2. Usamos una sentencia preparada para evitar inyección SQL
    $sql = "DELETE FROM clientes WHERE id_cliente = :id";
    $stmt = $conexion->prepare($sql);

    // 3. Iteramos sobre los IDs seleccionados
    foreach ($array_borrados as $id) {
        try {
            $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            $error = 1;
            // Opcional: registrar el error en un log
        }
    }

    if ($error == 0) {
        echo "Los clientes seleccionados se han eliminado correctamente.";
    } else {
        echo "Hubo un error al eliminar algunos registros.";
    }
} else {
    echo "No has seleccionado ningún cliente para borrar.";
}
?>