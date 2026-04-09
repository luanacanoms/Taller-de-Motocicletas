<h1>Introducir Nueva Motocicleta</h1>
<form action="{{ url('/guardar_cliente') }}" method="POST">
    @csrf
    <input type="text" name="matricula" placeholder="Matrícula" required>
    <input type="text" name="marca" placeholder="Marca" required>
    <input type="text" name="modelo" placeholder="Modelo" required>
    <input type="number" name="anyo" placeholder="Año" required>
    <input type="text" name="color" placeholder="Color" required>
    <input type="text" name="id_cliente" placeholder="ID del Cliente" required>
    
    <button type="submit">Guardar Cliente</button>
</form>