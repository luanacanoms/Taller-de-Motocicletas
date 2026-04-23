/**
 * MOTOTALLER - Lógica de Interfaz y AJAX
 */

// 1. GESTIÓN DEL MENÚ LATERAL (SIDEBAR)
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

if (menuBar && sidebar) {
    menuBar.addEventListener('click', function () {
        sidebar.classList.toggle('hide');
    });
}

// 2. MODO OSCURO (DARK MODE)
const switchMode = document.getElementById('switch-mode');
if (switchMode) {
    switchMode.addEventListener('change', function () {
        if(this.checked) {
            document.body.classList.add('dark');
        } else {
            document.body.classList.remove('dark');
        }
    });
}

// 3. NAVEGACIÓN ACTIVA
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');
allSideMenu.forEach(item => {
    const li = item.parentElement;
    item.addEventListener('click', function () {
        allSideMenu.forEach(i => {
            i.parentElement.classList.remove('active');
        });
        li.classList.add('active');
    });
});

// 4. FUNCIONES AJAX PARA EL TALLER (Facturas)
function cargarFacturas(matricula) {
    const selectFactura = document.getElementById('select-factura');
    const detalleDiv = document.getElementById('detalle-factura');
    
    if (matricula === "") {
        if(selectFactura) selectFactura.innerHTML = '<option value="">Esperando matrícula...</option>';
        if(detalleDiv) detalleDiv.innerHTML = '<p class="text-muted">Seleccione una matrícula para ver los detalles.</p>';
        return;
    }

    // Petición al backend Vanilla
    fetch(`get_facturas.php?matricula=${matricula}`)
        .then(response => response.text())
        .then(data => {
            selectFactura.innerHTML = data;
            detalleDiv.innerHTML = '<p class="text-muted">Ahora seleccione un número de factura.</p>';
        })
        .catch(error => console.error('Error AJAX:', error));
}

function mostrarDetalleFactura(idFactura) {
    const detalleDiv = document.getElementById('detalle-factura');
    if (idFactura === "" || !detalleDiv) return;

    fetch(`get_detalle.php?id=${idFactura}`)
        .then(response => response.text())
        .then(data => {
            detalleDiv.innerHTML = data;
        })
        .catch(error => console.error('Error al cargar detalle:', error));
}

// 5. RESPONSIVE: Adaptación automática del Sidebar
function adjustSidebar() {
    if (sidebar) {
        if(window.innerWidth < 768) {
            sidebar.classList.add('hide');
        } else {
            sidebar.classList.remove('hide');
        }
    }
}

// Ejecutar al cargar y al redimensionar
window.addEventListener('load', adjustSidebar);
window.addEventListener('resize', adjustSidebar);

// 6. BUSCADOR EN TIEMPO REAL (SAAS SEARCH)
const searchInput = document.querySelector('.saas-search-container input');

if (searchInput) {
    searchInput.addEventListener('keyup', function(e) {
        const filter = e.target.value.toLowerCase();
        // Filtra las filas de cualquier tabla activa en la página
        const rows = document.querySelectorAll('table tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(filter) ? '' : 'none';
        });
    });
}

// 7. GESTIÓN DE MODALES (Unificada)
function abrirModal(id) { 
    const modal = document.getElementById(id);
    if(modal) {
        modal.classList.add('active'); 
        // Si usas display:flex para el modal, asegúrate de que el CSS .active lo tenga
        modal.style.display = 'flex'; 
    }
}

function cerrarModal(id) { 
    const modal = document.getElementById(id);
    if(modal) {
        modal.classList.remove('active'); 
        modal.style.display = 'none';
    }
}

// Cerrar modales al hacer clic fuera de la caja (en el overlay)
window.addEventListener('click', function(event) {
    if (event.target.classList.contains('modal-overlay')) {
        event.target.style.display = 'none';
        event.target.classList.remove('active');
    }
});

// --- Funciones para rellenar datos antes de abrir ---

function editarFactura(numFactura, matricula, horas, precio, estado) {
    const fields = {
        'edit_num_factura': numFactura,
        'edit_matricula': matricula,
        'edit_horas': horas,
        'edit_precio': precio,
        'edit_estado': estado
    };

    let allFound = true;
    for (let id in fields) {
        let el = document.getElementById(id);
        if (el) el.value = fields[id];
        else allFound = false;
    }

    if (allFound) abrirModal('modalEditarFactura');
}

function editarMoto(matricula, marca, modelo, anyo, color) {
    const fields = {
        'edit_moto_matricula': matricula,
        'edit_marca': marca,
        'edit_modelo': modelo,
        'edit_anyo': anyo,
        'edit_color': color
    };

    for (let id in fields) {
        let el = document.getElementById(id);
        if (el) el.value = fields[id];
    }
    abrirModal('modalEditarMoto');
}

function abrirModalEditar(id, dni, nombre, apellido1, apellido2, email) {
    const fields = {
        'edit_idCliente': id,
        'edit_dni': dni,
        'edit_nombre': nombre,
        'edit_apellido1': apellido1,
        'edit_apellido2': apellido2,
        'edit_email': email
    };

    for (let id in fields) {
        let el = document.getElementById(id);
        if (el) el.value = fields[id];
    }
    abrirModal('modalEditar');
}