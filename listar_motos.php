<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("seguridad.php");
include_once("conexion.php");
$conexion = dbConnect();

// CORRECCIÓN: Usamos get_result() para MySQLi
// Nota: Verifica que tu tabla se llame "Motocicletas" (o cámbialo por "Motos" si aplica)
$sql = "SELECT * FROM Motocicletas ORDER BY Matricula ASC";
$consulta = $conexion->prepare($sql);
$consulta->execute();

$resultado = $consulta->get_result(); // <- AQUÍ ESTÁ LA MAGIA
$motos = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Motos - MotoTaller</title>
    
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
            <li>
                <a href="listar_clientes.php">
                    <i class='bx bxs-group'></i>
                    <span class="text">Clientes</span>
                </a>
            </li>
            <li class="active">
                <a href="listar_motos.php" class="motos-link">
                    <i class="material-symbols-outlined">two_wheeler</i>
                    <span class="text">Motos</span>
                </a>
            </li>
            <li>
                <a href="listar_facturas.php">
                    <i class='bx bxs-receipt'></i>
                    <span class="text">Facturas</span>
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
            <div class="nav-actions"></div>
            <form action="#" class="search-form-centered">
                <div class="form-input">
                    <input type="search" placeholder="Buscar matrícula...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <div class="nav-spacer"></div>
        </nav>

        <main>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Directorio de Motocicletas</h3>
                        <a href="intro_moto.php" style="background: var(--blue); color: white; padding: 8px 16px; border-radius: 20px; display: flex; align-items: center; gap: 5px; font-size: 0.9rem;">
                            <i class='bx bx-plus'></i> Añadir Moto
                        </a>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Matrícula</th>
                                <th>Vehículo</th>
                                <th>Año / Color</th>
                                <th>Opciones</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($motos as $moto): ?>
                            <tr>
                                <td>
                                    <p style="font-weight: bold; font-family: monospace; font-size: 1.1rem; background: var(--grey); padding: 4px 10px; border-radius: 6px; display: inline-block;">
                                        <?= htmlspecialchars($moto['Matricula'] ?? '') ?>
                                    </p>
                                </td>
                                <td>
                                    <p style="font-weight: 600;"><?= htmlspecialchars($moto['Marca'] ?? '') ?></p>
                                    <span style="font-size: 0.8rem; color: var(--dark-grey);"><?= htmlspecialchars($moto['Modelo'] ?? '') ?></span>
                                </td>
                                <td>
                                    <p><?= htmlspecialchars($moto['Anio'] ?? $moto['Año'] ?? 'N/A') ?></p>
                                    <span style="font-size: 0.8rem; color: var(--dark-grey);"><?= htmlspecialchars($moto['Color'] ?? 'N/A') ?></span>
                                </td>
                                <td>
                                    <a href="editar_moto.php?id=<?= urlencode($moto['Matricula'] ?? '') ?>" style="color: var(--blue); font-size: 1.2rem; margin-right: 10px;">
                                        <i class='bx bxs-edit'></i>
                                    </a>
                                    <a href="borrar_moto.php?id=<?= urlencode($moto['Matricula'] ?? '') ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta motocicleta del registro?');" style="color: var(--red); font-size: 1.2rem;">
                                        <i class='bx bxs-trash'></i>
                                    </a>
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