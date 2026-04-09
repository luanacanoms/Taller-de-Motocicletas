<?php
session_start();
include("conexion.php");

// 1. Obtener la conexión (Asegurándonos de usar MySQLi)
$conexion = dbConnect(); 

if (!$conexion) {
    die("Error crítico: La función dbConnect() en conexion.php no devolvió la conexión.");
}

// 2. Comprobamos si el formulario se ha enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recibir los datos de forma segura
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['password'] ?? '';

    // 3. Buscar en la Base de Datos (TRADUCCIÓN A MYSQLI: Usamos '?' en lugar de ':user')
    $sql = "SELECT * FROM usuarios WHERE username = ?";
    
    // Preparamos la consulta
    $stmt = mysqli_prepare($conexion, $sql);
    
    if ($stmt) {
        // Unimos la variable a la interrogación (la "s" significa que es un String/Texto)
        mysqli_stmt_bind_param($stmt, "s", $usuario);
        
        // Ejecutamos la búsqueda
        mysqli_stmt_execute($stmt);
        
        // Extraemos los resultados
        $resultado = mysqli_stmt_get_result($stmt);
        $user = mysqli_fetch_assoc($resultado);

        // 4. Verificar credenciales
        if ($user && $password == $user['password']) {
            // ¡Éxito! Entramos al panel
            $_SESSION['autenticado'] = "SI";
            
            // Guardamos el nombre para que el Dashboard diga "Hola, admin"
            $_SESSION['usuario'] = $user['username']; 
            
            header("Location: menu.php"); 
            exit();
        } else {
            // ERROR: Mandamos la señal oculta de vuelta a index.php
            header("Location: index.php?error=1");
            exit();
        }
    } else {
        die("Error preparando la consulta: " . mysqli_error($conexion));
    }
} else {
    // Si entran directamente saltándose el login, los echamos al inicio
    header("Location: index.php");
    exit();
}
?>