<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("seguridad.php");
include_once("conexion.php");
$conexion = dbConnect();

$sql = "SELECT f.*, m.Marca, m.Modelo 
        FROM facturas f
        INNER JOIN motocicletas m ON f.Matricula = m.Matricula
        ORDER BY f.Fecha_Emision DESC";
$consulta = $conexion->prepare($sql);
$consulta->execute();

$resultado = $consulta->get_result();
$facturas = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Facturas - MotoTaller</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php include_once("sidebar.php"); ?>

    <section id="content">
        <nav style="position: sticky; top: 0; z-index: 1000; display: flex; align-items: center; justify-content: space-between; background: #ffffff; padding: 15px 24px; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);">
            <div class="nav-actions" style="display: flex; align-items: center; gap: 1rem; margin-left: 10px;"></div>
            <form action="#" style="position: absolute; left: 50%; transform: translateX(-50%); width: 100%; max-width: 500px;">
                <div class="saas-search-container">
                    <i class='bx bx-search'></i>
                    <input type="search" placeholder="Buscar en facturas...">
                </div>
            </form>
        </nav>

        <main>
            <div class="table-data">
                <div class="order">
                    <div class="head" style="display: flex; justify-content: space-between; align-items: center; width: 100%; margin-bottom: 20px;">
                        <h3 style="margin: 0;">Gestión General de Facturas</h3>
                        <button onclick="abrirModal('modalFactura')" style="background: var(--blue); color: white; padding: 9px 16px; border-radius: 8px; display: flex; align-items: center; gap: 5px; font-size: 0.9rem; border: none; cursor: pointer; font-family: inherit; font-weight: 500; transition: background 0.3s;">
                            <i class='bx bx-plus'></i> Crear Factura
                        </button>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Nº Factura</th>
                                <th>Matrícula</th>
                                <th>Fecha Emisión</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Opciones</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($facturas as $fac): ?>
                            <tr>
                                <td><b><?= htmlspecialchars($fac['Numero_Factura'] ?? '') ?></b></td>
                                <td>
                                    <p style="font-weight: 600;"><?= htmlspecialchars($fac['Matricula'] ?? '') ?></p>
                                    <span style="font-size: 0.8rem; color: var(--dark-grey);"><?= htmlspecialchars(($fac['Marca'] ?? '') . ' ' . ($fac['Modelo'] ?? '')) ?></span>
                                </td>
                                <td><?= htmlspecialchars($fac['Fecha_Emision'] ?? '') ?></td>
                                <td><b style="color: var(--blue); font-size: 1.1rem;"><?= htmlspecialchars($fac['Total'] ?? '0.00') ?> €</b></td>
                                
                                <td>
                                    <?php if(!empty($fac['Fecha_Pago']) && $fac['Fecha_Pago'] != '0000-00-00'): ?>
                                        <div style="color: #10b981; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 5px;">
                                            <i class='bx bx-check-circle' style="font-size: 1.1rem;"></i> Pagada
                                        </div>
                                    <?php else: ?>
                                        <div style="color: #f59e0b; font-weight: 600; font-size: 0.9rem; display: flex; align-items: center; gap: 5px;">
                                            <i class='bx bx-time-five' style="font-size: 1.1rem;"></i> Pendiente
                                        </div>
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <button onclick="editarFactura('<?= $fac['Numero_Factura'] ?>', '<?= $fac['Matricula'] ?>', '<?= $fac['Mano_Obra'] ?>', '<?= $fac['Precio_Hora'] ?>', '<?= (!empty($fac['Fecha_Pago']) && $fac['Fecha_Pago'] != '0000-00-00') ? 'pagada' : 'pendiente' ?>')" style="background: none; border: none; color: var(--blue); font-size: 1.2rem; margin-right: 10px; cursor: pointer;">
                                        <i class='bx bxs-edit'></i>
                                    </button>
                                    <a href="borrar_factura.php?id=<?= urlencode($fac['Numero_Factura']) ?>" onclick="return confirm('¿Estás seguro de que deseas eliminar esta factura?');" style="color: var(--red); font-size: 1.2rem;">
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

    <div class="modal-overlay" id="modalFactura">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Generar Nueva Factura</h3>
                <button class="modal-close" onclick="cerrarModal('modalFactura')">&times;</button>
            </div>
            <form action="procesar_factura.php" method="POST">
                <div class="form-group">
                    <label>Número