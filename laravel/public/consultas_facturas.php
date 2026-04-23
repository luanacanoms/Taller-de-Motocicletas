<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

// 1. Obtener la lista de clientes para rellenar el menú (Sintaxis MYSQLI)
$sql_clientes = "SELECT id_cliente, DNI, Nombre, Apellido1 FROM clientes ORDER BY Nombre";
$stmt_clientes = $conexion->prepare($sql_clientes);
$stmt_clientes->execute();
$resultado_clientes = $stmt_clientes->get_result();
$lista_clientes = $resultado_clientes->fetch_all(MYSQLI_ASSOC);

// 2. Variables para almacenar los resultados
$facturas = [];
$mensaje_busqueda = "Utiliza uno de los filtros arriba para generar el reporte.";

// 3. Lógica para procesar los filtros
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // FILTRO A: Facturas Pagadas entre dos fechas
    if (isset($_POST['btn_fechas'])) {
        $fecha_inicio = $_POST['fecha_inicio'];
        $fecha_fin = $_POST['fecha_fin'];
        
        $sql = "SELECT f.*, m.Marca, m.Modelo, c.Nombre, c.Apellido1 
                FROM facturas f 
                INNER JOIN motocicletas m ON f.Matricula = m.Matricula 
                INNER JOIN clientes c ON m.Id_Cliente = c.id_cliente 
                WHERE f.Fecha_Pago IS NOT NULL 
                AND f.Fecha_Pago != '' 
                AND f.Fecha_Pago BETWEEN ? AND ?
                ORDER BY f.Fecha_Pago DESC";
                
        $stmt = $conexion->prepare($sql);
        // En mysqli se usa bind_param ("ss" significa dos Strings)
        $stmt->bind_param("ss", $fecha_inicio, $fecha_fin);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $facturas = $resultado->fetch_all(MYSQLI_ASSOC);
        
        $mensaje_busqueda = "Mostrando facturas pagadas entre <b>$fecha_inicio</b> y <b>$fecha_fin</b>.";
    }
    
    // FILTRO B: Facturas por Cliente
    elseif (isset($_POST['btn_cliente'])) {
        $id_cliente_buscado = $_POST['id_cliente'];
        
        $sql = "SELECT f.*, m.Marca, m.Modelo, c.Nombre, c.Apellido1 
                FROM facturas f 
                INNER JOIN motocicletas m ON f.Matricula = m.Matricula 
                INNER JOIN clientes c ON m.Id_Cliente = c.id_cliente 
                WHERE c.id_cliente = ?
                ORDER BY f.Fecha_Emision DESC";
                
        $stmt = $conexion->prepare($sql);
        // "i" significa Integer (número entero)
        $stmt->bind_param("i", $id_cliente_buscado);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $facturas = $resultado->fetch_all(MYSQLI_ASSOC);
        
        $mensaje_busqueda = "Mostrando todas las facturas del cliente seleccionado.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes de Facturas - MotoTaller</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <style>
        body { 
            margin: 0; 
            font-family: 'Poppins', sans-serif; 
            background-color: #F3F4F6; 
            display: flex !important; 
            height: 100vh; 
            overflow: hidden; 
        }

        .sidebar, .sidebar ul, .sidebar li { 
            list-style: none !important; 
            text-decoration: none !important;
            padding: 0 !important; 
            margin: 0 !important; 
        }

        .sidebar { width: 250px; min-width: 250px; background-color: #ffffff; box-shadow: 2px 0 15px rgba(0,0,0,0.05); display: flex; flex-direction: column; height: 100vh; z-index: 100; }
        .sidebar-header { padding: 1.5rem; font-size: 1.4rem; font-weight: 700; color: #2596be; display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #F3F4F6; margin-bottom: 1.5rem; }
        .nav-item { padding: 0.9rem 1.5rem; display: flex; align-items: center; gap: 15px; color: #6B7280; text-decoration: none; font-weight: 500; transition: all 0.2s; margin: 0 0.8rem 0.3rem 0.8rem; border-radius: 8px; }
        .nav-item:hover { background-color: #F9FAFB; color: #2596be; }
        .nav-item.active { background-color: #E0F2FE; color: #0284C7; font-weight: 600; }

        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; padding: 2rem 3rem; }
        
        .filters-container { display: flex; gap: 2rem; margin-bottom: 2rem; }
        .filter-card { flex: 1; background: #fff; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .filter-card h3 { margin-top: 0; color: #111827; font-size: 1.1rem; border-bottom: 1px solid #F3F4F6; padding-bottom: 0.5rem; }
        
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; font-size: 0.85rem; color: #666; margin-bottom: 0.4rem; font-weight: 500; }
        .form-group input, .form-group select { width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins'; }
        
        .btn-primary { background: #2596be; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; display: flex; justify-content: center; align-items: center; gap: 8px; }
        
        .table-container { background: #fff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 1.5rem 2rem; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 1.2rem 1rem; border-bottom: 2px solid #F3F4F6; color: #6B7280; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 1.2rem 1rem; border-bottom: 1px solid #F3F4F6; color: #374151; font-weight: 500; }
        
        .status-badge { padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 0.8rem; }
        .status-paid { background: #DCFCE7; color: #166534; }
    </style>
</head>
<body>

    <?php include("sidebar.php"); ?>

    <div class="main-content">
        <header style="margin-bottom: 20px;">
            <h1 style="margin: 0;">Reportes y Consultas de Facturas</h1>
            <p style="color: #6B7280; margin-top: 5px;">Genera listados específicos aplicando los filtros requeridos.</p>
        </header>

        <div class="filters-container">
            
            <div class="filter-card">
                <h3><i class='bx bx-calendar-check'></i> Facturas Pagadas por Fecha</h3>
                <form action="consultas_facturas.php" method="POST">
                    <div style="display: flex; gap: 1rem;">
                        <div class="form-group" style="flex: 1;">
                            <label>Fecha Inicio</label>
                            <input type="date" name="fecha_inicio" required>
                        </div>
                        <div class="form-group" style="flex: 1;">
                            <label>Fecha Fin</label>
                            <input type="date" name="fecha_fin" required>
                        </div>
                    </div>
                    <button type="submit" name="btn_fechas" class="btn-primary">
                        <i class='bx bx-search'></i> Generar Reporte
                    </button>
                </form>
            </div>

            <div class="filter-card">
                <h3><i class='bx bx-user-pin'></i> Facturas por Cliente</h3>
                <form action="consultas_facturas.php" method="POST">
                    <div class="form-group">
                        <label>Seleccione un Cliente de la base de datos</label>
                        <select name="id_cliente" required>
                            <option value="">-- Seleccionar Cliente --</option>
                            <?php foreach($lista_clientes as $cliente): ?>
                                <option value="<?= $cliente['id_cliente'] ?>">
                                    <?= htmlspecialchars($cliente['DNI'] . " - " . $cliente['Nombre'] . " " . $cliente['Apellido1']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" name="btn_cliente" class="btn-primary" style="background-color: #4F46E5;">
                        <i class='bx bx-search'></i> Buscar Facturas
                    </button>
                </form>
            </div>
            
        </div>

        <div class="table-container">
            <div style="margin-bottom: 1rem; padding: 1rem; background: #F9FAFB; border-left: 4px solid #2596be; border-radius: 4px;">
                <span style="color: #4B5563; font-size: 0.95rem;"><?= $mensaje_busqueda ?></span>
            </div>

            <table>
                <thead>
                    <tr>
                        <th>Nº Factura</th>
                        <th>Cliente</th>
                        <th>Vehículo</th>
                        <th>Fechas</th>
                        <th>Total</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($_SERVER["REQUEST_METHOD"] == "POST" && count($facturas) > 0): ?>
                        <?php foreach ($facturas as $fac): ?>
                        <tr>
                            <td><b><?= htmlspecialchars($fac['Numero_Factura']) ?></b></td>
                            <td>
                                <?= htmlspecialchars($fac['Nombre'] . " " . $fac['Apellido1']) ?>
                            </td>
                            <td>
                                <b><?= htmlspecialchars($fac['Matricula']) ?></b><br>
                                <small style="color: #6B7280;"><?= htmlspecialchars($fac['Marca'] . " " . $fac['Modelo']) ?></small>
                            </td>
                            <td style="font-size: 0.9rem;">
                                Emisión: <?= htmlspecialchars($fac['Fecha_Emision']) ?><br>
                                <?php if(!empty($fac['Fecha_Pago'])): ?>
                                    <span class="status-badge status-paid">Pagada: <?= htmlspecialchars($fac['Fecha_Pago']) ?></span>
                                <?php else: ?>
                                    <span style="color: #F59E0B; font-weight: bold;">Pendiente</span>
                                <?php endif; ?>
                            </td>
                            <td style="color: #0284C7; font-weight: 700;"><?= number_format($fac['Total'], 2) ?> €</td>
                            <td>
                                <a href="editar_factura_vista.php?id=<?= urlencode($fac['Numero_Factura']) ?>">
                                    <button style="background: #E0F2FE; color: #0284C7; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-weight: 600;">
                                        <i class='bx bx-show'></i> Ver Ficha
                                    </button>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php elseif ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #EF4444; padding: 2rem;">No se encontraron facturas que coincidan con los criterios de búsqueda.</td>
                        </tr>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: #6B7280; padding: 2rem;">Los resultados aparecerán aquí.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>