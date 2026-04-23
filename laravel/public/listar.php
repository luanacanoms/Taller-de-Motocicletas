<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$sql = "SELECT * FROM Clientes ORDER BY id_cliente";
$consulta = $conexion->prepare($sql);
$consulta->execute();
$resultado = $consulta->fetchAll();
?>

<form method="POST" action="eliminarficherocliente.php">
    <table border="1">
        <tr>
            <th>Seleccionar</th><th>ID</th><th>DNI</th><th>Nombre</th><th>Email</th>
        </tr>

        <?php foreach ($resultado as $fila): ?>
        <tr>
            <td><center><input type="checkbox" name="borrar[]" value="<?= htmlspecialchars($fila['id_cliente']) ?>"></center></td>
            <td><?= htmlspecialchars($fila['id_cliente']) ?></td>
            <td><?= htmlspecialchars($fila['dni']) ?></td>
            <td><?= htmlspecialchars($fila['nombre']) ?></td>
            <td><?= htmlspecialchars($fila['email']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <input type="submit" value="Eliminar Clientes Seleccionados">
    <input type="reset" value="Deseleccionar Todos">
</form>