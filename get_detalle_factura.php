<?php
require_once 'conexion.php';
header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");

$id_factura = $_POST['id_factura'];
$pdo = dbConnect();

// Busca los detalles de la factura
$sql = "SELECT descripcion, precio FROM detalles_factura WHERE id_factura = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':id', $id_factura);
$stmt->execute();
$detalles = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo '<xml>';
foreach ($detalles as $item) {
    echo '<linea>';
    echo '<descripcion>' . htmlspecialchars($item['descripcion']) . '</descripcion>';
    echo '<precio>' . $item['precio'] . '</precio>';
    echo '</linea>';
}
echo '</xml>';
?>