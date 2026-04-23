<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $referencia = $_POST['referencia'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $importe = $_POST['importe'] ?? 0;
    $ganancia = $_POST['ganancia'] ?? 0;

    $foto = null;
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] == 0) {
        $foto = file_get_contents($_FILES['fotografia']['tmp_name']);
    }

    $sql = "INSERT INTO repuestos (Referencia, Descripcion, Importe, Ganancia, Fotografia) VALUES (?, ?, ?, ?, ?)";
    try {
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ssdds", $referencia, $descripcion, $importe, $ganancia, $foto);
        $stmt->execute();
        $mensaje = "<div style='background:#DCFCE7; color:#166534; padding:1rem; border-radius:8px; margin-bottom:1rem; font-weight:bold;'>¡Repuesto añadido con éxito!</div>";
    } catch(Exception $e) {
        $mensaje = "<div style='background:#FEE2E2; color:#991B1B; padding:1rem; border-radius:8px; margin-bottom:1rem; font-weight:bold;'>Error al guardar: " . $conexion->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Añadir Repuesto - MotoTaller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex; height: 100vh; overflow: hidden; }
        
        .nav-item { padding: 0.9rem 1.5rem; display: flex; align-items: center; gap: 15px; color: #6B7280; text-decoration: none; font-weight: 500; margin: 0 0.8rem 0.3rem 0.8rem; border-radius: 8px; }
        .nav-item:hover { background-color: #F9FAFB; color: #2596be; }
        
        .main-content { flex: 1; padding: 2rem 3rem; overflow-y: auto; }
        .form-container { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; font-size: 0.9rem; }
        .form-group input { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins'; }
        .btn-submit { background: #2596be; color: white; border: none; padding: 1rem; border-radius: 8px; cursor: pointer; font-weight: 600; width: 100%; font-size: 1rem; }
        .btn-back { background: #6B7280; color: white; text-decoration: none; padding: 0.5rem 1rem; border-radius: 8px; font-size: 0.9rem; display: inline-block; margin-bottom: 1.5rem; }
    </style>
</head>
<body>
    <?php include("sidebar.php"); ?>
    <div class="main-content">
        
        <div class="form-container">
            <a href="listar_repuestos.php" class="btn-back"><i class='bx bx-arrow-back'></i> Volver a la Lista</a>
            <h2 style="margin-top: 0;">Añadir Nuevo Repuesto</h2>
            
            <?= $mensaje ?>

            <form action="intro_repuestos.php" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Referencia del Producto</label>
                    <input type="text" name="referencia" placeholder="Ej: REP-001" required>
                </div>
                <div class="form-group">
                    <label>Descripción</label>
                    <input type="text" name="descripcion" placeholder="Ej: Filtro de Aceite" required>
                </div>
                <div style="display: flex; gap: 1rem;">
                    <div class="form-group" style="flex: 1;">
                        <label>Importe (€)</label>
                        <input type="number" step="0.01" name="importe" placeholder="0.00" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Ganancia (%)</label>
                        <input type="number" step="0.01" name="ganancia" placeholder="Ej: 25" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Fotografía</label>
                    <input type="file" name="fotografia" accept="image/*" style="border: none; padding: 0;">
                </div>
                <button type="submit" class="btn-submit">Guardar Repuesto</button>
            </form>
        </div>
    </div>
</body>
</html>