<?php
include("seguridad.php");
include("conexion.php");
$conexion = dbConnect();

// Buscamos todos los repuestos en la base de datos
$sql = "SELECT * FROM Repuestos ORDER BY Referencia";
$consulta = $conexion->prepare($sql);
$consulta->execute();
$repuestos = $consulta->fetchAll();
?>

<div class="table">
    <div class="table_header">
        <p>Gestión de Repuestos</p>
        <div>
            <input type="text" placeholder="Buscar repuesto..."/>
            <a href="intro_repuestos.php">
                <button class="add_new">+ Añadir Nuevo</button>
            </a>
        </div>
    </div>
    
    <div class="table_section"> 
        <table>
            <thead>
                <tr>
                    <th>Referencia</th>
                    <th>Descripción</th>
                    <th>Importe (€)</th>
                    <th>Ganancia (%)</th>
                    <th>Foto</th>
                    <th>Opciones</th> 
                </tr>
            </thead>
            <tbody>
                <?php foreach ($repuestos as $pieza): ?>
                <tr>
                    <td><?= htmlspecialchars($pieza['Referencia'] ?? '') ?></td>
                    <td><?= htmlspecialchars($pieza['Descripcion'] ?? '') ?></td>
                    <td><?= htmlspecialchars($pieza['Importe'] ?? '') ?> €</td>
                    <td><?= htmlspecialchars($pieza['Ganancia'] ?? '') ?> %</td>
                    <td>
                        <?php if(!empty($pieza['Fotografia'])): ?>
                            <i class="fa-solid fa-image" style="color: var(--color-primary);"></i>
                        <?php else: ?>
                            -
                        <?php endif; ?>
                    </td>
                    <td>
                        <a href="editar_repuesto.php?id=<?= urlencode($pieza['Referencia']) ?>">
                            <button><i class="fa-solid fa-pen-to-square" style="color: white;"></i></button>
                        </a>
                        <a href="borrar_repuesto.php?id=<?= urlencode($pieza['Referencia']) ?>" onclick="return confirm('¿Seguro que deseas borrar este repuesto?');">
                            <button><i class="fa-solid fa-trash" style="color: white;"></i></button>
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div> 
    
    <div class="pagination">
        <div><i class="fa-solid fa-angles-left"></i></div>
        <div><i class="fa-solid fa-chevron-left"></i></div>
        <div>1</div>
        <div><i class="fa-solid fa-chevron-right"></i></div>
        <div><i class="fa-solid fa-angles-right"></i></div>
    </div>
</div>