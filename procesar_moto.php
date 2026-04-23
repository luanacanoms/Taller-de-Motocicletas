<?php
session_start();
require_once("conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $anyo = $_POST['anyo'];
    $color = $_POST['color'];
    $id_cliente = $_POST['id_cliente'];

    // Insertar en la base de datos
    $sql = "INSERT INTO motocicletas (Matricula, Marca, Modelo, Anyo, Color, Id_Cliente) 
            VALUES ('$matricula', '$marca', '$modelo', '$anyo', '$color', '$id_cliente')";

    if (mysqli_query($conexion, $sql)) {
        // Redirige de vuelta al menú si fue exitoso
        header("Location: menu.php?success=moto_creada");
    } else {
        echo "Error al registrar la moto: " . mysqli_error($conexion);
    }
}
?>