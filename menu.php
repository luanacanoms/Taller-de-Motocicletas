<?php
session_start();

// 1. SEGURIDAD: Solo entran los logueados
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== "SI") {
    header("Location: index.php");
    exit();
}

// 2. CONEXIÓN
require_once("conexion.php"); 

// 3. CONSULTAS DINÁMICAS
// Ventas Totales
$query_ventas = mysqli_query($conexion, "SELECT SUM(Total) as total_ventas FROM Facturas");
$dato_ventas = mysqli_fetch_assoc($query_ventas);
$total_ventas = $dato_ventas['total_ventas'] ?? 0;

// Clientes Totales
$query_clientes = mysqli_query($conexion, "SELECT COUNT(*) as total_clientes FROM Clientes");
$dato_clientes = mysqli_fetch_assoc($query_clientes);
$total_clientes = $dato_clientes['total_clientes'] ?? 0;

// Motos Totales
$query_motos = mysqli_query($conexion, "SELECT COUNT(*) as total_motos FROM Motocicletas");
$dato_motos = mysqli_fetch_assoc($query_motos);
$total_motos = $dato_motos['total_motos'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MotoTaller - AdminHub</title>
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
	<link rel="stylesheet" href="style.css?v=3">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>
<body>

<section id="sidebar">
		<a href="menu.php" class="brand">
			<i class='bx bxs-wrench'></i>
			<span class="text">MotoTaller</span>
		</a>
<ul class="side-menu top">
    <li class="<?php echo (basename($_SERVER['PHP_SELF']) == 'menu.php') ? 'active' : ''; ?>">
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
    <li>
        <a href="listar_facturas.php">
            <i class='bx bxs-receipt'></i>
            <span class="text">Facturas</span>
        </a>
    </li>
    <li>
    <a href="listar_motos.php" class="motos-link"> <i class="material-symbols-outlined">two_wheeler</i>
        <span class="text">Motos</span>
    </a>
</li>
<ul class="side-menu bottom-menu">
    <li>
        <a href="logout.php" class="logout" onclick="return confirm('¿Estás seguro de que deseas salir del sistema?');">
            <i class="material-symbols-outlined">logout</i>
            <span class="text">Salir</span>
        </a>
    </li>
</ul>
	</section>

	<section id="content">
<nav>
    <div class="nav-actions" style="display: flex; align-items: center; gap: 1rem; margin-left: 10px;">
        

    </div>

    <form action="#" style="margin-left: auto;">
        <div class="form-input">
            <input type="search" placeholder="Buscar matrícula...">
            <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
        </div>
    </form>
</nav>

<main>
    <div class="main-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <div class="date-filter" style="display: flex; align-items: center; background: var(--color-white); padding: 8px 15px; border-radius: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.03); gap: 10px;">
            <i class='bx bx-calendar' style="color: var(--blue); font-size: 1.2rem;"></i>
            <input type="date" value="<?php echo date('Y-m-d'); ?>" style="border: none; background: transparent; font-family: 'Poppins', sans-serif; font-weight: 600; color: var(--dark); outline: none; cursor: pointer;">
        </div>
        
        <a href="#" class="btn-download-nav" style="display: flex; align-items: center; gap: 8px; background: var(--blue); color: white !important; padding: 8px 18px; border-radius: 50px; font-weight: 500; font-size: 0.85rem; transition: all 0.3s ease; box-shadow: 0 4px 10px rgba(60, 145, 230, 0.2);">
            <i class='bx bxs-cloud-download'></i>
            <span class="text">Descargar Reporte</span>
        </a>
    </div>

    <ul class="box-info">
        <li>
            <i class='bx bxs-dollar-circle'></i>
            <span class="text">
                <h3>$<?php echo number_format($total_ventas, 2); ?></h3>
                <p>Ventas Totales</p>
            </span>
        </li>
        <li>
            <i class='bx bxs-group'></i>
            <span class="text">
                <h3><?php echo $total_clientes; ?></h3>
                <p>Clientes</p>
            </span>
        </li>
        <li>
    <div style="min-width: 80px; height: 80px; border-radius: 10px; background: #CFE8FF; display: flex; justify-content: center; align-items: center; margin-right: 15px;">
        <i class='bx bxs-motorcycle' style="font-size: 36px; color: #3C91E6;"></i>
    </div>
    
    <span class="text">
        <h3><?php echo $total_motos; ?></h3>
        <p>Motos en Taller</p>
    </span>
</li>
    </ul>

    <div class="table-data">
        <div class="order">
            <div class="head">
                <h3>Facturas Recientes</h3>
                <i class='bx bx-filter'></i>
            </div>
            <table>
                <thead>
                    <tr>
                        <th>Matrícula</th>
                        <th>Fecha Emisión</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $recientes = mysqli_query($conexion, "SELECT * FROM Facturas ORDER BY Fecha_Emision DESC LIMIT 5");
                    if($recientes) {
                        while($f = mysqli_fetch_assoc($recientes)) {
                            $total_f = number_format($f['Total'], 2);
                            echo "<tr>
                                <td><p>{$f['Matricula']}</p></td>
                                <td>{$f['Fecha_Emision']}</td>
                                <td><span class='status completed'>\${$total_f}</span></td>
                            </tr>";
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="todo">
            <div class="head">
                <h3>Explorador de Facturas</h3>
                <i class='bx bx-search-alt'></i>
            </div>
            <div class="ajax-section" style="padding: 10px;">
                <div class="input-group" style="margin-bottom: 20px;">
                    <p class="text-muted" style="font-size: 13px; margin-bottom: 5px;">Seleccione Matrícula:</p>
                    <select id="select-matricula" onchange="cargarFacturas(this.value)" class="custom-select" style="width: 100%; padding: 10px; border-radius: 10px; border: 1px solid var(--grey); background: var(--color-background); color: var(--dark);">
                        <option value="">Seleccione...</option>
                        <?php
                        $motos_list = mysqli_query($conexion, "SELECT DISTINCT Matricula FROM Facturas");
                        while($m = mysqli_fetch_assoc($motos_list)){
                            echo "<option value='".$m['Matricula']."'>".$m['Matricula']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="input-group" style="margin-bottom: 20px;">
                    <p class="text-muted" style="font-size: 13px; margin-bottom: 5px;">Número de Factura:</p>
                    <select id="select-factura" onchange="mostrarDetalleFactura(this.value)" class="custom-select" style="width: 10
	</section>

	<script src="script.js"></script> <script>
        // Aquí puedes incluir tus funciones de AJAX si no están en script.js
        function cargarFacturas(matricula) {
            if (!matricula) return;
            // Tu lógica de fetch o XMLHttpRequest aquí
            console.log("Cargando facturas para: " + matricula);
        }
        function mostrarDetalleFactura(id) {
            console.log("Mostrando factura: " + id);
        }
    </script>
</body>
</html>