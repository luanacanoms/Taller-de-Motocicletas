<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Acceso - Taller de Motocicletas</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* 2. Applying Poppins and softening the background slightly */
        body { 
            background-color: #F3F4F6; 
            display: flex; 
            justify-content: center; 
            align-items: center; 
            min-height: 100vh; 
            margin: 0; 
            font-family: 'Poppins', sans-serif;
        }
        
        .split-screen { 
            display: flex; 
            min-height: 600px; 
            height: 75vh; 
            width: 100%; 
            max-width: 950px; 
            background-color: #ffffff; 
            border-radius: 24px; 
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08); 
            overflow: hidden; 
        }
        
        /* 3. Better Spacing (Padding) for the left panel */
        .left-panel { 
            flex: 1; 
            padding: 3rem 4rem; /* More breathing room on the sides */
            display: flex; 
            flex-direction: column; 
            justify-content: center; 
        }
        
        .right-panel { 
            flex: 0.9; 
            background-image: url('assets/login1.png'); 
            background-size: cover; 
            background-position: center; 
            margin: 1.2rem; /* Slightly softer margin around the image */
            border-radius: 16px; 
        }
        
        .login-container { 
            width: 100%; 
            max-width: 380px; 
            margin: 0 auto; /* Centers the content block */
        }

        /* 4. Beautiful Gray Typography */
        h1 { 
            color: #1F2937; /* Dark elegant gray */
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            margin-top: 0;
        }
        
        p { 
            color: #6B7280; /* Soft gray for subtitle */
            font-size: 0.95rem;
            margin-bottom: 2.5rem; /* Pushes the form down beautifully */
        }
        
        label { 
            display: block; /* Makes spacing predictable */
            color: #4B5563; /* Medium gray */
            font-size: 0.85rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }
        
        /* 5. Inputs with better padding and focus effects */
        input { 
            width: 100%; 
            padding: 0.85rem 1rem; 
            border: 1px solid #D1D5DB; 
            border-radius: 10px; 
            margin-bottom: 1.5rem; 
            font-family: 'Poppins', sans-serif;
            font-size: 0.95rem;
            color: #374151;
            box-sizing: border-box; /* Keeps inputs from breaking out of the container */
            transition: border-color 0.3s ease;
        }
        
        input:focus {
            outline: none;
            border-color: #2596be; /* Highlights blue when typing */
            box-shadow: 0 0 0 3px rgba(37, 150, 190, 0.1);
        }
        
        button { 
            width: 100%; 
            background-color: #2596be; 
            color: white; 
            padding: 0.9rem; 
            border: none; 
            border-radius: 10px; 
            font-weight: 600; 
            font-size: 1rem;
            font-family: 'Poppins', sans-serif;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.1s ease;
            margin-top: 0.5rem;
        }
        
        button:hover {
            background-color: #1c7a9b; /* Slightly darker blue on hover */
        }
        
        button:active {
            transform: scale(0.98); /* Cute click animation */
        }
    </style>
</head>
<body>
    <div class="split-screen">
        <div class="left-panel">
            <div class="login-container">
                <h1>Bienvenido</h1>
                <p>Por favor, introduce tu usuario y contraseña.</p>
                
                <form method="POST" action="validar">
                    @csrf
                    
                    <label>Usuario</label>
                    <input type="text" name="usuario" placeholder="Ej. admin" required>
                    
                    <label>Contraseña</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                    
                    <button type="submit">Acceder</button>
                </form>
            </div>
        </div>
        <div class="right-panel"></div>
    </div>
</body>
</html>