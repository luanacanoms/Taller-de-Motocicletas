<?php
header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");
include("conexion.php");
$conexion = dbConnect();

$numero_factura = $_POST['factura'] ?? '';

echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<XML>';

if (!empty($numero_factura)) {
    // Unimos el detalle con los repuestos para sacar la descripción y el precio
    $sql = "SELECT d.Referencia, r.Descripcion, d.Unidades, r.Importe 
            FROM Detalle_Factura d 
            INNER JOIN Repuestos r ON d.Referencia = r.Referencia 
            WHERE d.Numero_Factura = :num";
    $stmt = $conexion->prepare($sql);
    $stmt->execute([':num' => $numero_factura]);
    $detalles = $stmt->fetchAll();

    foreach ($detalles as $d) {
        echo "<detalle>";
        echo "<referencia>" . htmlspecialchars($d['Referencia']) . "</referencia>";
        echo "<descripcion>" . htmlspecialchars($d['Descripcion']) . "</descripcion>";
        echo "<unidades>" . htmlspecialchars($d['Unidades']) . "</unidades>";
        echo "<importe>" . htmlspecialchars($d['Importe']) . "</importe>";
        echo "</detalle>";
    }
}
echo '</XML>';
?>