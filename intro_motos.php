<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

$mensaje = "";

// 1. PROCESAR EL FORMULARIO CUANDO SE ENVÍA
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $matricula = $_POST['matricula'] ?? '';
    $marca = $_POST['marca'] ?? '';
    $modelo = $_POST['modelo'] ?? '';
    $anyo = $_POST['anyo'] ?? '';
    $color = $_POST['color'] ?? '';
    $id_cliente = $_POST['id_cliente'] ?? '';

    $sql = "INSERT INTO Motocicletas (Matricula, Marca, Modelo, Anyo, Color, Id_Cliente) 
            VALUES (:mat, :mar, :mod, :any, :col, :idc)";
    
    try {
        $stmt = $conexion->prepare($sql);
        $stmt->execute([
            ':mat' => $matricula,
            ':mar' => $marca,
            ':mod' => $modelo,
            ':any' => $anyo,
            ':col' => $color,
            ':idc' => $id_cliente
        ]);
        $mensaje = "<p style='color: var(--color-success); font-weight: bold;'>¡Motocicleta registrada con éxito!</p>";
    } catch(PDOException $e) {
        $mensaje = "<p style='color: var(--color-danger); font-weight: bold;'>Error al guardar: " . $e->getMessage() . "</p>";
    }
}

// 2. OBTENER LA LISTA DE CLIENTES PARA EL DESPLEGABLE
$sqlClientes = "SELECT id_cliente, Nombre, Apellido1, DNI FROM clientes ORDER BY Nombre";
$stmtClientes = $conexion->prepare($sqlClientes);
$stmtClientes->execute();
$clientes = $stmtClientes->fetchAll();
?>

<div class="table" style="background: var(--color-white); padding: var(--card-padding); border-radius: var(--card-border-radius); box-shadow: var(--box-shadow); margin-top: 2rem;">
    
    <div class="table_header">
        <p style="font-size: 1.4rem; font-weight: bold;">Registrar Nueva Motocicleta</p>
        <div>
            <a href="listar_motos.php">
                <button style="background-color: var(--color-info-dark); color: white;"><i class="fa-solid fa-arrow-left"></i> Volver a la Lista</button>
            </a>
        </div>
    </div>

    <div style="margin: 1rem 0; text-align: center;">
        <?= $mensaje ?>
    </div>

    <form action="intro_motos.php" method="POST" style="display: flex; flex-direction: column; gap: 1.5rem; max-width: 600px; margin: 0 auto;">
        
        <div style="display: flex; gap: 1rem;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Matrícula:</b></label>
                <input type="text" name="matricula" placeholder="Ej: 1234-ABC" required style="width: 100%;">
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Dueño (Cliente):</b></label>
                <select name="id_cliente" required style="width: 100%; padding: 10px; border: 1px solid #0298cf; border-radius: 6px; color: var(--color-dark); outline: none;">
                    <option value="">Seleccione un cliente...</option>
                    <?php foreach ($clientes as $cli): ?>
                        <option value="<?= htmlspecialchars($cli['id_cliente']) ?>">
                            <?= htmlspecialchars($cli['Nombre'] . ' ' . $cli['Apellido1'] . ' (' . $cli['DNI'] . ')') ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Marca:</b></label>
                <input type="text" name="marca" placeholder="Ej: Honda" required style="width: 100%;">
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Modelo:</b></label>
                <input type="text" name="modelo" placeholder="Ej: CBR 600" required style="width: 100%;">
            </div>
        </div>

        <div style="display: flex; gap: 1rem;">
            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Año:</b></label>
                <input type="number" name="anyo" placeholder="Ej: 2021" required style="width: 100%;">
            </div>
            <div style="display: flex; flex-direction: column; gap: 0.5rem; width: 50%;">
                <label><b>Color:</b></label>
                <input type="text" name="color" placeholder="Ej: Rojo" required style="width: 100%;">
            </div>
        </div>

        <div style="text-align: center; margin-top: 1rem;">
            <button type="submit" class="add_new" style="width: 100%; font-size: 1.1rem; padding: 12px;">Registrar Moto</button>
        </div>
    </form>
</div>