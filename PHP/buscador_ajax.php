<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$sql = "SELECT DISTINCT Matricula FROM motocicletas ORDER BY Matricula";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Buscador AJAX - MotoTaller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex; height: 100vh; overflow: hidden; }
        .main-content { flex: 1; padding: 2rem 3rem; overflow-y: auto; }
        .card { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 800px; margin: 0 auto; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-weight: 600; color: #374151; margin-bottom: 0.5rem; }
        select { width: 100%; padding: 0.8rem; border: 1px solid #D1D5DB; border-radius: 8px; font-family: 'Poppins'; background: #F9FAFB; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 1rem; }
        th { padding: 1rem; border-bottom: 2px solid #E5E7EB; color: #6B7280; text-align: left; }
        td { padding: 1rem; border-bottom: 1px solid #E5E7EB; color: #111827; }
    </style>
</head>
<body>
    <?php include("sidebar.php"); ?>

    <div class="main-content">
        <div class="card">
            <h2><i class='bx bx-search-alt'></i> Buscador Inteligente de Facturas (AJAX)</h2>
            
            <div style="display: flex; gap: 2rem;">
                <div class="form-group" style="flex: 1;">
                    <label>1. Selecciona Matrícula</label>
                    <select id="select-matricula">
                        <option value="">-- Elige una moto --</option>
                        <?php while($fila = $resultado->fetch_assoc()): ?>
                            <option value="<?= $fila['Matricula'] ?>"><?= $fila['Matricula'] ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="form-group" style="flex: 1;">
                    <label>2. Selecciona Factura</label>
                    <select id="select-factura" disabled>
                        <option value="">-- Primero elige matrícula --</option>
                    </select>
                </div>
            </div>

            <div id="resultado-detalle" style="margin-top: 2rem;"></div>
        </div>
    </div>

    <script>
        
        document.getElementById('select-matricula').addEventListener('change', function() {
            let matriculaSeleccionada = this.value;
            let selectFactura = document.getElementById('select-factura');
            let divDetalle = document.getElementById('resultado-detalle');
            
            divDetalle.innerHTML = '';
            selectFactura.innerHTML = '<option value="">Cargando facturas...</option>';
            selectFactura.disabled = true;

            if(matriculaSeleccionada !== "") {
                fetch('ajax_get_facturas.php?matricula=' + matriculaSeleccionada)
                .then(response => response.text())
                .then(data => {
                    selectFactura.innerHTML = data; // Rellenamos el desplegable 2
                    selectFactura.disabled = false;
                });
            } else {
                selectFactura.innerHTML = '<option value="">-- Primero elige matrícula --</option>';
            }
        });

        document.getElementById('select-factura').addEventListener('change', function() {
            let facturaSeleccionada = this.value;
            let divDetalle = document.getElementById('resultado-detalle');

            if(facturaSeleccionada !== "") {
                divDetalle.innerHTML = '<p>Buscando detalles...</p>';
                // Llamada AJAX al servidor
                fetch('ajax_get_detalle.php?factura=' + facturaSeleccionada)
                .then(response => response.text())
                .then(data => {
                    divDetalle.innerHTML = data; // Inyectamos la tabla
                });
            } else {
                divDetalle.innerHTML = '';
            }
        });
    </script>
</body>
</html>