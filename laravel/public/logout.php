<?php
session_start();
session_unset(); // Borra las variables
session_destroy(); // Destruye la sesión por completo

// Te devuelve a la página de login
header("Location: index.php");
exit();
?>