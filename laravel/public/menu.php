<?php
session_start();

// 1. SEGURIDAD
if (!isset($_SESSION['autenticado']) || $_SESSION['autenticado'] !== "SI") {
    header("Location: ./"); 
    exit();
}

// 2. CONEXIÓN
require_once("conexion.php"); 

// 3. CONSULTAS 
$query_ventas = mysqli_query($conexion, "SELECT SUM(Total) as total_ventas FROM facturas");
$dato_ventas = mysqli_fetch_assoc($query_ventas);
$total_ventas = $dato_ventas['total_ventas'] ?? 0;

$query_clientes = mysqli_query($conexion, "SELECT COUNT(*) as total_clientes FROM clientes");
$dato_clientes = mysqli_fetch_assoc($query_clientes);
$total_clientes = $dato_clientes['total_clientes'] ?? 0;

$query_motos = mysqli_query($conexion, "SELECT COUNT(*) as total_motos FROM motocicletas");
$dato_motos = mysqli_fetch_assoc($query_motos);
$total_motos = $dato_motos['total_motos'] ?? 0;

$query_repuestos = mysqli_query($conexion, "SELECT COUNT(*) as total_repuestos FROM repuestos");
$dato_repuestos = mysqli_fetch_assoc($query_repuestos);
$total_repuestos = $dato_repuestos['total_repuestos'] ?? 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotoTaller - Panel de Control</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root { --blue: #2596be; --light-blue: #E0F2FE; --grey: #F9FAFB; --dark: #1F2937; --text-grey: #6B7280; }
        body { margin: 0; font-family: 'Poppins', sans-serif; background-color: #F3F4F6; display: flex; height: 100vh; overflow: hidden; }
        #content { flex: 1; display: flex; flex-direction: column; overflow-y: auto; }
        main { padding: 2rem 3rem; }
        .box-info { display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 1.5rem; list-style: none; padding: 0; margin: 2rem 0; }
        .box-info li { background: white; padding: 1.5rem; border-radius: 16px; display: flex; align-items: center; gap: 1.5rem; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        .box-info li i { width: 80px; height: 80px; border-radius: 12px; background: var(--light-blue); font-size: 36px; display: flex; justify-content: center; align-items: center; color: var(--blue); }
        .box-info li .text h3 { margin: 0; font-size: 1.7rem; font-weight: 700; }
        .box-info li .text p { margin: 0; color: var(--text-grey); font-size: 0.9rem; }
        .table-data { display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem; }
        .order, .todo { background: white; padding: 1.5rem; border-radius: 16px; box-shadow: 0 4px 6px rgba(0,0,0,0.02); }
        table { width: 100%; border-collapse: collapse; }
        th { text-align: left; padding: 1rem; border-bottom: 2px solid #F3F4F6; color: var(--text-grey); font-size: 0.8rem; }
        td { padding: 1rem; border-bottom: 1px solid #F3F4F6; font-size: 0.9rem; }
        .status.completed { background: #DCFCE7; color: #166534; padding: 4px 10px; border-radius: 20px; font-weight: 600; font-size: 0.8rem; }
    </style>
</head>
<body>

    <?php include_once("sidebar.php"); ?>

    <section id="content">
        <main>
            <div class="main-header" style="display: flex; justify-content: space-between; align-items: center;">
                <h1>Panel de Control</h1>
                <div class="date-filter" style="background: white; padding: 10px 20px; border-radius: 12px; box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                    <i class='bx bx-calendar'></i>
                    <span><?php echo date('d/m/Y'); ?></span>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-dollar-circle'></i>
                    <span class="text">
                        <h3>$<?php echo number_format($total_ventas, 2); ?></h3>
                        <p>Ventas Totales</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-group'></i>
                    <span class="text">
                        <h3><?php echo $total_clientes; ?></h3>
                        <p>Clientes Registrados</p>
                    </span>
                </li>
                <li>
                    <i><span class="material-symbols-outlined" style="font-size: 40px;">two_wheeler</span></i>
                    <span class="text">
                        <h3><?php echo $total_motos; ?></h3>
                        <p>Motos en Taller</p>
                    </span>
                </li>
            </ul>

            <div class="table-data">
                <div class="order">
                    <div class="head"><h3>Facturas Recientes</h3></div>
                    <table>
                        <thead>
                            <tr>
                                <th>Matrícula</th>
                                <th>Fecha Emisión</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $recientes = mysqli_query($conexion, "SELECT * FROM facturas ORDER BY Fecha_Emision DESC LIMIT 5");
                            while($f = mysqli_fetch_assoc($recientes)) {
                                echo "<tr>
                                    <td><b>{$f['Matricula']}</b></td>
                                    <td>{$f['Fecha_Emision']}</td>
                                    <td><span class='status completed'>$".number_format($f['Total'], 2)."</span></td>
                                </tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <div class="todo">
                    <div class="head"><h3>Explorador Rápido</h3></div>
                    <div style="padding: 10px;">
                        
                        <p style="font-size: 13px; color: var(--text-grey);">1. Seleccione Matrícula:</p>
                        <select id="select-matricula" onchange="cargarFacturas(this.value)" style="width:100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                            <option value="">Buscar moto...</option>
                            <?php
                            $motos_list = mysqli_query($conexion, "SELECT DISTINCT Matricula FROM facturas");
                            while($m = mysqli_fetch_assoc($motos_list)) echo "<option value='".$m['Matricula']."'>".$m['Matricula']."</option>";
                            ?>
                        </select>
                        
                        <p style="font-size: 13px; color: var(--text-grey); margin-top: 20px;">2. Número de Factura:</p>
                        <select id="select-factura" onchange="mostrarDetalleFactura(this.value)" class="custom-select" style="width:100%; padding: 10px; border-radius: 8px; border: 1px solid #ddd;">
                            <option value="">Esperando matrícula...</option>
                        </select>

                        <div id="tabla-detalles-ajax"></div>
                        
                    </div>
                </div>
            </div>
        </main>
    </section>

    <script>
        // 1. Crear el objeto AJAX
        function AJAXCrearObjeto(){
            var obj;
            if (window.XMLHttpRequest) { obj = new XMLHttpRequest(); } 
            else {
                try { obj = new ActiveXObject("Microsoft.XMLHTTP"); }
                catch (e) { alert('El navegador utilizado no está soportado'); }
            }
            return obj;
        }

        // 2. Pedir las facturas de una moto
        function cargarFacturas(matricula) {
            if (!matricula) return;
            
            var oXML = AJAXCrearObjeto();
            oXML.open('POST', 'get_facturas.php');
            oXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            oXML.onreadystatechange = function() {
                if (oXML.readyState == 4 && oXML.status == 200) {
                    var xml = oXML.responseXML.documentElement;
                    var selectFactura = document.getElementById('select-factura');
                    
                    selectFactura.innerHTML = '<option value="">Seleccione Factura...</option>';
                    
                    var facturasXML = xml.getElementsByTagName('factura');
                    for (var i = 0; i < facturasXML.length; i++) {
                        var num = facturasXML[i].getElementsByTagName('numero')[0].firstChild.data;
                        selectFactura.innerHTML += '<option value="'+num+'">Factura Nº '+num+'</option>';
                    }
                }
            };
            oXML.send('matricula=' + matricula);
        }

        // 3. Pedir el detalle de la factura seleccionada
        function mostrarDetalleFactura(numFactura) {
            if (!numFactura) return;
            
            var oXML = AJAXCrearObjeto();
            oXML.open('POST', 'get_detalle_factura.php');
            oXML.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            
            oXML.onreadystatechange = function() {
                if (oXML.readyState == 4 && oXML.status == 200) {
                    var xml = oXML.responseXML.documentElement;
                    var contenedorDiv = document.getElementById('tabla-detalles-ajax');
                    
                    var html = '<table style="width:100%; border-collapse: collapse; margin-top: 15px; font-size: 0.85rem;">';
                    html += '<tr style="background:#E0F2FE;"><th>Ref</th><th>Descripción</th><th>Uds</th><th>Importe</th></tr>';
                    
                    var detallesXML = xml.getElementsByTagName('detalle');
                    if(detallesXML.length === 0) {
                        contenedorDiv.innerHTML = '<p style="color:#EF4444; font-size:0.85rem; margin-top:10px;">Sin detalles registrados.</p>';
                        return;
                    }

                    for (var i = 0; i < detallesXML.length; i++) {
                        var item = detallesXML[i];
                        var ref = item.getElementsByTagName('referencia')[0].firstChild.data;
                        var desc = item.getElementsByTagName('descripcion')[0].firstChild.data;
                        var uds = item.getElementsByTagName('unidades')[0].firstChild.data;
                        var imp = item.getElementsByTagName('importe')[0].firstChild.data;
                        
                        html += '<tr>';
                        html += '<td style="padding:6px; border-bottom:1px solid #eee;">'+ref+'</td>';
                        html += '<td style="padding:6px; border-bottom:1px solid #eee;">'+desc+'</td>';
                        html += '<td style="padding:6px; border-bottom:1px solid #eee; text-align:center;">'+uds+'</td>';
                        html += '<td style="padding:6px; border-bottom:1px solid #eee; color:#0284C7; font-weight:bold;">'+imp+'€</td>';
                        html += '</tr>';
                    }
                    html += '</table>';
                    contenedorDiv.innerHTML = html;
                }
            };
            oXML.send('factura=' + numFactura);
        }
    </script>
</body>
</html>