var oXML; 

function AJAXCrearObjeto() {
    var obj;
    if (window.XMLHttpRequest) {
        obj = new XMLHttpRequest();
    } else {
        try {
            obj = new ActiveXObject("Microsoft.XMLHTTP");
        } catch (e) {
            alert('El navegador utilizado no está soportado');
        }
    }
    return obj;
}

// FASE 1: Cargar los números de facturas al elegir Matrícula
function cargarFacturas(matricula) {
    if (matricula == "") {
        document.getElementById('select-factura').innerHTML = '<option value="">Esperando matrícula...</option>';
        return;
    }

    oXML = AJAXCrearObjeto();
    oXML.open('POST', 'get_facturas.php');
    oXML.onreadystatechange = function() {
        if (oXML.readyState == 4 && oXML.status == 200) {
            var xml = oXML.responseXML.documentElement;
            var selectFactura = document.getElementById('select-factura');
            
            selectFactura.innerHTML = '<option value="">Seleccione factura...</option>';

            var lista = xml.getElementsByTagName('factura');
            for (var i = 0; i < lista.length; i++) {
                var num = lista[i].getElementsByTagName('numero')[0].firstChild.data;
                
                var option = document.createElement('option');
                option.value = num;
                option.text = "Factura #" + num;
                selectFactura.add(option);
            }
        }
    };
    oXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    oXML.send('matricula=' + matricula);
}

// FASE 2: Mostrar la tabla detallada al elegir la Factura
function mostrarDetalleFactura(idFactura) {
    if (idFactura == "") return;

    oXML = AJAXCrearObjeto();
    oXML.open('POST', 'get_detalle_factura.php');
    
    oXML.onreadystatechange = function() {
        if (oXML.readyState == 4 && oXML.status == 200) {
            var xml = oXML.responseXML.documentElement;
            var divDestino = document.getElementById('detalle-factura');
            
            // Ajustamos las clases de la tabla para que herede el estilo de AdminHub
            var tablaHtml = "<div class='order'><table style='width:100%;'><thead><tr><th>Servicio</th><th>Precio</th></tr></thead><tbody>";
            
            var lineas = xml.getElementsByTagName('linea');
            for (var i = 0; i < lineas.length; i++) {
                var desc = lineas[i].getElementsByTagName('descripcion')[0].firstChild.data;
                var precio = lineas[i].getElementsByTagName('precio')[0].firstChild.data;
                
                // Usamos la estructura de celdas del nuevo CSS
                tablaHtml += "<tr><td><p>"+desc+"</p></td><td><span class='status completed'>"+precio+"€</span></td></tr>";
            }
            
            tablaHtml += "</tbody></table></div>";
            divDestino.innerHTML = tablaHtml;
        }
    };
    oXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    oXML.send('id_factura=' + idFactura);
}