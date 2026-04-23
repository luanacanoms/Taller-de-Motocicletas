<?php
include("seguridad.php");
include("conexion.php");
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
    <title>Facturas - MotoTaller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex; height: 100vh; overflow: hidden; }
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; padding: 2rem 3rem; }
        .table-container { background: #fff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 1.5rem 2rem; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 1.2rem 1rem; border-bottom: 2px solid #F3F4F6; color: #6B7280; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 1.2rem 1rem; border-bottom: 1px solid #F3F4F6; color: #374151; font-weight: 500; }
        .btn-action { font-size: 1.3rem; margin-right: 10px; text-decoration: none; cursor: pointer; border: none; background: none; }
        .btn-edit { color: #3B82F6; }
        .btn-delete { color: #EF4444; }
    </style>
</head>
<body>

    <?php include_once("sidebar.php"); ?>

    <div class="main-content">
        <h1>Gestión General de Facturas</h1>
        
        <div class="table-container">
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
                        <td><b><?= $fac['Numero_Factura'] ?></b></td>
                        <td>
                            <b><?= $fac['Matricula'] ?></b><br>
                            <small style="color: #6B7280;"><?= $fac['Marca']." ".$fac['Modelo'] ?></small>
                        </td>
                        <td><?= $fac['Fecha_Emision'] ?></td>
                        <td style="color: #0284C7; font-weight: 700;"><?= number_format($fac['Total'], 2) ?> €</td>
                        <td>
                            <?php if(!empty($fac['Fecha_Pago'])): ?>
                                <span style="color: #10B981; font-weight: bold;"><i class='bx bx-check-circle'></i> Pagada</span>
                            <?php else: ?>
                                <span style="color: #F59E0B; font-weight: bold;"><i class='bx bx-time'></i> Pendiente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button type="button" class="btn-action btn-edit" onclick="abrirModalEditarFactura('<?= $fac['Numero_Factura'] ?>')">
                                <i class='bx bxs-edit'></i>
                            </button>
                            <a href="borrar_factura.php?id=<?= $fac['Numero_Factura'] ?>" class="btn-action btn-delete" onclick="return confirm('¿Eliminar factura?');"><i class='bx bxs-trash'></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalEditarFactura" class="modal-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: none; justify-content: center; align-items: center; z-index: 1000;">
        <div class="modal-box" style="background: white; padding: 2rem; border-radius: 16px; width: 100%; max-width: 400px; box-shadow: 0 10px 25px rgba(0,0,0,0.1);">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                <h3 style="margin: 0; color: #111827;">Actualizar Factura</h3>
                <button type="button" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color: #6B7280;" onclick="cerrarModalEditarFactura()">&times;</button>
            </div>
            
            <form action="editar_factura.php" method="POST">
                <input type="hidden" id="edit_num_factura" name="numero_factura">

                <div style="margin-bottom: 1.5rem;">
                    <label style="display:block; font-size: 0.9rem; color:#666; margin-bottom: 0.5rem; font-weight: 500;">Fecha de Pago:</label>
                    <input type="date" name="fecha_pago" required style="width:100%; padding:0.8rem; border:1px solid #ddd; border-radius:8px; font-family: 'Poppins';">
                    <small style="color: #9CA3AF; margin-top: 5px; display: block;">Si la factura ya ha sido abonada, introduce la fecha.</small>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="button" onclick="cerrarModalEditarFactura()" style="background:#eee; color:#666; border:none; padding:0.7rem 1.5rem; border-radius:8px; cursor:pointer; font-weight: 500;">Cancelar</button>
                    <button type="submit" style="background:#3B82F6; color:white; border:none; padding:0.7rem 1.5rem; border-radius:8px; cursor:pointer; font-weight:bold;">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModalEditarFactura(numFactura) {
            document.getElementById('edit_num_factura').value = numFactura;
            document.getElementById('modalEditarFactura').style.display = 'flex';
        }
        function cerrarModalEditarFactura() {
            document.getElementById('modalEditarFactura').style.display = 'none';
        }
    </script>
</body>
</html>