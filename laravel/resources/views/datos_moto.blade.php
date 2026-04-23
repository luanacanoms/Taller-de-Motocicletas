<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Técnica - MotoTaller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { 
            margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; 
            display: flex; justify-content: center; align-items: center; height: 100vh; 
        }
        .ficha-card { 
            background: white; padding: 3rem; border-radius: 16px; 
            box-shadow: 0 10px 25px rgba(0,0,0,0.05); text-align: center; min-width: 350px; 
        }
        .matricula-badge { 
            background: #E0F2FE; color: #0284C7; font-size: 2rem; font-weight: 700; 
            padding: 10px 20px; border-radius: 8px; display: inline-block; margin-bottom: 1.5rem; 
        }
        .dato-row { 
            display: flex; justify-content: space-between; border-bottom: 1px solid #F3F4F6; 
            padding: 12px 0; font-size: 1.1rem; color: #4B5563; 
        }
        .dato-row b { color: #111827; }
        .btn-volver { 
            display: inline-block; margin-top: 2rem; padding: 12px 25px; 
            background: #2596be; color: white; text-decoration: none; border-radius: 8px; font-weight: 600; 
        }
    </style>
</head>
<body>

    <div class="ficha-card">
        <h2 style="margin-top: 0; color: #6B7280; font-weight: 500; font-size: 1.2rem;">Detalles de la Motocicleta</h2>
        <div class="matricula-badge">{{ $moto->Matricula }}</div>
        
        <div class="dato-row"><b>Marca:</b> <span>{{ $moto->Marca }}</span></div>
        <div class="dato-row"><b>Modelo:</b> <span>{{ $moto->Modelo }}</span></div>
        <div class="dato-row"><b>Año:</b> <span>{{ $moto->Anyo }}</span></div>
        <div class="dato-row"><b>Color:</b> <span>{{ $moto->Color }}</span></div>
        <div class="dato-row"><b>ID Propietario:</b> <span>{{ $moto->Id_Cliente }}</span></div>

        <button onclick="window.history.back()" class="btn-volver" style="border: none; cursor: pointer;">
            <i class='bx bx-arrow-back'></i> Volver a la Búsqueda
        </button>
    </div>

</body>
</html>