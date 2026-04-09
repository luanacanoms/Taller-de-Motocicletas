<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$facturas = [];
$titulo_resultados = "Resultados de la Búsqueda";

// 1. Obtenemos los clientes para llenar el desplegable
$sqlClientes = "SELECT id_cliente, Nombre, Apellido1, DNI FROM clientes ORDER BY Nombre";
$stmtClientes = $conexion->prepare($sqlClientes);
$stmtClientes->execute();
$clientes = $stmtClientes->fetchAll();

// 2. Comprobamos qué botón se ha pulsado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // BÚSQUEDA A: POR FECHAS DE PAGO
    if (isset($_POST['buscar_fechas'])) {
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        $titulo_resultados = "Facturas pagadas entre $fecha_inicio y $fecha_fin";

        // Buscamos facturas pagadas en ese rango
        $sql = "SELECT f.*, m.Marca, m.Modelo 
                FROM Factura f
                INNER JOIN Motocicletas m ON f.Matricula = m.Matricula
                WHERE f.Fecha_Pago IS NOT NULL 
                AND f.Fecha_Pago BETWEEN :inicio AND :fin
                ORDER BY f.Fecha_Pago DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':inicio' => $fecha_inicio, ':fin' => $fecha_fin]);
        $facturas = $stmt->fetchAll();
    }
    
    // BÚSQUEDA B: POR CLIENTE
    elseif (isset($_POST['buscar_cliente'])) {
        $id_cliente = $_POST['id_cliente'];
        $titulo_resultados = "Facturas del Cliente Seleccionado";

        // Unimos Factura -> Moto -> Cliente para sacar solo las de este cliente
        $sql = "SELECT f.*, m.Marca, m.Modelo, c.Nombre, c.Apellido1
                FROM Factura f
                INNER JOIN Motocicletas m ON f.Matricula = m.Matricula
                INNER JOIN clientes c ON m.Id_Cliente = c.id_cliente
                WHERE c.id_cliente = :cliente
                ORDER BY f.Fecha_Emision DESC";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([':cliente' => $id_cliente]);
        $facturas = $stmt->fetchAll();
    }
}
?>

<div style="display: flex; gap: 2rem; margin-top: 2rem; flex-wrap: wrap;">
    
    <div class="table" style="flex: 1; background: var(--color-white); padding: var(--card-padding); border-radius: var(--card-border-radius); box-shadow: var(--box-shadow); min-width: 300px;">
        <div class="table_header" style="background: transparent; padding: 0 0 1rem 0;">
            <p style="font-size: 1.2rem; font-weight: bold; color: var(--color-primary);">Facturas Pagadas por Fechas</p>
        </div>
        <form action="consultas_facturas.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <label><b>Fecha Inicio:</b></label>
                <input type="date" name="fecha_inicio" required style="width: 100%; border: 1px solid var(--color-info-light);">
            </div>
            <div>
                <label><b>Fecha Fin:</b></label>
                <input type="date" name="fecha_fin" required style="width: 100%; border: 1px solid var(--color-info-light);">
            </div>
            <button type="submit" name="buscar_fechas" class="add_new" style="width: 100%;"><i class="fa-solid fa-calendar"></i> Buscar por Fechas</button>
        </form>
    </div>

    <div class="table" style="flex: 1; background: var(--color-white); padding: var(--card-padding); border-radius: var(--card-border-radius); box-shadow: var(--box-shadow); min-width: 300px;">
        <div class="table_header" style="background: transparent; padding: 0 0 1rem 0;">
            <p style="font-size: 1.2rem; font-weight: bold; color: var(--color-warning);">Facturas por Cliente</p>
        </div>
        <form action="consultas_facturas.php" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <label><b>Seleccionar Cliente:</b></label>
                <select name="id_cliente" required style="width: 100%; padding: 10px; border: 1px solid var(--color-info-light); border-radius: 6px; outline: none;">
                    <option value="">Elija un cliente...</option>
                    <?php foreach ($clientes as $cli): ?>
                        <option value="<?= htmlspecialchars($cli['id_cliente']) ?>">
                            <?= htmlspecialchars($cli['Nombre'] . ' ' . $cli['Apellido1'] . ' (' . $cli['DNI'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" name="buscar_cliente" class="add_new" style="width: 100%; background-color: var(--color-warning); margin-top: auto;"><i class="fa-solid fa-user"></i> Buscar por Cliente</button>
        </form>
    </div>
</div>

<?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
<div class="table" style="background: var(--color-white); padding: var(--card-padding); border-radius: var(--card-border-radius); box-shadow: var(--box-shadow); margin-top: 2rem;">
    <div class="table_header">
        <p style="font-size: 1.4rem; font-weight: bold;"><?= $titulo_resultados ?></p>
        <a href="consultas_facturas.php"><button style="background: var(--color-danger); color: white;">Limpiar Búsqueda</button></a>
    </div>
    
    <div class="table_section"> 
        <table>
            <thead>
                <tr>
                    <th>Nº Factura</th>
                    <th>Matrícula</th>
                    <th>Vehículo</th>
                    <th>Fecha Emisión</th>
                    <th>Fecha Pago</th>
                    <th>Total (€)</th>
                    <th>Detalles</th> 
                </tr>
            </thead>
            <tbody>
                <?php if(count($facturas) > 0): ?>
                    <?php foreach ($facturas as $fac): ?>
                    <tr>
                        <td><b><?= htmlspecialchars($fac['Numero_Factura'] ?? '') ?></b></td>
                        <td><span style="background: var(--color-light); padding: 5px; border-radius: 5px;"><?= htmlspecialchars($fac['Matricula'] ?? '') ?></span></td>
                        <td><?= htmlspecialchars(($fac['Marca'] ?? '') . ' ' . ($fac['Modelo'] ?? '')) ?></td>
                        <td><?= htmlspecialchars($fac['Fecha_Emision'] ?? '') ?></td>
                        <td>
                            <?php if(!empty($fac['Fecha_Pago'])): ?>
                                <span style="color: var(--color-success); font-weight: bold;"><?= htmlspecialchars($fac['Fecha_Pago']) ?></span>
                            <?php else: ?>
                                <span style="color: var(--color-danger);">Pendiente</span>
                            <?php endif; ?>
                        </td>
                        <td><b><?= htmlspecialchars($fac['Total'] ?? '0.00') ?> €</b></td>
                        <td>
                            <a href="editar_factura.php?id=<?= urlencode($fac['Numero_Factura'] ?? '') ?>">
                                <button style="background-color: var(--color-primary); color: white;"><i class="fa-solid fa-eye"></i> Ver Ficha</button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--color-danger); padding: 2rem;">No se encontraron facturas con esos criterios.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div> 
</div>
<?php endif; ?>