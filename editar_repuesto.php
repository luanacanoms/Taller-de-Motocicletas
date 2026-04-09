<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$mensaje = "";

// 1. SI VENIMOS DE ENVIAR EL FORMULARIO (Actualizar datos)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ref_original = $_POST['referencia']; 
    $descripcion = $_POST['descripcion'];
    $importe = $_POST['importe'];
    $ganancia = $_POST['ganancia'];

    $sql = "UPDATE Repuestos SET Descripcion = :desc, Importe = :imp, Ganancia = :gan WHERE Referencia = :ref";
    
    try {
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':desc' => $descripcion,
            ':imp' => $importe,
            ':gan' => $ganancia,
            ':ref' => $ref_original
        ]);
        // Si sale bien, volvemos a la lista
        header("Location: listar_repuestos.php");
        exit();
    } catch(PDOException $e) {
        $mensaje = "<p style='color: var(--color-danger); text-align: center;'>Error al actualizar: " . $e->getMessage() . "</p>";
    }
}

// 2. SI VENIMOS DESDE EL BOTÓN DE LA TABLA (Cargar datos)
$referencia = $_GET['id'] ?? '';
$sql = "SELECT * FROM Repuestos WHERE Referencia = :ref";
$stmt = $conexion->prepare($sql);
$stmt->execute([':ref' => $referencia]);
$pieza = $stmt->fetch();

if (!$pieza) {
    die("Repuesto no encontrado en la base de datos.");
}
?>

<div class="table" style="background: var(--color-white); padding: var(--card-padding); border-radius: var(--card-border-radius); box-shadow: var(--box-shadow); margin-top: 2rem;">
    
    <div class="table_header">
        <p style="font-size: 1.4rem; font-weight: bold;">Editar Repuesto: <?= htmlspecialchars($pieza['Referencia']) ?></p>
        <div>
            <a href="listar_repuestos.php">
                <button style="background-color: var(--color-info-dark); color: white;"><i class="fa-solid fa-arrow-left"></i> Cancelar</button>
            </a>
        </div>
    </div>

    <?= $mensaje ?>

    <form action="editar_repuesto.php" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem; max-width: 600px; margin: 0 auto; padding-top: 1rem;">
        
        <input type="hidden" name="referencia" value="<?= htmlspecialchars($pieza['Referencia']) ?>">

        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label><b>Descripción:</b></label>
            <input type="text" name="descripcion" value="<?= htmlspecialchars($pieza['Descripcion']) ?>" required style="width: 100%;">
        </div>

        <div style="display: flex; gap: 1rem;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Importe (€):</b></label>
                <input type="number" step="0.01" name="importe" value="<?= htmlspecialchars($pieza['Importe']) ?>" required style="width: 100%;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Ganancia (%):</b></label>
                <input type="number" step="0.01" name="ganancia" value="<?= htmlspecialchars($pieza['Ganancia']) ?>" required style="width: 100%;">
            </div>
        </div>

        <div style="text-align: center; margin-top: 1rem;">
            <button type="submit" class="add_new" style="width: 100%; font-size: 1.1rem; padding: 12px; background-color: var(--color-warning);">Actualizar Cambios</button>
        </div>
    </form>
</div>