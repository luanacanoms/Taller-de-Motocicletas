<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducir Motocicleta - MotoTaller</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex; height: 100vh; }
        .main-content { flex: 1; padding: 3rem; overflow-y: auto; }
        .form-container { background: white; padding: 2rem; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); max-width: 600px; margin: 0 auto; }
        .form-group { margin-bottom: 1.2rem; }
        .form-group label { display: block; font-weight: 500; color: #374151; margin-bottom: 0.5rem; }
        .form-group input { width: 100%; padding: 0.8rem; border: 1px solid #D1D5DB; border-radius: 8px; box-sizing: border-box; font-family: 'Poppins'; }
        .btn-submit { width: 100%; background: #2596be; color: white; padding: 1rem; border: none; border-radius: 8px; font-weight: 600; font-size: 1.1rem; cursor: pointer; margin-top: 1rem; }
        .btn-submit:hover { background: #1e7a9b; }
        .alert-success { background: #DCFCE7; color: #166534; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem; text-align: center; font-weight: 600; }
    </style>
</head>
<body>

    <div class="main-content">
        <div class="form-container">
            <a href="javascript:history.back()" style="display: inline-block; margin-bottom: 1.5rem; color: #6B7280; text-decoration: none; font-weight: 500;">
    <i class='bx bx-arrow-back'></i> Volver 
</a>
            <h2 style="margin-top: 0; color: #111827; text-align: center;"><i class='bx bx-plus-circle'></i> Registrar Nueva Motocicleta</h2>
            
            @if(session('exito'))
                <div class="alert-success">
                    <i class='bx bx-check-circle'></i> {{ session('exito') }}
                </div>
            @endif

            <form action="{{ url('guardar_motocicleta') }}" method="POST">
                @csrf <div class="form-group">
                    <label>Matrícula</label>
                    <input type="text" name="matricula" placeholder="Ej: 1234-ABC" required>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div class="form-group" style="flex: 1;">
                        <label>Marca</label>
                        <input type="text" name="marca" placeholder="Ej: Honda" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Modelo</label>
                        <input type="text" name="modelo" placeholder="Ej: CBR 600" required>
                    </div>
                </div>

                <div style="display: flex; gap: 1rem;">
                    <div class="form-group" style="flex: 1;">
                        <label>Año</label>
                        <input type="number" name="anyo" placeholder="Ej: 2021" required>
                    </div>
                    <div class="form-group" style="flex: 1;">
                        <label>Color</label>
                        <input type="text" name="color" placeholder="Ej: Rojo" required>
                    </div>
                </div>

                <div class="form-group">
                    <label>ID del Cliente (Dueño)</label>
                    <input type="number" name="id_cliente" placeholder="ID numérico del cliente en la base de datos" required>
                </div>

                <button type="submit" class="btn-submit">Guardar Motocicleta</button>
            </form>
        </div>
    </div>

</body>
</html>