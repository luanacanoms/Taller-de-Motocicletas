<?php
require_once("conexion.php");
$conexion = dbConnect();

if(isset($_GET['factura'])) {
    $factura = $_GET['factura'];

    $sql = "SELECT df.Unidades, r.Referencia, r.Descripcion, r.Importe 
            FROM detalle_factura df 
            JOIN repuestos r ON df.Referencia = r.Referencia 
            WHERE df.Numero_Factura = ?";
            
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("s", $factura);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if($resultado->num_rows > 0) {
        echo "<h3 style='color:#111827;'>Detalles de la Factura: $factura</h3>";
        echo "<table>";
        echo "<thead><tr><th>Ref.</th><th>Pieza/Repuesto</th><th>Precio Unitario</th><th>Unidades</th><th>Subtotal</th></tr></thead>";
        echo "<tbody>";
        
        $total_piezas = 0;
        
        while($fila = $resultado->fetch_assoc()) {
            $subtotal = $fila['Importe'] * $fila['Unidades'];
            $total_piezas += $subtotal;
            
            echo "<tr>";
            echo "<td><b>" . htmlspecialchars($fila['Referencia']) . "</b></td>";
            echo "<td>" . htmlspecialchars($fila['Descripcion']) . "</td>";
            echo "<td>" . number_format($fila['Importe'], 2) . " €</td>";
            echo "<td>" . $fila['Unidades'] . "</td>";
            echo "<td style='font-weight:bold; color:#2596be;'>" . number_format($subtotal, 2) . " €</td>";
            echo "</tr>";
        }
        
        echo "</tbody>";
        echo "</table>";
    } else {
        echo "<p style='color: #EF4444; font-weight: bold;'>No hay líneas de detalle para esta factura. (Solo se cobró mano de obra).</p>";
    }
}
?>