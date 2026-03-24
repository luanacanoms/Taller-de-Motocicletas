<?php
include("seguridad.php"); // Protegemos el menú
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Menú Taller</title>
</head>
<body>
    <h1>Panel de Gestión - Taller de Motocicletas</h1>
    <ul>
        <li><a href="listar_clientes.php">Listar Clientes</a></li>
        <li><a href="intro_clientes.php">Añadir Cliente</a></li>
        <li><a href="eliminar_temporales.php">Limpiar Temporales</a></li>
    </ul>

    <form action="logout.php" method="POST">
        <button type="submit">Cerrar Sesión</button>
    </form>
</body>
</html>