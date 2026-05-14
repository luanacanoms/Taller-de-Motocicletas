<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_factura = $_POST['numero_factura'];
    $matricula = $_POST['matricula'];
    $fecha_emision = $_POST['fecha_emision'];
    $fecha_pago = !empty($_POST['fecha_pago']) ? $_POST['fecha_pago'] : '0000-00-00';
    $mano_obra = $_POST['mano_obra'];
    $precio_hora = $_POST['precio_hora'];
    
    $referencias = $_POST['referencias'] ?? [];
    $unidades = $_POST['unidades'] ?? [];

    $base_imponible = $mano_obra * $precio_hora;

    for ($i = 0; $i < count($referencias); $i++) {
        $ref = $referencias[$i];
        $cant = $unidades[$i];

        $stmtRep = $conexion->prepare("SELECT Importe, Ganancia FROM Repuestos WHERE Referencia = ?");
        $stmtRep->bind_param("s", $ref);
        $stmtRep->execute();
        $resultado = $stmtRep->get_result()->fetch_assoc();
        
        if ($resultado) {
            $importe = $resultado['Importe'];
            $ganancia_porcentaje = $resultado['Ganancia'];

            $precio_con_beneficio = $importe + ($importe * ($ganancia_porcentaje / 100));
            
            $base_imponible += ($precio_con_beneficio * $cant);
        }
    }

    $iva = $base_imponible * 0.21;
    $total = $base_imponible + $iva;

    try {
        $sqlFactura = "INSERT INTO Facturas (Numero_Factura, Matricula, Mano_Obra, Precio_Hora, Fecha_Emision, Fecha_Pago, Base_Imponible, IVA, Total) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtFac = $conexion->prepare($sqlFactura);
        $stmtFac->bind_param("ssddssddd", $num_factura, $matricula, $mano_obra, $precio_hora, $fecha_emision, $fecha_pago, $base_imponible, $iva, $total);
        $stmtFac->execute();

        $sqlDetalle = "INSERT INTO Detalle_Factura (Numero_Factura, Referencia, Unidades) VALUES (?, ?, ?)";
        $stmtDet = $conexion->prepare($sqlDetalle);
        
        for ($i = 0; $i < count($referencias); $i++) {
            $ref = $referencias[$i];
            $cant = $unidades[$i];
            $stmtDet->bind_param("ssi", $num_factura, $ref, $cant);
            $stmtDet->execute();
        }

    } catch (Exception $e) {
    }

    header("Location: listar_facturas.php");
    exit();
}
?>