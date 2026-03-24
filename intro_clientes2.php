<?php
include("conexion.php");
include("seguridad.php");
$conexion = dbConnect();

// 1. Recogida de datos (usando null coalescing para evitar errores)
$dni = $_POST["dni"] ?? '';
$nombre = $_POST["nombre"] ?? '';
$apellido1 = $_POST["apellido1"] ?? '';
$apellido2 = $_POST["apellido2"] ?? '';
$direccion = $_POST["direccion"] ?? '';
$cp = $_POST["cp"] ?? '';
$poblacion = $_POST["poblacion"] ?? '';
$provincia = $_POST["provincia"] ?? '';
$telefono = $_POST["telefono"] ?? '';
$email = $_POST["email"] ?? '';

// 2. Tratamiento de la imagen (manteniendo tu lógica de buffer)
$jpg = null;
if (isset($_FILES['foto']) && is_uploaded_file($_FILES['foto']['tmp_name'])) {
    $img_tmp = $_FILES['foto']['tmp_name'];
    $img_res = @imagecreatefromjpeg($img_tmp);
    
    if ($img_res) {
        ob_start();
        imagejpeg($img_res);
        $jpg = ob_get_contents();
        ob_end_clean();
    }
}

// 3. Inserción segura con parámetros preparados (evita Inyección SQL)
$sql = "INSERT INTO clientes (DNI, Nombre, Apellido1, Apellido2, Direccion, CP, Poblacion, Provincia, Telefono, Email, Fotografia) 
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
        ':foto'  => $jpg
    ]);
    echo "<br>El Cliente se ha introducido con éxito en la Base de Datos.";
} catch (PDOException $e) {
    echo "<br>Error al introducir el Cliente en la Base de Datos: " . $e->getMessage();
}
?>