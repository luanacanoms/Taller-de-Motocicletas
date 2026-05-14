<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$motos = $conexion->query("SELECT Matricula, Marca, Modelo FROM Motocicletas ORDER BY Matricula");

$repuestos = $conexion->query("SELECT Referencia, Descripcion, Importe FROM Repuestos ORDER BY Descripcion");
$repuestosArray = [];
while($r = $repuestos->fetch_assoc()){
    $repuestosArray[] = $r;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Nueva Factura - MotoTaller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex; height: 100vh; overflow: hidden; }
        .main-content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; padding: 2rem 3rem; }
        .form-container { background: #fff; padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); max-width: 800px; margin: 0 auto; width: 100%; }
        
        .form-group { margin-bottom: 1rem; }
        label { display: block; font-size: 0.85rem; color: #4B5563; font-weight: 600; margin-bottom: 5px; }
        input, select { width: 100%; padding: 0.8rem; border: 1px solid #D1D5DB; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins'; }
        
        .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        
        .repuestos-section { background: #F9FAFB; padding: 1.5rem; border-radius: 8px; margin-top: 1rem; border: 1px dashed #D1D5DB; }
        .linea-repuesto { display: flex; gap: 10px; margin-bottom: 10px; align-items: center; }
        .btn-add-linea { background: #10B981; color: white; border: none; padding: 8px 15px; border-radius: 6px; cursor: pointer; font-size: 0.85rem; font-weight: bold; margin-bottom: 1rem; }
        .btn-remove { background: #EF4444; color: white; border: none; padding: 8px 12px; border-radius: 6px; cursor: pointer; }
        
        .btn-submit { background: #2596be; color: white; border: none; padding: 12px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; margin-top: 20px; font-size: 1.1rem; }
        .btn-submit:hover { background: #1c7a9b; }
        .btn-back { display: inline-block; background: #eee; color: #333; text-decoration: none; padding: 10px 20px; border-radius: 8px; margin-bottom: 20px; font-weight: 600; }
    </style>
</head>
<body>

    <?php include("sidebar.php"); ?>

    <div class="main-content">
        <div class="form-container">
            <a href="listar_facturas.php" class="btn-back"><i class='bx bx-arrow-back'></i> Volver a Facturas</a>
            <h2 style="margin-top: 0;">Emitir Nueva Factura</h2>
            
            <form action="procesar_factura.php" method="POST">
                
                <div class="grid-2">
                    <div class="form-group">
                        <label>Nº Factura</label>
                        <input type="text" name="numero_factura" placeholder="Ej: FAC-26-015" required>
                    </div>
                    <div class="form-group">
                        <label>Motocicleta (Matrícula)</label>
                        <select name="matricula" required>
                            <option value="">Selecciona una moto...</option>
                            <?php while($m = $motos->fetch_assoc()): ?>
                                <option value="<?= $m['Matricula'] ?>"><?= $m['Matricula'] ?> - <?= htmlspecialchars($m['Marca'] . " " . $m['Modelo']) ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Fecha de Emisión</label>
                        <input type="date" name="fecha_emision" value="<?= date('Y-m-d') ?>" required>
                    </div>
                    <div class="form-group">
                        <label>Fecha de Pago (Dejar vacío si no está pagada)</label>
                        <input type="date" name="fecha_pago">
                    </div>
                </div>

                <div class="grid-2">
                    <div class="form-group">
                        <label>Mano de Obra (Horas)</label>
                        <input type="number" step="0.5" name="mano_obra" placeholder="Ej: 2.5" required>
                    </div>
                    <div class="form-group">
                        <label>Precio por Hora (€)</label>
                        <input type="number" step="0.01" name="precio_hora" placeholder="Ej: 40.00" required>
                    </div>
                </div>

                <div class="repuestos-section">
                    <h3 style="margin-top:0; font-size:1.1rem; color:#374151;">Líneas de Detalle (Repuestos)</h3>
                    <button type="button" class="btn-add-linea" onclick="agregarLinea()"><i class='bx bx-plus'></i> Añadir Repuesto</button>
                    
                    <div id="contenedor-repuestos">
                        </div>
                </div>

                <button type="submit" class="btn-submit">Guardar Factura y Calcular Totales</button>
            </form>
        </div>
    </div>

    <script>
        function agregarLinea() {
            const contenedor = document.getElementById('contenedor-repuestos');
            const linea = document.createElement('div');
            linea.className = 'linea-repuesto';
            
            linea.innerHTML = `
                <select name="referencias[]" required style="flex: 2;">
                    <option value="">Seleccione repuesto...</option>
                    <?php foreach($repuestosArray as $rep): ?>
                        <option value="<?= $rep['Referencia'] ?>"><?= htmlspecialchars($rep['Descripcion']) ?> (<?= $rep['Importe'] ?>€)</option>
                    <?php endforeach; ?>
                </select>
                <input type="number" name="unidades[]" placeholder="Unidades" required min="1" style="flex: 1;">
                <button type="button" class="btn-remove" onclick="this.parentElement.remove()"><i class='bx bx-trash'></i></button>
            `;
            contenedor.appendChild(linea);
        }
        
        window.onload = function() { agregarLinea(); };
    </script>
</body>
</html>