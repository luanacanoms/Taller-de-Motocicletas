<?php
// Configuración de la base de datos
$host = '127.0.0.1';
$db   = 'taller_motocicletas';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $stmt = $pdo->query("SELECT * FROM motocicletas ORDER BY Matricula ASC");
    $motos = $stmt->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    die("Error en la base de datos: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Motos - MotoTaller Laravel (Fix)</title>
    <link rel="stylesheet" href="css/style.css"> <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
    <main style="padding: 20px;">
        <h1>Directorio de Motocicletas (Modo Rescate)</h1>
        <table border="1" style="width:100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Color</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($motos as $moto): ?>
                <tr>
                    <td><strong><?php echo $moto->Matricula; ?></strong></td>
                    <td><?php echo $moto->Marca; ?></td>
                    <td><?php echo $moto->Modelo; ?></td>
                    <td><?php echo $moto->Color; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>