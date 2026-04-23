<!DOCTYPE html>
<html lang="es">
<head>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        /* 1. LAYOUT PRINCIPAL (Obligatorio para que no se aplaste) */
        body { 
            margin: 0; 
            font-family: 'Poppins', sans-serif; 
            background-color: #F3F4F6; 
            display: flex !important; /* El secreto de las dos columnas */
            height: 100vh; 
            overflow: hidden; 
        }

        .main-content { 
            flex: 1; 
            overflow-y: auto; 
            padding: 2rem 3rem; 
        }

        /* 2. ESTILOS DEL SIDEBAR BLINDADOS */
        .sidebar-master {
            width: 250px;
            min-width: 250px;
            background-color: #ffffff;
            box-shadow: 2px 0 15px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            height: 100vh;
            z-index: 9999;
        }
        
        .sidebar-master a { text-decoration: none !important; }
        .sidebar-master ul, .sidebar-master li { list-style: none !important; display: none !important; margin: 0; padding: 0; }

        .sidebar-header { 
            padding: 1.5rem; font-size: 1.4rem; font-weight: 700; color: #2596be; 
            display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #F3F4F6; margin-bottom: 1rem; 
        }

        .sidebar-item { 
            padding: 0.9rem 1.5rem; display: flex; align-items: center; gap: 15px; 
            color: #6B7280; font-weight: 500; transition: all 0.2s; 
            margin: 0 0.8rem 0.3rem 0.8rem; border-radius: 8px; 
        }

        .sidebar-item i { font-size: 1.3rem; }
        .sidebar-item:hover { background-color: #F9FAFB; color: #2596be; }
        .sidebar-item.active { background-color: #E0F2FE; color: #0284C7; font-weight: 600; }
        .logout-btn { margin-top: auto; margin-bottom: 1.5rem; color: #EF4444 !important; }
        
        /* Tus otros estilos del dashboard debajo... */
    </style>
</head>
<body>

    @include('sidebar')

    <div class="main-content">
        
        <div class="top-header">
            <h1>Panel de Control</h1>
            <div class="header-actions">
                <div class="date-badge">
                    <i class='bx bx-calendar'></i> {{ date('d / m / Y') }}
                </div>
                <a href="#" class="btn-download">
                    <i class='bx bxs-cloud-download'></i> Reporte Mensual
                </a>
            </div>
        </div>

        <div class="cards-grid">
            <div class="card">
                <div class="card-icon icon-blue"><i class='bx bxs-dollar-circle'></i></div>
                <div class="card-info">
                    <h3>${{ number_format($total_ventas, 2) }}</h3>
                    <p>Ventas Totales</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-icon icon-purple"><i class='bx bxs-group'></i></div>
                <div class="card-info">
                    <h3>{{ $total_clientes }}</h3>
                    <p>Clientes Registrados</p>
                </div>
            </div>
            
            <div class="card">
                <div class="card-icon icon-orange"><span class="material-symbols-outlined">two_wheeler</span></div>
                <div class="card-info">
                    <h3>{{ $total_motos }}</h3>
                    <p>Motos en Taller</p>
                </div>
            </div>
        </div>

        <div class="bottom-grid">
            
            <div class="panel">
                <h3>Facturas Recientes</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Matrícula</th>
                            <th>Fecha Emisión</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recientes as $factura)
                        <tr>
                            <td><b>{{ $factura->Matricula }}</b></td>
                            <td>{{ $factura->Fecha_Emision }}</td>
                            <td><span class="price-tag">${{ number_format($factura->Total, 2) }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: #9CA3AF;">No hay facturas registradas.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="panel">
                <h3>Explorador Rápido</h3>
                
                <label class="text-muted">1. Seleccione Matrícula:</label>
                <select id="select-matricula" onchange="cargarFacturas(this.value)" class="custom-select">
                    <option value="">Buscar moto...</option>
                    @foreach($motos_list as $moto)
                        <option value="{{ $moto->Matricula }}">{{ $moto->Matricula }}</option>
                    @endforeach
                </select>

                <label class="text-muted">2. Número de Factura:</label>
                <select id="select-factura" onchange="mostrarDetalleFactura(this.value)" class="custom-select">
                    <option value="">Esperando matrícula...</option>
                </select>
            </div>

        </div>

    </div>

    <script>
        // Funciones preparadas para el futuro (AJAX)
        function cargarFacturas(matricula) {
            if (!matricula) return;
            console.log("Simulando carga de facturas para: " + matricula);
            // Aquí en el futuro puedes hacer una llamada fetch() a Laravel
        }
        function mostrarDetalleFactura(id) {
            console.log("Mostrando factura: " + id);
        }
    </script>
</body>
</html>