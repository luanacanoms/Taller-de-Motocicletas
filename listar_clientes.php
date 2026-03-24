<?php
// 1. Incluimos seguridad y conexión
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();
$pdo = dbConnect();

// 2. Ejecutamos la consulta una sola vez
$sql = "SELECT * FROM Clientes ORDER BY id_cliente";
$consulta = $conexion->prepare($sql);
$consulta->execute();
$resultado = $consulta->fetchAll();
?>

<table border="1">
    <tr>
        <th>ID</th><th>DNI</th><th>Nombre</th><th>Apellido1</th><th>Apellido2</th>
        <th>Dirección</th><th>CP</th><th>Población</th><th>Provincia</th><th>Teléfono</th><th>Email</th>
    </tr>

    <?php foreach ($resultado as $fila): ?>
    <tr>
        <td><center><b><?= htmlspecialchars($fila['Id_Cliente']) ?></b></center></td>
        <td><?= htmlspecialchars($fila['DNI']) ?></td>
        <td><?= htmlspecialchars($fila['Nombre']) ?></td>
        <td><?= htmlspecialchars($fila['Apellido1']) ?></td>
        <td><?= htmlspecialchars($fila['Apellido2']) ?></td>
        <td><?= htmlspecialchars($fila['Direccion']) ?></td>
        <td><?= htmlspecialchars($fila['CP']) ?></td>
        <td><?= htmlspecialchars($fila['Poblacion']) ?></td>
        <td><?= htmlspecialchars($fila['Provincia']) ?></td>
        <td><?= htmlspecialchars($fila['Telefono']) ?></td>
        <td><?= htmlspecialchars($fila['Email']) ?></td>
    </tr>
    <?php endforeach; ?>
</table>