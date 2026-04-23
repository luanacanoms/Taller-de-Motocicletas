<?php
// 1. SEGURIDAD Y CONEXIÓN
include("seguridad.php"); // Protege la página para que solo entren usuarios logueados
include("conexion.php"); // Conexión a la base de datos MySQL del Taller
$conexion = dbConnect();

// 2. CONSULTA DE DATOS
$sql = "SELECT * FROM motocicletas ORDER BY Matricula"; //
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
    <title>Directorio de Motocicletas - MotoTaller</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        /* CONFIGURACIÓN DEL CUERPO (Layout Híbrido) */
        body { 
            margin: 0; 
            font-family: 'Poppins', sans-serif; 
            background-color: #F3F4F6; 
            display: flex; /* Sidebar a la izquierda, contenido a la derecha */
            height: 100vh; 
            overflow: hidden; 
        }

       
        .main-content { 
            flex: 1; 
            display: flex; 
            flex-direction: column; 
            overflow-y: auto; 
            padding: 2rem 3rem; 
        }

        /* TABLA PROFESIONAL */
        .table-container { 
            background: #fff; 
            border-radius: 16px; 
            box-shadow: 0 4px 6px rgba(0,0,0,0.02); 
            padding: 1.5rem 2rem; 
            margin-top: 1rem;
        }
        
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 1.2rem 1rem; border-bottom: 2px solid #F3F4F6; color: #6B7280; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 1.2rem 1rem; border-bottom: 1px solid #F3F4F6; color: #374151; font-weight: 500; }
        
        /* BOTONES DE ACCIÓN */
        .btn-action { font-size: 1.4rem; background: none; border: none; cursor: pointer; padding: 0; margin-right: 10px; }
        .btn-edit { color: #3B82F6; }
        .btn-delete { color: #EF4444; }

        /* MODALES */
        .modal-overlay { 
            position: fixed; top: 0; left: 0; width: 100%; height: 100%; 
            background: rgba(0, 0, 0, 0.5); display: none; 
            justify-content: center; align-items: center; z-index: 1000; 
        }
        .modal-box { 
            background: white; padding: 2rem; border-radius: 16px; 
            width: 100%; max-width: 450px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); 
        }
    </style>
</head>
<body>

    <?php include_once("sidebar.php"); ?>

    <div class="main-content">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>Directorio de Motocicletas</h1>
            <div style="color: #6B7280; font-weight: 500;">
                <i class='bx bx-calendar'></i> <?php echo date('d/m/Y'); ?>
            </div>
        </header>
        
        <div class="table-container">
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
                        <td><b><?= htmlspecialchars($moto['Matricula']) ?></b></td>
                        <td>
                            <span style="font-weight: 700; color: #111827;"><?= htmlspecialchars($moto['Marca']) ?></span><br>
                            <small style="color: #6B7280;"><?= htmlspecialchars($moto['Modelo']) ?></small>
                        </td>
                        <td>
                            <?= htmlspecialchars($moto['Anyo']) ?><br>
                            <small style="color: #6B7280;"><?= htmlspecialchars($moto['Color']) ?></small>
                        </td>
                        <td>
                            <button type="button" class="btn-action btn-edit" 
                                onclick="abrirModalMoto('<?= $moto['Matricula'] ?>', '<?= $moto['Marca'] ?>', '<?= $moto['Modelo'] ?>', '<?= $moto['Anyo'] ?>', '<?= $moto['Color'] ?>')">
                                <i class='bx bxs-edit'></i>
                            </button>
                            
                            <a href="eliminar_moto.php?matricula=<?= $moto['Matricula'] ?>" class="btn-action btn-delete" onclick="return confirm('¿Seguro que quieres eliminar esta moto?');">
                                <i class='bx bxs-trash'></i>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div id="modalMoto" class="modal-overlay">
        <div class="modal-box">
            <h3 style="margin-top: 0;">Actualizar Motocicleta</h3>
            <form action="editar_moto.php" method="POST">
                <input type="hidden" id="m_matricula" name="matricula">
                
                <div style="margin-bottom: 1rem;">
                    <label style="font-size: 0.8rem; color: #666;">Marca</label>
                    <input type="text" id="m_marca" name="marca" style="width:100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box;">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label style="font-size: 0.8rem; color: #666;">Modelo</label>
                    <input type="text" id="m_modelo" name="modelo" style="width:100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box;">
                </div>

                <div style="display: flex; gap: 10px; margin-bottom: 1.5rem;">
                    <div style="flex: 1;">
                        <label style="font-size: 0.8rem; color: #666;">Año</label>
                        <input type="number" id="m_anyo" name="anyo" style="width:100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box;">
                    </div>
                    <div style="flex: 1;">
                        <label style="font-size: 0.8rem; color: #666;">Color</label>
                        <input type="text" id="m_color" name="color" style="width:100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd; box-sizing: border-box;">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="cerrarModalMoto()" style="padding: 10px 20px; border-radius: 8px; border: none; cursor: pointer;">Cancelar</button>
                    <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: #2596be; color: white; font-weight: 600; cursor: pointer;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModalMoto(mat, marca, mod, anyo, col) {
            document.getElementById('m_matricula').value = mat;
            document.getElementById('m_marca').value = marca;
            document.getElementById('m_modelo').value = mod;
            document.getElementById('m_anyo').value = anyo;
            document.getElementById('m_color').value = col;
            document.getElementById('modalMoto').style.display = 'flex';
        }

        function cerrarModalMoto() {
            document.getElementById('modalMoto').style.display = 'none';
        }

        // Cerrar al hacer clic fuera del cuadro blanco
        window.onclick = function(event) {
            let modal = document.getElementById('modalMoto');
            if (event.target == modal) cerrarModalMoto();
        }
    </script>
</body>
</html>