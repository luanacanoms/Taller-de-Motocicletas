<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$mensaje = "";

// 1. GUARDAR CAMBIOS (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ref_original = $_POST['referencia']; 
    $descripcion = $_POST['descripcion'];
    $importe = $_POST['importe'];
    $ganancia = $_POST['ganancia'];

    $sql = "UPDATE repuestos SET Descripcion=?, Importe=?, Ganancia=? WHERE Referencia=?";
    $stmt = $conexion->prepare($sql);
    
    // "sdds" = string, double, double, string
    $stmt->bind_param("sdds", $descripcion, $importe, $ganancia, $ref_original);
    
    if($stmt->execute()) {
        header("Location: listar_repuestos.php");
        exit();
    } else {
        $mensaje = "<p style='color: red; text-align: center;'>Error al actualizar: " . $conexion->error . "</p>";
    }
}

// 2. CARGAR DATOS (GET)
$referencia = $_GET['id'] ?? '';
$sql = "SELECT * FROM repuestos WHERE Referencia = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("s", $referencia);
$stmt->execute();
$resultado = $stmt->get_result();
$pieza = $resultado->fetch_assoc();

if (!$pieza) {
    die("Repuesto no encontrado en la base de datos.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Repuesto</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { background: #F3F4F6; font-family: 'Poppins', sans-serif; display: flex; justify-content: center; padding: 3rem; }
        .card { background: white; padding: 2rem; border-radius: 16px; width: 100%; max-width: 500px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .form-group { margin-bottom: 1rem; }
        .form-group label { display: block; margin-bottom: 0.5rem; font-weight: 500; }
        .form-group input { width: 100%; padding: 0.8rem; border: 1px solid #ddd; border-radius: 8px; box-sizing: border-box; }
        .btn { background: #F59E0B; color: white; padding: 1rem; width: 100%; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; }
    </style>
</head>
<body>
    <div class="card">
        <h2>Editar Repuesto: <?= htmlspecialchars($pieza['Referencia']) ?></h2>
        <?= $mensaje ?>
        <form action="editar_repuesto.php" method="POST">
            <input type="hidden" name="referencia" value="<?= htmlspecialchars($pieza['Referencia']) ?>">
            
            <div class="form-group"><label>Descripción:</label><input type="text" name="descripcion" value="<?= htmlspecialchars($pieza['Descripcion']) ?>" required></div>
            <div style="display:flex; gap:1rem;">
                <div class="form-group" style="flex:1;"><label>Importe (€):</label><input type="number" step="0.01" name="importe" value="<?= htmlspecialchars($pieza['Importe']) ?>" required></div>
                <div class="form-group" style="flex:1;"><label>Ganancia (%):</label><input type="number" step="0.01" name="ganancia" value="<?= htmlspecialchars($pieza['Ganancia']) ?>" required></div>
            </div>
            
            <div style="display:flex; gap:1rem; margin-top: 1rem;">
                <a href="listar_repuestos.php" style="flex:1; background:#eee; color:#666; text-align:center; padding:1rem; border-radius:8px; text-decoration:none; font-weight:bold;">Cancelar</a>
                <button type="submit" class="btn" style="flex:1;">Actualizar</button>
            </div>
        </form>
    </div>
</body>
</html>