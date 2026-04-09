<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$mensaje = "";

// Comprobamos si el formulario ha sido enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 1. Recogemos los datos de texto de forma segura
    $referencia = $_POST['referencia'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $importe = $_POST['importe'] ?? 0;
    $ganancia = $_POST['ganancia'] ?? 0;

    // 2. Procesamos la fotografía (en binario, igual que hiciste con clientes)
    $foto = null;
    if (isset($_FILES['fotografia']) && $_FILES['fotografia']['error'] == 0) {
        $foto = file_get_contents($_FILES['fotografia']['tmp_name']);
    }

    // 3. Insertamos en la BD usando Prepared Statements para máxima seguridad
    $sql = "INSERT INTO Repuestos (Referencia, Descripcion, Importe, Ganancia, Fotografia) 
            VALUES (:ref, :desc, :imp, :gan, :foto)";
    
    try {
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':ref' => $referencia,
            ':desc' => $descripcion,
            ':imp' => $importe,
            ':gan' => $ganancia,
            ':foto' => $foto
        ]);
        // Mensaje de éxito que mostraremos debajo del título
        $mensaje = "<p style='color: var(--color-success); font-weight: bold;'>¡Repuesto añadido con éxito!</p>";
    } catch(PDOException $e) {
        $mensaje = "<p style='color: var(--color-danger); font-weight: bold;'>Error al guardar: " . $e->getMessage() . "</p>";
    }
}
?>

<div class="table" style="background: var(--color-white); padding: var(--card-padding); border-radius: var(--card-border-radius); box-shadow: var(--box-shadow); margin-top: 2rem;">
    
    <div class="table_header">
        <p style="font-size: 1.4rem; font-weight: bold;">Añadir Nuevo Repuesto</p>
        <div>
            <a href="listar_repuestos.php">
                <button style="background-color: var(--color-info-dark); color: white;"><i class="fa-solid fa-arrow-left"></i> Volver a la Lista</button>
            </a>
        </div>
    </div>

    <div style="margin: 1rem 0; text-align: center;">
        <?= $mensaje ?>
    </div>

    <form action="intro_repuestos.php" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.5rem; max-width: 600px; margin: 0 auto;">
        
        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label><b>Referencia del Producto:</b></label>
            <input type="text" name="referencia" placeholder="Ej: REP-001" required style="width: 100%;">
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label><b>Descripción:</b></label>
            <input type="text" name="descripcion" placeholder="Ej: Filtro de Aceite K&N" required style="width: 100%;">
        </div>

        <div style="display: flex; gap: 1rem;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Importe (€):</b></label>
                <input type="number" step="0.01" name="importe" placeholder="0.00" required style="width: 100%;">
            </div>

            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Ganancia (%):</b></label>
                <input type="number" step="0.01" name="ganancia" placeholder="Ej: 25" required style="width: 100%;">
            </div>
        </div>

        <div style="display: flex; flex-direction: column; gap: 0.5rem;">
            <label><b>Fotografía:</b></label>
            <input type="file" name="fotografia" accept="image/*" style="border: none; padding: 0;">
        </div>

        <div style="text-align: center; margin-top: 1rem;">
            <button type="submit" class="add_new" style="width: 100%; font-size: 1.1rem; padding: 12px;">Guardar Repuesto</button>
        </div>
    </form>
</div>