// 1. GESTIÓN DEL MENÚ LATERAL (SIDEBAR)
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

// Función para abrir/cerrar el menú
menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
});

// 2. MODO OSCURO (DARK MODE)
const switchMode = document.getElementById('switch-mode');

// Detectar el cambio en el interruptor de la Navbar
switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
});

// 3. NAVEGACIÓN ACTIVA
const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});

// 4. FUNCIONES AJAX PARA EL TALLER (FUSIONADAS)
// Estas funciones se llaman desde los 'onchange' de tu menu.php

function cargarFacturas(matricula) {
    const selectFactura = document.getElementById('select-factura');
    const detalleDiv = document.getElementById('detalle-factura');
    
    if (matricula === "") {
        selectFactura.innerHTML = '<option value="">Esperando matrícula...</option>';
        detalleDiv.innerHTML = '<p class="text-muted">Seleccione una matrícula para ver los detalles.</p>';
        return;
    }

    // Aquí va tu llamada real a PHP (ejemplo con fetch)
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
    
    if (idFactura === "") return;

    fetch(`get_detalle.php?id=${idFactura}`)
        .then(response => response.text())
        .then(data => {
            detalleDiv.innerHTML = data;
        })
        .catch(error => console.error('Error al cargar detalle:', error));
}

// 5. RESPONSIVE: Cerrar sidebar automáticamente en pantallas pequeñas
if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
}

window.addEventListener('resize', function () {
	if(this.innerWidth < 768) {
		sidebar.classList.add('hide');
	} else {
		sidebar.classList.remove('hide');
	}
});