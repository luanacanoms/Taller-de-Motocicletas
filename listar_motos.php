<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once("seguridad.php");
include_once("conexion.php");
$conexion = dbConnect();

$sql = "SELECT * FROM motocicletas ORDER BY Matricula ASC";
$consulta = $conexion->prepare($sql);
$consulta->execute();

$resultado = $consulta->get_result(); 
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

    <?php include_once("sidebar.php"); ?>

    <section id="content">
         
         <nav style="position: sticky; top: 0; z-index: 1000; background: #ffffff; display: flex; align-items: center; justify-content: center; padding: 15px 24px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); width: 100%;">
            <form action="#" style="width: 100%; max-width: 500px;">
                <div class="saas-search-container" style="display: flex; width: 100%; align-items: center;">
                    <i class='bx bx-search'></i>
                    <input type="search" placeholder="Buscar matrícula o modelo..." style="width: 100%; border: none; outline: none; background: transparent; padding-left: 10px; font-family: inherit;">
                </div>
            </form>
        </nav>

        <main>
            <div class="table-data">
                <div class="order">
                    <div class="head" style="display: flex; align-items: center; width: 100%; margin-bottom: 20px;">
                        <h3 style="margin: 0;">Directorio de Motocicletas</h3>
                        
                        <button onclick="abrirModal('modalMoto')" style="margin-left: auto; background: var(--blue); color: white; padding: 9px 16px; border-radius: 8px; display: flex; align-items: center; gap: 5px; font-size: 0.9rem; border: none; cursor: pointer; font-family: inherit; font-weight: 500; transition: background 0.3s;">
                            <i class='bx bx-plus'></i> Añadir Moto
                        </button>
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
                                    <p><?= htmlspecialchars($moto['Anio'] ?? $moto['Año'] ?? $moto['Anyo'] ?? 'N/A') ?></p>
                                    <span style="font-size: 0.8rem; color: var(--dark-grey);"><?= htmlspecialchars($moto['Color'] ?? 'N/A') ?></span>
                                </td>
                                <td>
                                    <button onclick="editarMoto('<?= $moto['Matricula'] ?>', '<?= addslashes($moto['Marca']) ?>', '<?= addslashes($moto['Modelo']) ?>', '<?= $moto['Anyo'] ?? $moto['Año'] ?? $moto['Anio'] ?? '' ?>', '<?= addslashes($moto['Color']) ?>')" style="background: none; border: none; color: var(--blue); font-size: 1.2rem; margin-right: 10px; cursor: pointer;">
                                        <i class='bx bxs-edit'></i>
                                    </button>

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

    <div class="modal-overlay" id="modalMoto">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Registrar Nueva Moto</h3>
                <button class="modal-close" onclick="cerrarModal('modalMoto')">&times;</button>
            </div>
            <form action="procesar_moto.php" method="POST">
                <div class="form-group">
                    <label>Matrícula</label>
                    <input type="text" name="matricula" placeholder="Ej: 1234-ABC" required>
                </div>
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Marca</label>
                        <input type="text" name="marca" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Modelo</label>
                        <input type="text" name="modelo" required>
                    </div>
                </div>
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Año</label>
                        <input type="number" name="anyo" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Color</label>
                        <input type="text" name="color" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>ID Cliente (Propietario)</label>
                    <input type="number" name="id_cliente" placeholder="ID del Cliente" required>
                </div>
                <button type="submit" class="btn-modal">Guardar Motocicleta</button>
            </form>
        </div>
    </div>

    <div class="modal-overlay" id="modalEditarMoto">
        <div class="modal-box">
            <div class="modal-header">
                <h3>Modificar Motocicleta</h3>
                <button class="modal-close" onclick="cerrarModal('modalEditarMoto')">&times;</button>
            </div>
            <form action="editar_moto.php" method="POST">
                <div class="form-group">
                    <label>Matrícula (No editable)</label>
                    <input type="text" id="edit_moto_matricula" name="matricula" readonly style="background: #e5e7eb; color: var(--dark-grey);">
                </div>
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Marca</label>
                        <input type="text" id="edit_marca" name="marca" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Modelo</label>
                        <input type="text" id="edit_modelo" name="modelo" required>
                    </div>
                </div>
                <div style="display: flex; gap: 10px;">
                    <div class="form-group" style="flex: 1;">
                        <label>Año</label>
                        <input type="number" id="edit_anyo" name="anyo" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Color</label>
                        <input type="text" id="edit_color" name="color" required>
                    </div>
                </div>
                <button type="submit" class="btn-modal">Guardar Cambios</button>
            </form>
        </div>
    </div>

    <script src="script.js"></script>

</body>
</html>