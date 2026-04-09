<div class="recent-orders">
    <h2>Detalles de la Motocicleta: {{ $moto->matricula }}</h2>
    
    <table>
        <thead>
            <tr>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Año</th>
                <th>Color</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $moto->marca }}</td>
                <td>{{ $moto->modelo }}</td>
                <td>{{ $moto->anyo }}</td>
                <td>{{ $moto->color }}</td>
            </tr>
        </tbody>
    </table>

    <a href="{{ url('/introducir_cliente') }}" style="display: block; margin-top: 1rem; text-align: center;">
        Volver al formulario
    </a>
</div>