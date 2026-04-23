<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    /* CSS INYECTADO DIRECTAMENTE: NUNCA SE ROMPERÁ */
    .sidebar-master {
        width: 250px;
        min-width: 250px;
        background-color: #ffffff;
        box-shadow: 2px 0 15px rgba(0,0,0,0.05);
        display: flex;
        flex-direction: column;
        height: 100vh;
        z-index: 9999;
        font-family: 'Poppins', sans-serif;
    }
    
    /* Forzamos a que no haya listas ni subrayados */
    .sidebar-master a { text-decoration: none !important; }
    .sidebar-master ul, .sidebar-master li { list-style: none !important; display: none !important; }

    .sidebar-header { 
        padding: 1.5rem; font-size: 1.4rem; font-weight: 700; color: #2596be; 
        display: flex; align-items: center; gap: 12px; border-bottom: 1px solid #F3F4F6; margin-bottom: 1rem; 
    }

    .sidebar-item { 
        padding: 0.9rem 1.5rem; display: flex; align-items: center; gap: 15px; 
        color: #6B7280; font-weight: 500; transition: all 0.2s; 
        margin: 0 0.8rem 0.3rem 0.8rem; border-radius: 8px; 
    }

    .sidebar-item i, .sidebar-item .material-symbols-outlined { font-size: 1.3rem; }
    .sidebar-item:hover { background-color: #F9FAFB; color: #2596be; }
    .sidebar-item.active { background-color: #E0F2FE; color: #0284C7; font-weight: 600; }
    
    .logout-btn { margin-top: auto; margin-bottom: 1.5rem; color: #EF4444 !important; }
    .logout-btn:hover { background-color: #FEF2F2 !important; }
</style>

<div class="sidebar-master">
    <div class="sidebar-header">
        <i class='bx bxs-wrench'></i> MotoTaller
    </div>

    <?php $pagina_actual = basename($_SERVER['PHP_SELF']); ?>

    <a href="menu.php" class="sidebar-item <?= ($pagina_actual == 'menu.php') ? 'active' : '' ?>">
        <i class='bx bxs-dashboard'></i> <span>Dashboard</span>
    </a>

    <a href="listar_clientes.php" class="sidebar-item <?= ($pagina_actual == 'listar_clientes.php') ? 'active' : '' ?>">
        <i class='bx bxs-group'></i> <span>Clientes</span>
    </a>

    <a href="consultas_motos.php" class="sidebar-item <?= ($pagina_actual == 'consultas_motos.php') ? 'active' : '' ?>">
        <i class='bx bx-cycling'></i> <span>Motos</span>
    </a>

    <a href="listar_facturas.php" class="sidebar-item <?= ($pagina_actual == 'listar_facturas.php') ? 'active' : '' ?>">
        <i class='bx bxs-receipt'></i> <span>Facturas</span>
    </a>

    <a href="listar_repuestos.php" class="sidebar-item <?= ($pagina_actual == 'listar_repuestos.php') ? 'active' : '' ?>">
        <i class='bx bxs-cog'></i> <span>Repuestos</span>
    </a>

    <div style="border-top: 1px solid #F3F4F6; margin: 1rem 0;"></div>

    <a href="consultas_facturas.php" class="sidebar-item <?= ($pagina_actual == 'consultas_facturas.php') ? 'active' : '' ?>">
        <i class='bx bxs-report'></i> <span>Reportes</span>
    </a>

    <a href="logout.php" class="sidebar-item logout-btn" onclick="return confirm('¿Seguro que deseas salir?');">
        <i class='bx bx-log-out'></i> <span>Salir</span>
    </a>
</div>