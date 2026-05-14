<?php
session_start();
require_once("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_factura = $_POST['num_factura'];
    $horas = $_POST['horas'];
    $precio_hora = $_POST['precio_hora'];
    $estado_pago = $_POST['estado_pago'];

    // 1. Calculamos el nuevo coste de la mano de obra
    $coste_mano_obra = $horas * $precio_hora;

    // 2. Recuperamos los repuestos que YA tiene esta factura para sumarlos
    $sql_repuestos = "SELECT df.Unidades, r.Importe, r.Ganancia 
                      FROM detalle_factura df 
                      JOIN repuestos r ON df.Referencia = r.Referencia 
                      WHERE df.Numero_Factura = '$num_factura'";
    $resultado_rep = mysqli_query($conexion, $sql_repuestos);
    
    $total_repuestos = 0;
    while($row = mysqli_fetch_assoc($resultado_rep)) {
        $precio_con_beneficio = $row['Importe'] + ($row['Importe'] * ($row['Ganancia'] / 100));
        $total_repuestos += ($precio_con_beneficio * $row['Unidades']);
    }

    $base_imponible = $coste_mano_obra + $total_repuestos;
    $iva = $base_imponible * 0.21;
    $total = $base_imponible + $iva;

    $fecha_pago = ($estado_pago == 'pagada') ? date('Y-m-d') : '0000-00-00';

    $sql_update = "UPDATE facturas SET Mano_Obra='$horas', Precio_Hora='$precio_hora', Base_Imponible='$base_imponible', IVA='$iva', Total='$total', Fecha_Pago='$fecha_pago' WHERE Numero_Factura='$num_factura'";
    
    if(mysqli_query($conexion, $sql_update)){
        header("Location: listar_facturas.php");
        exit();
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
} else {
    header("Location: listar_facturas.php");
    exit();
}
?>