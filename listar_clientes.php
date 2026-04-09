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

    <section id="sidebar">
        <a href="menu.php" class="brand" style="text-decoration: none;">
            <h2 style="margin-left: 20px; color: var(--blue);">
                <i class='bx bxs-wrench'></i> MotoTaller
            </h2>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="menu.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="listar_clientes.php">
                    <i class='bx bxs-group'></i>
                    <span class="text">Clientes</span>
                </a>
            </li>
            <li>
                <a href="listar_motos.php" class="motos-link">
                    <i class="material-symbols-outlined">two_wheeler</i>
                    <span class="text">Motos</span>
                </a>
            </li>
        </ul>
        <ul class="side-menu bottom-menu">
            <li>
                <a href="logout.php" class="logout">
                    <i class="material-symbols-outlined">logout</i>
                    <span class="text">Salir</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="content">
        <nav>
            <div class="nav-actions">
                </div>
            
            <form action="#" class="search-form-centered">
                <div class="form-input">
                    <input type="search" placeholder="Buscar cliente...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>

            <div class="nav-spacer"></div>
        </nav>

        <main>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Directorio de Clientes</h3>
                        <i class='bx bx-filter'></i>
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
                                    <p><?= htmlspecialchars(($fila['Nombre'] ?? $fila['nombre']) . ' ' . ($fila['Apellido1'] ?? '') . ' ' . ($fila['Apellido2'] ?? '')) ?></p>
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

</body>
</html>