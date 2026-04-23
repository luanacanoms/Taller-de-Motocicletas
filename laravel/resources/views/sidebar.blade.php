<div class="sidebar-master">
    <div class="sidebar-header">
        <i class='bx bxs-wrench'></i> MotoTaller
    </div>

    <a href="{{ url('menu') }}" class="sidebar-item {{ request()->is('menu') ? 'active' : '' }}">
        <i class='bx bxs-dashboard'></i> <span>Dashboard</span>
    </a>

    <a href="{{ asset('listar_clientes.php') }}" class="sidebar-item">
        <i class='bx bxs-group'></i> <span>Clientes</span>
    </a>

    <a href="{{ asset('consultas_motos.php') }}" class="sidebar-item">
        <i class='bx bx-cycling'></i> <span>Motos</span>
    </a>

    <a href="{{ asset('listar_facturas.php') }}" class="sidebar-item">
        <i class='bx bxs-receipt'></i> <span>Facturas</span>
    </a>

    <a href="{{ asset('listar_repuestos.php') }}" class="sidebar-item">
        <i class='bx bxs-cog'></i> <span>Repuestos</span>
    </a>

    <div style="border-top: 1px solid #F3F4F6; margin: 1rem 0;"></div>

    <a href="{{ asset('consultas_facturas.php') }}" class="sidebar-item">
        <i class='bx bxs-report'></i> <span>Reportes</span>
    </a>

    <a href="{{ asset('logout.php') }}" class="sidebar-item logout-btn" onclick="return confirm('¿Seguro que deseas salir?');">
        <i class='bx bx-log-out'></i> <span>Salir</span>
    </a>
</div>