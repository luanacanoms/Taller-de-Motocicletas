<?php
session_start();
session_unset(); // Borra las variables
session_destroy(); // Destruye la sesión por completo

header("Location: index.php");
exit();
?>