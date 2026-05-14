<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$sql = "SELECT * FROM Repuestos ORDER BY Referencia";
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
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; padding: 2rem 3rem; }
        .table-container { background: #fff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 1.5rem 2rem; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 1.2rem 1rem; border-bottom: 2px solid #F3F4F6; color: #6B7280; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 1.2rem 1rem; border-bottom: 1px solid #F3F4F6; color: #374151; font-weight: 500; }
        .btn-action { border: none; background: none; cursor: pointer; font-size: 1.2rem; margin-right: 10px; }
        .btn-edit { color: #3B82F6; }
        .btn-delete { color: #EF4444; }
        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: none; justify-content: center; align-items: center; z-index: 1000; }
        .modal-box { background: white; padding: 2rem; border-radius: 16px; width: 100%; max-width: 500px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .btn-primary { background: #2596be; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; font-family: 'Poppins'; transition: background 0.3s; }
        .btn-primary:hover { background: #1c7a9b; }
    </style>
</head>
<body>
    
    <?php include("sidebar.php"); ?>
    
    <div class="main-content">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="margin: 0; color: #1F2937;">Gestión de Repuestos</h1>
            <div class="add-button-container">
                <button onclick="abrirModalNuevo()" style="background-color: #2596be; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.95rem; transition: background 0.3s;">
                    <i class='bx bx-plus' style="font-size: 1.2rem;"></i> Añadir Repuesto
                </button>
            </div>
        </header>

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

    <div id="modalNuevo" class="modal-overlay">
        <div class="modal-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                <h3 style="margin: 0; color: #1F2937;">Añadir Nuevo Repuesto</h3>
                <button type="button" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color: #9CA3AF;" onclick="cerrarModalNuevo()">&times;</button>
            </div>
            
            <form action="intro_repuestos.php" method="POST" enctype="multipart/form-data">
                <div style="margin-bottom: 1rem;">
                    <label style="display:block; font-size: 0.8rem; color:#666; font-weight: 600; margin-bottom: 5px;">Descripción</label>
                    <input type="text" name="descripcion" placeholder="Ej: Neumático Michelin" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px; font-family: 'Poppins'; box-sizing: border-box;">
                </div>
                
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1;">
                        <label style="display:block; font-size: 0.8rem; color:#666; font-weight: 600; margin-bottom: 5px;">Importe (€)</label>
                        <input type="number" step="0.01" name="importe" placeholder="0.00" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px; font-family: 'Poppins'; box-sizing: border-box;">
                    </div>
                    <div style="flex: 1;">
                        <label style="display:block; font-size: 0.8rem; color:#666; font-weight: 600; margin-bottom: 5px;">Ganancia (%)</label>
                        <input type="number" name="ganancia" placeholder="Ej: 20" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px; font-family: 'Poppins'; box-sizing: border-box;">
                    </div>
                </div>
                
                <div style="margin-bottom: 1.5rem;">
                    <label style="display:block; font-size: 0.8rem; color:#666; font-weight: 600; margin-bottom: 5px;">Fotografía (Opcional)</label>
                    <input type="file" name="fotografia" accept="image/*" style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px; font-family: 'Poppins'; box-sizing: border-box; background: #F9FAFB;">
                </div>
                
                <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                    <button type="button" onclick="cerrarModalNuevo()" style="background:#eee; border:none; padding:10px 20px; border-radius:8px; cursor:pointer; font-family: 'Poppins'; font-weight: 600;">Cancelar</button>
                    <button type="submit" class="btn-primary" style="padding:10px 20px;">Guardar Repuesto</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModalNuevo() { 
            document.getElementById('modalNuevo').style.display = 'flex'; 
        }
        function cerrarModalNuevo() { 
            document.getElementById('modalNuevo').style.display = 'none'; 
        }

        window.onclick = function(event) {
            let modal = document.getElementById('modalNuevo');
            if (event.target == modal) cerrarModalNuevo();
        }
    </script>
</body>
</html>