<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$sql = "SELECT m.*, c.Nombre, c.Apellido1 
        FROM motocicletas m 
        INNER JOIN clientes c ON m.Id_Cliente = c.id_cliente 
        WHERE 1=1";

$tipos = ""; 
$parametros = []; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['matricula'])) {
        $sql .= " AND m.Matricula LIKE ?";
        $tipos .= "s";
        $parametros[] = '%' . $_POST['matricula'] . '%';
    }
    if (!empty($_POST['marca'])) {
        $sql .= " AND m.Marca LIKE ?";
        $tipos .= "s";
        $parametros[] = '%' . $_POST['marca'] . '%';
    }
    if (!empty($_POST['modelo'])) {
        $sql .= " AND m.Modelo LIKE ?";
        $tipos .= "s";
        $parametros[] = '%' . $_POST['modelo'] . '%';
    }
    if (!empty($_POST['anyo'])) {
        $sql .= " AND m.Anyo = ?";
        $tipos .= "i";
        $parametros[] = $_POST['anyo'];
    }
    if (!empty($_POST['color'])) {
        $sql .= " AND m.Color LIKE ?";
        $tipos .= "s";
        $parametros[] = '%' . $_POST['color'] . '%';
    }
}

$stmt = $conexion->prepare($sql);
if ($tipos !== "") {
    $stmt->bind_param($tipos, ...$parametros);
}

$stmt->execute();
$resultado = $stmt->get_result();
$motos = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador de Motos - MotoTaller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex !important; height: 100vh; overflow: hidden; }
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; padding: 2rem 3rem; }
        .table_header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .table_header p { font-size: 1.8rem; font-weight: bold; margin: 0; color: #111827; }
        .btn-primary { background: #2596be; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; }
        .filters-container { background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); margin-bottom: 2rem; }
        .table-container { background: #fff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 1.5rem 2rem; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 1.2rem 1rem; border-bottom: 2px solid #F3F4F6; color: #6B7280; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 1.2rem 1rem; border-bottom: 1px solid #F3F4F6; color: #374151; font-weight: 500; }
        .form-row { display: flex; flex-wrap: wrap; gap: 1rem; }
        .form-group { flex: 1; min-width: 150px; }
        .form-group label { display: block; font-size: 0.85rem; color: #666; margin-bottom: 0.4rem; font-weight: 500; }
        .form-group input { width: 100%; padding: 0.7rem; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
    </style>
</head>
<body>

    <?php include("sidebar.php"); ?>

    <div class="main-content">
        
        <div class="table_header">
            <p>Buscador Avanzado de Motocicletas</p>
            <a href="http://localhost/taller/laravel/public/introducir_motocicleta" class="btn-primary">
                <i class='bx bx-plus'></i> Añadir Motocicleta
            </a>
        </div>

        <div class="filters-container">
            <form action="consultas_motos.php" method="POST">
                <div class="form-row">
                    <div class="form-group"><label>Matrícula:</label><input type="text" name="matricula" placeholder="Ej: 1234"></div>
                    <div class="form-group"><label>Marca:</label><input type="text" name="marca" placeholder="Ej: Honda"></div>
                    <div class="form-group"><label>Modelo:</label><input type="text" name="modelo" placeholder="Ej: CBR"></div>
                    <div class="form-group" style="min-width: 100px;"><label>Año:</label><input type="number" name="anyo" placeholder="Ej: 2021"></div>
                    <div class="form-group"><label>Color:</label><input type="text" name="color" placeholder="Ej: Rojo"></div>
                </div>
                <div style="width: 100%; text-align: right; margin-top: 1.5rem;">
                    <a href="consultas_motos.php" style="margin-right: 1.5rem; color: #EF4444; text-decoration: none; font-weight: 500;">Limpiar Filtros</a>
                    <button type="submit" class="btn-primary"><i class="fa-solid fa-magnifying-glass"></i> Buscar Motos</button>
                </div>
            </form>
        </div>

        <div class="table-container"> 
            <table>
                <thead>
                    <tr><th>Matrícula</th><th>Marca</th><th>Modelo</th><th>Año</th><th>Color</th><th>Dueño</th><th>Ficha Técnica</th></tr>
                </thead>
                <tbody>
                    <?php if(count($motos) > 0): ?>
                        <?php foreach ($motos as $moto): ?>
                        <tr>
                            <td><b><?= htmlspecialchars($moto['Matricula']) ?></b></td>
                            <td><?= htmlspecialchars($moto['Marca']) ?></td>
                            <td><?= htmlspecialchars($moto['Modelo']) ?></td>
                            <td><?= htmlspecialchars($moto['Anyo']) ?></td>
                            <td>
                                <span style="display: inline-block; width: 12px; height: 12px; border-radius: 50%; background-color: <?= htmlspecialchars($moto['Color']) ?>; border: 1px solid #ccc; margin-right: 5px;"></span>
                                <?= htmlspecialchars($moto['Color']) ?>
                            </td>
                            <td><?= htmlspecialchars($moto['Nombre'] . ' ' . $moto['Apellido1']) ?></td>
                            <td>
                                <a href="http://localhost/taller/laravel/public/datos_motocicleta/<?= urlencode($moto['Matricula']) ?>" class="btn-primary" style="padding: 0.4rem 1rem; font-size: 0.85rem; background: #E0F2FE; color: #0284C7;">
                                    <i class="fa-solid fa-eye"></i> Ver
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" style="text-align: center; color: #EF4444; padding: 2rem;">No se encontraron motocicletas con esos filtros.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div> 
    </div>
</body>
</html>