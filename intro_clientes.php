<?php
include("conexion.php");
include("seguridad.php");
$conexion = dbConnect();
$pdo = dbConnect();

// 1. Recogemos los datos del texto
$dni = $_POST['dni'];
$nombre = $_POST['nombre'];
$apellido1 = $_POST['apellido1'];
$apellido2 = $_POST['apellido2'];
$direccion = $_POST['direccion'];
$cp = $_POST['cp'];
$poblacion = $_POST['poblacion'];
$provincia = $_POST['provincia'];
$telefono = $_POST['telefono'];
$email = $_POST['e-mail'];

// 2. Procesamos la fotografía (binario)
$foto = null;
if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] == 0) {
    // Leemos el contenido del archivo subido en formato binario
    $foto = file_get_contents($_FILES['fotografia']['tmp_name']);
}

// 3. Insertamos en la base de datos usando parámetros preparados (Seguridad máxima)
$sql = "INSERT INTO clientes (DNI, Nombre, Apellido1, Apellido2, Direccion, CP, Poblacion, Provincia, Telefono, Email, fotografia) 
        VALUES (:dni, :nombre, :a1, :a2, :dir, :cp, :pob, :prov, :tel, :email, :foto)";

try {
    $stmt = $conexion->prepare($sql);
    $stmt->execute([
        ':dni'   => $dni,
        ':nombre'=> $nombre,
        ':a1'    => $apellido1,
        ':a2'    => $apellido2,
        ':dir'   => $direccion,
        ':cp'    => $cp,
        ':pob'   => $poblacion,
        ':prov'  => $provincia,
        ':tel'   => $telefono,
        ':email' => $email,
        ':foto'  => $foto // El binario de la foto se inserta aquí
    ]);
    echo "Cliente insertado correctamente.";
} catch(PDOException $e) {
    echo "Error al insertar: " . $e->getMessage();
}
?>