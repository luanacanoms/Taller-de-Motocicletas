<?php
require_once 'conexion.php';
header("Content-Type: text/xml");
header("Cache-Control: no-cache, must-revalidate");

$matricula = $_POST['matricula'];
$pdo = dbConnect();

// Busca las facturas de esa matrícula en la base de datos
$sql = "SELECT id_factura FROM facturas WHERE matricula = :matricula";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':matricula', $matricula);
$stmt->execute();
$resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
echo '<xml>';
foreach ($resultados as $row) {
    echo '<factura>';
    echo '<numero>' . $row['id_factura'] . '</numero>';
    echo '</factura>';
}
echo '</xml>';
?>