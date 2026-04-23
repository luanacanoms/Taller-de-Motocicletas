<?php
// 1. Seguridad y conexión
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

// 2. Consulta de clientes
$sql = "SELECT * FROM Clientes ORDER BY id_cliente";
$consulta = $conexion->prepare($sql);
$consulta->execute();
$resultado = $consulta->get_result();
$clientes = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes - MotoTaller</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include_once("sidebar.php"); ?>

    <section id="content">
         
         <nav style="position: sticky; top: 0; z-index: 1000; background: #ffffff; display: flex; align-items: center; justify-content: center; padding: 15px 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); width: 100%;">
            <form action="#" style="width: 100%; max-width: 500px;">
                <div class="saas-search-container" style="display: flex; width: 100%; align-items: center;">
                    <i class='bx bx-search'></i>
                    <input type="search" placeholder="Buscar cliente..." style="width: 100%; border: none; outline: none; background: transparent; padding-left: 10px; font-family: inherit;">
                </div>
            </form>
        </nav>

        <main>
            <div class="table-data">
                <div class="order">
                    <div class="head" style="display: flex; align-items: center; width: 100%; margin-bottom: 20px;">
                        <h3 style="margin: 0;">Directorio de Clientes</h3>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>DNI</th>
                                <th>Cliente</th>
                                <th>Población</th>
                                <th>Contacto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($clientes as $fila): ?>
                            <tr>
                                <td>
                                    <p style="font-weight: bold;"><?= htmlspecialchars($fila['id_cliente'] ?? $fila['Id_Cliente']) ?></p>
                                </td>
                                <td><?= htmlspecialchars($fila['DNI'] ?? $fila['dni']) ?></td>
                                <td>
                                    <p style="font-weight: 600;"><?= htmlspecialchars(($fila['Nombre'] ?? $fila['nombre']) . ' ' . ($fila['Apellido1'] ?? '') . ' ' . ($fila['Apellido2'] ?? '')) ?></p>
                                </td>
                                <td><?= htmlspecialchars($fila['Poblacion'] ?? '') ?></td>
                                <td>
                                    <p><?= htmlspecialchars($fila['Telefono'] ?? '') ?></p>
                                    <span style="font-size: 0.8rem; color: var(--dark-grey);"><?= htmlspecialchars($fila['Email'] ?? '') ?></span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </section>

    <script src="script.js"></script>

</body>
</html>