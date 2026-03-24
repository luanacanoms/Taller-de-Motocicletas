<?php
session_start();
// Si el usuario ya está autenticado, lo enviamos directo al menú
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] == "SI") {
    header("Location: menu.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Practica 1</title>
</head>
<body>
    <h1>Taller de Motocicletas</h1>

    <?php echo "<h2>Login</h2>"; ?>

    <form action="login.php" method="POST">
        Usuario: <input type="text" name="usuario" required><br>
        Password: <input type="password" name="password" required><br>
        <button type="submit" name="entrar">Entrar</button>
    </form>
</body>
</html>