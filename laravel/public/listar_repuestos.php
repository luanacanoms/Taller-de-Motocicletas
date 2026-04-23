<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

// Buscamos los repuestos
$sql = "SELECT * FROM repuestos ORDER BY Referencia";
$consulta = $conexion->prepare($sql);
$consulta->execute();
$resultado = $consulta->get_result();
$repuestos = $resultado->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Repuestos - MotoTaller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex !important; height: 100vh; overflow: hidden; }
        
        .nav-item { padding: 0.9rem 1.5rem; display: flex; align-items: center; gap: 15px; color: #6B7280; text-decoration: none; font-weight: 500; transition: all 0.2s; margin: 0 0.8rem 0.3rem 0.8rem; border-radius: 8px; }
        .nav-item:hover { background-color: #F9FAFB; color: #2596be; }
        .nav-item.active { background-color: #E0F2FE; color: #0284C7; font-weight: 600; }
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; padding: 2rem 3rem; }
        .table_header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .table_header p { font-size: 1.8rem; font-weight: bold; margin: 0; color: #111827; }
        .add_new { background: #2596be; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; font-family: 'Poppins'; text-decoration: none; }
        .table-container { background: #fff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 1.5rem 2rem; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 1.2rem 1rem; border-bottom: 2px solid #F3F4F6; color: #6B7280; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 1.2rem 1rem; border-bottom: 1px solid #F3F4F6; color: #374151; font-weight: 500; }
        .btn-action { border: none; background: none; cursor: pointer; font-size: 1.2rem; margin-right: 10px; }
        .btn-edit { color: #3B82F6; }
        .btn-delete { color: #EF4444; }
    </style>
</head>
<body>
    <?php include("sidebar.php"); ?>
    <div class="main-content">
        <div class="table_header">
            <p>Gestión de Repuestos</p>
            <a href="intro_repuestos.php" class="add_new"><i class='bx bx-plus'></i> Añadir Nuevo</a>
        </div>
        <div class="table-container"> 
            <table>
                <thead>
                    <tr>
                        <th>Referencia</th>
                        <th>Descripción</th>
                        <th>Importe</th>
                        <th>Ganancia</th>
                        <th>Foto</th>
                        <th>Opciones</th> 
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($repuestos as $pieza): ?>
                    <tr>
                        <td><b><?= htmlspecialchars($pieza['Referencia'] ?? '') ?></b></td>
                        <td><?= htmlspecialchars($pieza['Descripcion'] ?? '') ?></td>
                        <td style="color: #0284C7; font-weight: bold;"><?= htmlspecialchars($pieza['Importe'] ?? '') ?> €</td>
                        <td style="color: #10B981; font-weight: bold;"><?= htmlspecialchars($pieza['Ganancia'] ?? '') ?> %</td>
                        <td>
                            <?php if(!empty($pieza['Fotografia'])): ?>
                                <i class="fa-solid fa-image" style="color: #2596be;"></i>
                            <?php else: ?>
                                <span style="color: #9CA3AF;">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="editar_repuesto.php?id=<?= urlencode($pieza['Referencia']) ?>" class="btn-action btn-edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            <a href="borrar_repuesto.php?id=<?= urlencode($pieza['Referencia']) ?>" class="btn-action btn-delete" onclick="return confirm('¿Seguro que deseas borrar este repuesto?');"><i class="fa-solid fa-trash"></i></a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div> 
    </div>
</body>
</html>