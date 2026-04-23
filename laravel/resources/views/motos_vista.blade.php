<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Directorio de Motos</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Estilos Generales */
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex; height: 100vh; overflow: hidden; color: #1F2937; }
        
        /* Área del Dashboard (Derecha) */
        .main-content { flex: 1; display: flex; flex-direction: column; overflow: hidden; }
        
        /* Cabecera y Barra de Búsqueda */
        .top-header { padding: 2.5rem 3rem 1.5rem 3rem; display: flex; justify-content: space-between; align-items: center; }
        .top-header h1 { margin: 0; font-size: 1.8rem; color: #1F2937; }
        .search-container { display: flex; align-items: center; background: #ffffff; padding: 0.6rem 1.2rem; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.02); width: 350px; border: 1px solid #E5E7EB; }
        .search-container input { border: none; outline: none; width: 100%; font-family: 'Poppins', sans-serif; font-size: 0.95rem; color: #4B5563; margin-left: 10px; }
        
        /* Contenedor de la Tabla */
        .dashboard-area { padding: 0 3rem 2rem 3rem; overflow-y: auto; flex: 1; }
        .table-container { background: #ffffff; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); padding: 1rem 2rem; }
        
        table { width: 100%; border-collapse: collapse; text-align: left; }
        th { padding: 1.2rem 1rem; border-bottom: 2px solid #F3F4F6; color: #6B7280; font-weight: 600; font-size: 0.85rem; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 1.2rem 1rem; border-bottom: 1px solid #F3F4F6; color: #374151; font-size: 0.95rem; font-weight: 500; }
        tr:last-child td { border-bottom: none; }
        tr:hover { background-color: #F9FAFB; transition: 0.2s; }
        
        /* La "Píldora" azul de la matrícula */
        .pill { background-color: #3B82F6; color: white; padding: 0.4rem 1rem; border-radius: 999px; font-size: 0.8rem; font-weight: 600; box-shadow: 0 2px 4px rgba(59, 130, 246, 0.3); }
    </style>
</head>
<body>

    @include('sidebar')

    <div class="main-content">
        
        <div class="top-header">
            <h1>Directorio de Motocicletas</h1>
            
            <div class="search-container">
                🔍 <input type="text" id="buscador" placeholder="Buscar por marca, modelo o color...">
            </div>
        </div>

        <div class="dashboard-area">
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Marca</th>
                            <th>Modelo</th>
                            <th>Color</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-motos">
                        @foreach ($motos as $moto)
                        <tr>
                            <td><span class="pill">{{ $moto->Matricula }}</span></td>
                            <td>{{ $moto->Marca }}</td>
                            <td>{{ $moto->Modelo }}</td>
                            <td>{{ $moto->Color }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        document.getElementById('buscador').addEventListener('keyup', function() {
            let filtro = this.value.toLowerCase();
            let filas = document.querySelectorAll('#tabla-motos tr');
            
            filas.forEach(fila => {
                let textoFila = fila.innerText.toLowerCase();
                if(textoFila.includes(filtro)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    </script>
</body>
</html>