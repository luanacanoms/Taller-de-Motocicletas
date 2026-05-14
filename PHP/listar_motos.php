<?php
include("seguridad.php"); 
include("conexion.php"); 
$conexion = dbConnect();
$sql = "SELECT * FROM Motocicletas ORDER BY Matricula"; 
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
        body { 
            margin: 0; 
            font-family: 'Poppins', sans-serif; 
            background-color: #F3F4F6; 
            display: flex; 
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
        
        .btn-action { font-size: 1.4rem; background: none; border: none; cursor: pointer; padding: 0; margin-right: 10px; }
        .btn-edit { color: #3B82F6; }
        .btn-delete { color: #EF4444; }

        .modal-fondo, .modal-overlay { 
            display: none; 
            position: fixed;
            z-index: 1000;
            left: 0; top: 0; width: 100%; height: 100%;
            background-color: rgba(0, 0, 0, 0.6); 
            align-items: center; justify-content: center;
        }

        .modal-contenido, .modal-box {
            background-color: #fff;
            padding: 2rem;
            border-radius: 16px;
            width: 90%; max-width: 450px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .cerrar-modal {
            position: absolute; top: 15px; right: 20px;
            font-size: 1.8rem; font-weight: bold;
            color: #9CA3AF; cursor: pointer; transition: color 0.3s;
        }
        .cerrar-modal:hover { color: #1F2937; }

        .modal-contenido label, .modal-box label { display: block; margin-top: 12px; font-size: 0.85rem; color: #4B5563; font-weight: 600; }
        .modal-contenido input, .modal-box input { width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #D1D5DB; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins', sans-serif; }
        .btn-guardar { margin-top: 20px; width: 100%; background-color: #2596be; color: white; padding: 12px; border: none; border-radius: 8px; cursor: pointer; font-size: 1rem; font-weight: bold; transition: background 0.3s;}
        .btn-guardar:hover { background-color: #1c7a9b; }
    </style>
</head>
<body>

    <?php include_once("sidebar.php"); ?>

    <div class="main-content">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="margin: 0; color: #1F2937;">Directorio de Motocicletas</h1>
            <div class="add-button-container">
                <button onclick="abrirModal()" style="background-color: #2596be; color: white; padding: 10px 20px; border: none; border-radius: 8px; font-weight: bold; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.95rem; transition: background 0.3s;">
                    <i class='bx bx-plus' style="font-size: 1.2rem;"></i> Añadir Nueva Moto
                </button>
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
                                onclick="abrirModalMoto('<?= htmlspecialchars($moto['Matricula'], ENT_QUOTES) ?>', '<?= htmlspecialchars($moto['Marca'], ENT_QUOTES) ?>', '<?= htmlspecialchars($moto['Modelo'], ENT_QUOTES) ?>', '<?= htmlspecialchars($moto['Anyo'], ENT_QUOTES) ?>', '<?= htmlspecialchars($moto['Color'], ENT_QUOTES) ?>')">
                                <i class='bx bxs-edit'></i>
                            </button>
                            
                            <a href="eliminar_moto.php?matricula=<?= htmlspecialchars($moto['Matricula']) ?>" class="btn-action btn-delete" onclick="return confirm('¿Seguro que quieres eliminar esta moto?');">
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
                    <label>Marca</label>
                    <input type="text" id="m_marca" name="marca">
                </div>

                <div style="margin-bottom: 1rem;">
                    <label>Modelo</label>
                    <input type="text" id="m_modelo" name="modelo">
                </div>

                <div style="display: flex; gap: 10px; margin-bottom: 1.5rem;">
                    <div style="flex: 1;">
                        <label>Año</label>
                        <input type="number" id="m_anyo" name="anyo">
                    </div>
                    <div style="flex: 1;">
                        <label>Color</label>
                        <input type="text" id="m_color" name="color">
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px;">
                    <button type="button" onclick="cerrarModalMoto()" style="padding: 10px 20px; border-radius: 8px; border: 1px solid #D1D5DB; background: white; cursor: pointer; font-weight: 600;">Cancelar</button>
                    <button type="submit" style="padding: 10px 20px; border-radius: 8px; border: none; background: #2596be; color: white; font-weight: 600; cursor: pointer;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <div id="miModalMotos" class="modal-fondo">
        <div class="modal-contenido">
            <span class="cerrar-modal" onclick="cerrarModal()">&times;</span>
            <h2 style="margin-top: 0; color: #1F2937;">Nueva Motocicleta</h2>
            
            <form action="intro_motos.php" method="POST">
                
                <label>Matrícula</label>
                <input type="text" name="matricula" placeholder="Ej: 1234-ABC" required>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label>Marca (Vehículo)</label>
                        <input type="text" name="marca" placeholder="Ej: Vespa" required>
                    </div>
                    <div style="flex: 1;">
                        <label>Modelo (Vehículo)</label>
                        <input type="text" name="modelo" placeholder="Ej: Primavera" required>
                    </div>
                </div>

                <div style="display: flex; gap: 10px;">
                    <div style="flex: 1;">
                        <label>Año</label>
                        <input type="number" name="anyo" placeholder="Ej: 2022" required>
                    </div>
                    <div style="flex: 1;">
                        <label>Color</label>
                        <input type="text" name="color" placeholder="Ej: Azul" required>
                    </div>
                </div>

                <div style="margin-bottom: 1rem;">
    <label style="display:block; font-size: 0.8rem; color:#666; font-weight: 600; margin-bottom: 5px;">Dueño (Cliente)</label>
    <select name="id_cliente" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px; font-family: 'Poppins';">
        <option value="">Seleccione un cliente...</option>
        <?php
        $clientesQuery = $conexion->query("SELECT Id_Cliente, DNI, Nombre, Apellido1 FROM Clientes");
        while ($cli = $clientesQuery->fetch_assoc()) {
            echo "<option value='" . $cli['Id_Cliente'] . "'>" . $cli['DNI'] . " - " . $cli['Nombre'] . " " . $cli['Apellido1'] . "</option>";
        }
        ?>
    </select>
</div>

                <button type="submit" class="btn-guardar">Guardar Motocicleta</button>
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

        function abrirModal() {
            document.getElementById('miModalMotos').style.display = 'flex';
        }

        function cerrarModal() {
            document.getElementById('miModalMotos').style.display = 'none';
        }

        window.onclick = function(event) {
            let modalEditar = document.getElementById('modalMoto');
            let modalAnadir = document.getElementById('miModalMotos');
            
            if (event.target == modalEditar) cerrarModalMoto();
            if (event.target == modalAnadir) cerrarModal();
        }
    </script>
</body>
</html>