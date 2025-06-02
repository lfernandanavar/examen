<h1>Reservación Confirmada</h1>
<p>Hola {{ $datos['nombreCompleto'] }}, tu vuelo ha sido reservado con éxito.</p>

<ul>
    <li><strong>Vuelo:</strong> {{ $datos['numeroVuelo'] }}</li>
    <li><strong>Origen:</strong> {{ $datos['origen'] }}</li>
    <li><strong>Destino:</strong> {{ $datos['destino'] }}</li>
    <li><strong>Salida:</strong> {{ $datos['fechaHoraPartida'] }}</li>
    <li><strong>Llegada:</strong> {{ $datos['fechaHoraLlegada'] }}</li>
    <li><strong>Costo:</strong> ${{ $datos['costo'] }}</li>
</ul>
