<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

// 1. Inicializamos la consulta base con un INNER JOIN para ver el nombre del dueño
// El "WHERE 1=1" es un truco que siempre es verdadero, nos permite añadirle "AND..." dinámicamente
$sql = "SELECT m.*, c.Nombre, c.Apellido1 
        FROM Motocicletas m 
        INNER JOIN clientes c ON m.Id_Cliente = c.id_cliente 
        WHERE 1=1";

$parametros = [];

// 2. Si el usuario ha enviado el buscador, añadimos filtros a la consulta SQL
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    if (!empty($_POST['matricula'])) {
        $sql .= " AND m.Matricula LIKE :matricula";
        $parametros[':matricula'] = '%' . $_POST['matricula'] . '%'; // LIKE nos permite buscar coincidencias parciales
    }
    if (!empty($_POST['marca'])) {
        $sql .= " AND m.Marca LIKE :marca";
        $parametros[':marca'] = '%' . $_POST['marca'] . '%';
    }
    if (!empty($_POST['modelo'])) {
        $sql .= " AND m.Modelo LIKE :modelo";
        $parametros[':modelo'] = '%' . $_POST['modelo'] . '%';
    }
    if (!empty($_POST['anyo'])) {
        $sql .= " AND m.Anyo = :anyo"; // El año suele ser exacto
        $parametros[':anyo'] = $_POST['anyo'];
    }
    if (!empty($_POST['color'])) {
        $sql .= " AND m.Color LIKE :color";
        $parametros[':color'] = '%' . $_POST['color'] . '%';
    }
}

// 3. Preparamos y ejecutamos la consulta final
$stmt = $conexion->prepare($sql);
$stmt->execute($parametros);
$motos = $stmt->fetchAll();
?>

<div class="table" style="background: var(--color-white); padding: var(--card-padding); border-radius: var(--card-border-radius); box-shadow: var(--box-shadow); margin-top: 2rem;">
    
    <div class="table_header">
        <p style="font-size: 1.4rem; font-weight: bold;">Buscador Avanzado de Motocicletas</p>
    </div>

    <form action="consultas_motos.php" method="POST" style="display: flex; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem; background: var(--color-background); padding: 1rem; border-radius: var(--border-radius-2);">
        
        <div style="flex: 1; min-width: 150px;">
            <label><b>Matrícula:</b></label>
            <input type="text" name="matricula" placeholder="Ej: 1234" style="width: 100%; margin:0;">
        </div>
        <div style="flex: 1; min-width: 150px;">
            <label><b>Marca:</b></label>
            <input type="text" name="marca" placeholder="Ej: Honda" style="width: 100%; margin:0;">
        </div>
        <div style="flex: 1; min-width: 150px;">
            <label><b>Modelo:</b></label>
            <input type="text" name="modelo" placeholder="Ej: CBR" style="width: 100%; margin:0;">
        </div>
        <div style="flex: 1; min-width: 100px;">
            <label><b>Año:</b></label>
            <input type="number" name="anyo" placeholder="Ej: 2021" style="width: 100%; margin:0;">
        </div>
        <div style="flex: 1; min-width: 150px;">
            <label><b>Color:</b></label>
            <input type="text" name="color" placeholder="Ej: Rojo" style="width: 100%; margin:0;">
        </div>
        
        <div style="width: 100%; text-align: right; margin-top: 1rem;">
            <a href="consultas_motos.php" style="margin-right: 1rem; color: var(--color-danger);">Limpiar Filtros</a>
            <button type="submit" class="add_new" style="padding: 10px 30px;"><i class="fa-solid fa-magnifying-glass"></i> Buscar</button>
        </div>
    </form>

    <div class="table_section"> 
        <table>
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Año</th>
                    <th>Color</th>
                    <th>Dueño</th>
                    <th>Detalles</th> 
                </tr>
            </thead>
            <tbody>
                <?php if(count($motos) > 0): ?>
                    <?php foreach ($motos as $moto): ?>
                    <tr>
                        <td><b><?= htmlspecialchars($moto['Matricula']) ?></b></td>
                        <td><?= htmlspecialchars($moto['Marca']) ?></td>
                        <td><?= htmlspecialchars($moto['Modelo']) ?></td>
                        <td><?= htmlspecialchars($moto['Anyo']) ?></td>
                        <td><?= htmlspecialchars($moto['Color']) ?></td>
                        <td><?= htmlspecialchars($moto['Nombre'] . ' ' . $moto['Apellido1']) ?></td>
                        <td>
                            <a href="editar_moto.php?id=<?= urlencode($moto['Matricula']) ?>">
                                <button style="background-color: var(--color-primary); color: white;"><i class="fa-solid fa-eye"></i> Ver Ficha</button>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--color-danger);">No se encontraron motocicletas con esos filtros.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div> 
</div>