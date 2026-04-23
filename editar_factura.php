<?php
session_start();
require_once("conexion.php");
$conexion = dbConnect();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_factura = $_POST['num_factura'];
    $horas = $_POST['horas'];
    $precio_hora = $_POST['precio_hora'];
    $estado_pago = $_POST['estado_pago'];

    // Recalcular totales
    $base_imponible = $horas * $precio_hora;
    $iva = $base_imponible * 0.21;
    $total = $base_imponible + $iva;

    // Asignar fecha de pago si se marca como pagada
    $fecha_pago = ($estado_pago == 'pagada') ? date('Y-m-d') : '0000-00-00';

    $sql_update = "UPDATE facturas SET Mano_Obra='$horas', Precio_Hora='$precio_hora', Base_Imponible='$base_imponible', IVA='$iva', Total='$total', Fecha_Pago='$fecha_pago' WHERE Numero_Factura='$num_factura'";
    
    if(mysqli_query($conexion, $sql_update)){
        header("Location: listar_facturas.php?success=actualizado");
        exit();
    } else {
        echo "Error al actualizar: " . mysqli_error($conexion);
    }
} else {
    header("Location: listar_facturas.php");
    exit();
}
?>