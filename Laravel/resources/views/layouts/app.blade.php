<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>MotoTaller - Admin</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body { 
            display: flex; /* Sidebar a la izquierda, contenido a la derecha */
            margin: 0;
            height: 100vh;
        }
        .main-content { 
            flex: 1; 
            overflow-y: auto; 
            padding: 20px; 
            background: #f3f4f6;
        }
    </style>
</head>
<body>

    @include('partials.sidebar')

    <div class="main-content">
        @yield('content')
    </div>

</body>
</html>