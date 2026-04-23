<?php

error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT);
ini_set('display_errors', 0);
session_start();

// Si ya está logueado, lo mandamos al panel directamente
if (isset($_SESSION['autenticado']) && $_SESSION['autenticado'] === "SI") {
    header("Location: menu.php");
    exit();
}

// Variables para mensajes
$error_mensaje = "";
$info_mensaje = "";

// Comprobamos si hay errores de login
if (isset($_GET['error']) && $_GET['error'] == 1) {
    $error_mensaje = "Usuario o contraseña incorrectos.";
}

// Comprobamos si el usuario ha hecho clic en "Olvidé mi contraseña"
if (isset($_GET['forgot']) && $_GET['forgot'] == 1) {
    $info_mensaje = "Para recuperar tu contraseña, por favor contacta con el administrador en admin@taller.com";
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Taller de Motocicletas</title>
    <style>

        body {
            /* 1. Ponemos el fondo gris suave a toda la página */
            background-color: #F0F2F5; 
            
            /* 2. Convertimos el body en una caja flexible */
            display: flex;
            
            /* 3. Centramos horizontalmente */
            justify-content: center; 
            
            /* 4. Centramos verticalmente */
            align-items: center;     
            
            /* 5. Le decimos que ocupe siempre el 100% de la altura de la ventana */
            min-height: 100vh;
            
            margin: 0;
            padding: 20px; /* Para que en móviles no se pegue a los bordes */
        }
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .split-screen {
    /* 1. Posicionamiento y Tamaño (Efecto Tarjeta SaaS) */
    display: flex;
    min-height: 600px; 
    height: 75vh; 
    width: 100%;
    max-width: 950px; 
    background-color: #ffffff;
    border-radius: 24px; 
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);

    /* 2. El "Escudo" contra la línea negra y errores de redondeo */
    overflow: hidden;
    transform: translateZ(0); /* Fuerza el uso de la GPU para suavizar bordes */
    -webkit-backface-visibility: hidden;
    backface-visibility: hidden;
    outline: 1px solid transparent; /* Ayuda al navegador a calcular el radio */
    background-clip: padding-box;
}



        .left-panel {
            flex: 1; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 16px;
        }

        .login-container {
            width: 100%;
            max-width: 380px; 
        }

        .logo-area {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 3rem;
            font-weight: bold;
            font-size: 1.2rem;
        }

        .login-container h1 {
            font-size: 2rem;
            margin-bottom: 1rem;
            color: #111827;
        }

        .login-container p {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-group label {
            display: block;
            font-size: 0.9rem;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        .form-group input {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 1rem;
            outline: none;
            transition: border-color 0.2s;
            gap: 0.5rem;
        }

        .form-group input:focus {
            border-color: #2596be;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* --- NUEVO: Estilos para el enlace de contraseña --- */
        .forgot-link {
            display: block;
            text-align: right;
            font-size: 0.85rem;
            color: #28abd5;
            text-decoration: none;
            margin-bottom: 1.5rem;
            margin-top: -0.5rem; /* Lo subimos un poco para que quede cerca del input */
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: #36a8de;
            text-decoration: underline;
        }

        .btn-submit {
            width: 100%;
            background-color: #2596be; 
            color: white;
            padding: 0.85rem;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
            margin-top: 1.1rem;
        }

        .btn-submit:hover {
            background-color: #1d4ed8;
        }

        .error-message {
            color: #dc2626;
            background-color: #fee2e2;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            text-align: center;
        }

        /* --- NUEVO: Estilos para el mensaje de información --- */
        .info-message {
            color: #0369a1;
            background-color: #e0f2fe;
            padding: 0.75rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            text-align: center;
        }

       .right-panel {
            flex: 0.9; 
            background-image: url('assets/login1.png'); 
            background-size: cover;
            background-position: center;
            margin: 1rem; 
            border-radius: 16px; 
        }
        

        body {
            /* The soft gray background from your image */
            background-color: #F0F2F5; 
            display: flex;
            justify-content: center; /* Centers the card horizontally */
            align-items: center;     /* Centers the card vertically */
            height: 100vh;
            margin: 0;
            padding: 20px; /* Keeps the card from touching the edges on small screens */
        }

.split-screen {
            display: flex;
            min-height: 600px; 
            height: 75vh; 
            width: 100%;
            max-width: 900px; 
            background-color: #ffffff;
            border-radius: 24px; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            -webkit-backface-visibility: hidden;
            -moz-backface-visibility: hidden;
            backface-visibility: hidden;
            transform: translate3d(0, 0, 0);
        }/* This forces your background image to respect the rounded corners */
        

        @media (max-width: 768px) {
            .right-panel { display: none; }
        }
    </style>
</head>
<body>

    <div class="split-screen">
        <div class="left-panel">
            <div class="login-container">
                

                <h1>Bienvenido</h1>
                <p>Por favor, introduce tu usuario y contraseña.</p>

                <?php if($error_mensaje != ""): ?>
                    <div class="error-message"><?php echo $error_mensaje; ?></div>
                <?php endif; ?>

                <?php if($info_mensaje != ""): ?>
                    <div class="info-message"><?php echo $info_mensaje; ?></div>
                <?php endif; ?>

                <form method="POST" action="login.php">
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" name="usuario" placeholder="ej: admin" required>
                    </div>

                    <div class="form-group">
                        <label>Contraseña</label>
                        <input type="password" name="password" placeholder="••••••••" required>
                    </div>

                    <a href="index.php?forgot=1" class="forgot-link">¿Olvidaste tu contraseña?</a>

                    <button type="submit" class="btn-submit">Acceder</button>
                </form>

            </div>
        </div>
        <div class="right-panel"></div>
    </div>

</body>
</html>