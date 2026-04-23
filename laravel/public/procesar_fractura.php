<?php
session_start();
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num_factura = $_POST['num_factura'];
    $matricula = $_POST['matricula'];
    $horas = $_POST['horas'];
    $precio_hora = $_POST['precio_hora'];
    $fecha_actual = date('Y-m-d'); // Fecha de hoy

    // Cálculos matemáticos de la factura
    $base_imponible = $horas * $precio_hora;
    $iva = $base_imponible * 0.21; // 21% de impuestos
    $total = $base_imponible + $iva;

    // Insertar en la base de datos
    $sql = "INSERT INTO facturas (Numero_Factura, Matricula, Mano_Obra, Precio_Hora, Fecha_Emision, Fecha_Pago, Base_Imponible, IVA, Total) 
            VALUES ('$num_factura', '$matricula', '$horas', '$precio_hora', '$fecha_actual', '0000-00-00', '$base_imponible', '$iva', '$total')";

    if (mysqli_query($conexion, $sql)) {
        // Redirige de vuelta al menú
        header("Location: menu.php?success=factura_creada");
    } else {
        echo "Error al generar la factura: " . mysqli_error($conexion);
    }
}
?>