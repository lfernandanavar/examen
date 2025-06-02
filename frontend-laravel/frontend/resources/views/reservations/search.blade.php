@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Buscar Vuelos</h2>
    <form id="searchForm">
        @csrf
        <div class="row mb-3">
            <div class="col">
                <label for="origin" class="form-label">Origen</label>
                <input type="text" class="form-control" name="origin" id="origin" required>
            </div>
            <div class="col">
                <label for="destination" class="form-label">Destino</label>
                <input type="text" class="form-control" name="destination" id="destination" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <label for="departureDate" class="form-label">Fecha de Salida</label>
                <input type="date" class="form-control" name="departureDate" id="departureDate" required>
            </div>
            <div class="col">
                <label for="returnDate" class="form-label">Fecha de Regreso</label>
                <input type="date" class="form-control" name="returnDate" id="returnDate">
            </div>
        </div>

        <div class="mb-3">
            <label for="passengers" class="form-label">Número de Pasajeros</label>
            <input type="number" class="form-control" name="passengers" id="passengers" min="1" value="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Buscar Vuelos</button>
    </form>

    <div class="mt-4" id="results">
        {{-- Aquí se mostrarán los resultados --}}
    </div>
</div>
@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    $('#searchForm').submit(function(e) {
        e.preventDefault(); // evitar recarga

        // Obtener valores
        const origen = $('#origin').val();
        const destino = $('#destination').val();
        const fechaSalida = $('#departureDate').val();

        // Llamar al backend Node.js para buscar vuelos
        $.ajax({
            url: 'http://localhost:3000/api/vuelos',
            method: 'GET',
            data: { origen, destino, fechaSalida },
            success: function(vuelos) {
                // Mostrar resultados
                let html = '';
                if (vuelos.length === 0) {
                    html = '<p>No se encontraron vuelos.</p>';
                } else {
                    html += '<table class="table table-bordered">';
                    html += '<thead><tr><th>Vuelo</th><th>Origen</th><th>Destino</th><th>Salida</th><th>Llegada</th><th>Costo</th><th>Reservar</th></tr></thead><tbody>';

                    vuelos.forEach(vuelo => {
                        html += `<tr>
                            <td>${vuelo.numeroVuelo}</td>
                            <td>${vuelo.origen}</td>
                            <td>${vuelo.destino}</td>
                            <td>${new Date(vuelo.salida).toLocaleString()}</td>
                            <td>${new Date(vuelo.llegada).toLocaleString()}</td>
                            <td>${vuelo.costo}</td>
                            <td><button class="btn btn-success btn-sm reservar-btn" data-vuelo='${JSON.stringify(vuelo)}'>Reservar</button></td>
                        </tr>`;
                    });

                    html += '</tbody></table>';
                }

                $('#results').html(html);
            },
            error: function(xhr, status, error) {
                $('#results').html('<p>Error al buscar vuelos.</p>');
                console.error(error);
            }
        });
    });

    // Delegación de evento para botones reservar generados dinámicamente
    $('#results').on('click', '.reservar-btn', function() {
        const vuelo = $(this).data('vuelo');
        // Aquí muestras un formulario modal o confirmas y haces POST para reservar

        // Por ejemplo, simple confirm:
        if (confirm(`¿Deseas reservar el vuelo ${vuelo.numeroVuelo} de ${vuelo.origen} a ${vuelo.destino}?`)) {
            // Datos que enviarás a backend reservaciones
            const reservaData = {
                idUsuario: 'user123',  // Aquí puedes poner el usuario actual, por ejemplo
                nombreCompleto: 'Nombre Usuario',
                correoElectronico: 'usuario@example.com',
                numeroVuelo: vuelo.numeroVuelo,
                numeroReservacion: 'RES' + Math.floor(Math.random()*10000),
                origen: vuelo.origen,
                destino: vuelo.destino,
                fechaHoraPartida: vuelo.salida,
                fechaHoraLlegada: vuelo.llegada,
                costo: vuelo.costo
            };

            $.ajax({
                url: 'http://localhost:3000/api/reservaciones',
                method: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(reservaData),
                success: function(response) {
                    alert('Reservación exitosa');
                },
                error: function(xhr, status, error) {
                    alert('Error al reservar vuelo');
                    console.error(error);
                }
            });
        }
    });
});
</script>
@endsection
