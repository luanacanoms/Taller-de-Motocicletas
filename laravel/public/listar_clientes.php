<?php
// 1. SEGURIDAD Y CONEXIÓN
include("seguridad.php"); 
include("conexion.php");
$conexion = dbConnect();

// 2. CONSULTA DE DATOS
$sql = "SELECT * FROM clientes ORDER BY id_cliente";
$consulta = $conexion->prepare($sql);
$consulta->execute();
$resultado = $consulta->get_result();
$clientes = $resultado->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Directorio de Clientes - MotoTaller</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex !important; height: 100vh; overflow: hidden; }
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; padding: 2rem 3rem; }
        .table-container { background: #fff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 1.5rem 2rem; }
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 1.2rem 1rem; border-bottom: 2px solid #F3F4F6; color: #6B7280; font-size: 0.85rem; text-transform: uppercase; }
        td { padding: 1.2rem 1rem; border-bottom: 1px solid #F3F4F6; color: #374151; font-weight: 500; }
        
        .btn-action { font-size: 1.4rem; cursor: pointer; background: none; border: none; margin-right: 10px; padding: 0; }
        .btn-edit { color: #3B82F6; }
        .btn-delete { color: #EF4444; }

        .modal-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: none; justify-content: center; align-items: center; z-index: 1000; }
        .modal-box { background: white; padding: 2rem; border-radius: 16px; width: 100%; max-width: 500px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
        .btn-primary { background: #2596be; color: white; border: none; padding: 0.7rem 1.5rem; border-radius: 8px; cursor: pointer; font-weight: 600; }
    </style>
</head>
<body>

    <?php include_once("sidebar.php"); ?>

    <div class="main-content">
        <header style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1>Directorio de Clientes</h1>
            <button class="btn-primary" onclick="abrirModalNuevo()" style="display: flex; align-items: center; gap: 8px;">
                <i class='bx bx-user-plus'></i> Nuevo Cliente
            </button>
        </header>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>DNI</th>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $fila): ?>
                    <tr>
                        <td><b><?= $fila['id_cliente'] ?? $fila['Id_Cliente'] ?></b></td>
                        <td><?= htmlspecialchars($fila['DNI']) ?></td>
                        <td><?= htmlspecialchars($fila['Nombre'] . " " . $fila['Apellido1']) ?></td>
                        <td style="font-size: 0.9rem; color: #6B7280;"><?= htmlspecialchars($fila['Email']) ?></td>
                        <td>
                            <button type="button" class="btn-action btn-edit" 
                                onclick="abrirModalEditar('<?= $fila['id_cliente'] ?? $fila['Id_Cliente'] ?>', '<?= $fila['DNI'] ?>', '<?= $fila['Nombre'] ?>', '<?= $fila['Apellido1'] ?>', '<?= $fila['Apellido2'] ?>', '<?= $fila['Email'] ?>')">
                                <i class='bx bxs-edit'></i>
                            </button>
                            <a href="eliminar_fichero_clientes.php?id=<?= $fila['id_cliente'] ?? $fila['Id_Cliente'] ?>" class="btn-action btn-delete" onclick="return confirm('¿Borrar cliente?');">
                                <i class='bx bxs-trash'></i>
                            </a>
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
                <h3>Registrar Nuevo Cliente</h3>
                <button type="button" style="background:none; border:none; font-size:1.5rem; cursor:pointer;" onclick="cerrarModalNuevo()">&times;</button>
            </div>
            <form action="intro_clientes.php" method="POST">
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1;"><label style="display:block; font-size: 0.8rem; color:#666;">DNI</label><input type="text" name="dni" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                    <div style="flex: 1;"><label style="display:block; font-size: 0.8rem; color:#666;">Nombre</label><input type="text" name="nombre" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                </div>
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1;"><label style="display:block; font-size: 0.8rem; color:#666;">Primer Apellido</label><input type="text" name="apellido1" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                    <div style="flex: 1;"><label style="display:block; font-size: 0.8rem; color:#666;">Segundo Apellido</label><input type="text" name="apellido2" style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                </div>
                <div style="margin-bottom: 1rem;"><label style="display:block; font-size: 0.8rem; color:#666;">Email</label><input type="email" name="email" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                    <button type="button" onclick="cerrarModalNuevo()" style="background:#eee; border:none; padding:0.7rem 1.5rem; border-radius:8px; cursor:pointer;">Cancelar</button>
                    <button type="submit" class="btn-primary" style="background:#10B981;">Guardar Cliente</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditar" class="modal-overlay">
        <div class="modal-box">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                <h3>Editar Información del Cliente</h3>
                <button type="button" style="background:none; border:none; font-size:1.5rem; cursor:pointer;" onclick="cerrarModalEditar()">&times;</button>
            </div>
            <form action="editar_clientes.php" method="POST">
                <input type="hidden" id="edit_idCliente" name="idCliente">
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1;"><label style="display:block; font-size: 0.8rem; color:#666;">DNI</label><input type="text" id="edit_dni" name="dni" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                    <div style="flex: 1;"><label style="display:block; font-size: 0.8rem; color:#666;">Nombre</label><input type="text" id="edit_nombre" name="nombre" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                </div>
                <div style="display: flex; gap: 1rem; margin-bottom: 1rem;">
                    <div style="flex: 1;"><label style="display:block; font-size: 0.8rem; color:#666;">Primer Apellido</label><input type="text" id="edit_apellido1" name="apellido1" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                    <div style="flex: 1;"><label style="display:block; font-size: 0.8rem; color:#666;">Segundo Apellido</label><input type="text" id="edit_apellido2" name="apellido2" style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                </div>
                <div style="margin-bottom: 1rem;"><label style="display:block; font-size: 0.8rem; color:#666;">Email</label><input type="email" id="edit_email" name="email" required style="width:100%; padding:0.7rem; border:1px solid #ddd; border-radius:8px;"></div>
                <div style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 1.5rem;">
                    <button type="button" onclick="cerrarModalEditar()" style="background:#eee; border:none; padding:0.7rem 1.5rem; border-radius:8px; cursor:pointer;">Cancelar</button>
                    <button type="submit" class="btn-primary" style="background:#3B82F6;">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModalNuevo() { document.getElementById('modalNuevo').style.display = 'flex'; }
        function cerrarModalNuevo() { document.getElementById('modalNuevo').style.display = 'none'; }

        function abrirModalEditar(id, dni, nombre, ap1, ap2, email) {
            document.getElementById('edit_idCliente').value = id;
            document.getElementById('edit_dni').value = dni;
            document.getElementById('edit_nombre').value = nombre;
            document.getElementById('edit_apellido1').value = ap1;
            document.getElementById('edit_apellido2').value = ap2;
            document.getElementById('edit_email').value = email;
            
            document.getElementById('modalEditar').style.display = 'flex';
        }
        function cerrarModalEditar() { document.getElementById('modalEditar').style.display = 'none'; }
    </script>
</body>
</html>