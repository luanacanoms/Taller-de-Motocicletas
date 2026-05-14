<?php
include("conexion.php");
include("seguridad.php");
$conexion = dbConnect();

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

    header("Location: listar_clientes.php"); 
    exit();

} catch (PDOException $e) {
    echo "<br>Error al introducir el Cliente: " . $e->getMessage();
}
?>