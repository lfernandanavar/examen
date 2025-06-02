<!-- resources/views/reservations.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <title>Búsqueda de Vuelos</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Búsqueda de Vuelos</h1>

    <form id="searchForm">
        <label>Origen: <input type="text" name="origen" /></label><br/>
        <label>Destino: <input type="text" name="destino" /></label><br/>
        <label>Fecha Salida: <input type="date" name="fechaSalida" /></label><br/>
        <button type="submit">Buscar</button>
    </form>

    <h2>Resultados</h2>
    <div id="results"></div>

    <script>
        $(document).ready(function() {
            $('#searchForm').submit(function(e) {
                e.preventDefault();

                let data = {
                    origen: $('input[name=origen]').val(),
                    destino: $('input[name=destino]').val(),
                    fechaSalida: $('input[name=fechaSalida]').val(),
                };

                $.ajax({
                    url: 'http://localhost:3000/api/vuelos',
                    method: 'GET',
                    data: data,
                    success: function(vuelos) {
                        if (vuelos.length === 0) {
                            $('#results').html('<p>No se encontraron vuelos.</p>');
                            return;
                        }

                        let html = '<table border="1" cellpadding="5"><thead><tr><th>Vuelo</th><th>Origen</th><th>Destino</th><th>Salida</th><th>Llegada</th><th>Costo</th><th>Reservar</th></tr></thead><tbody>';

                        vuelos.forEach(function(vuelo) {
                            html += `<tr>
                                <td>${vuelo.numeroVuelo}</td>
                                <td>${vuelo.origen}</td>
                                <td>${vuelo.destino}</td>
                                <td>${new Date(vuelo.salida).toLocaleString()}</td>
                                <td>${new Date(vuelo.llegada).toLocaleString()}</td>
                                <td>${vuelo.costo}</td>
                                <td><button class="btn-reservar" data-vuelo='${JSON.stringify(vuelo)}'>Reservar</button></td>
                            </tr>`;
                        });

                        html += '</tbody></table>';

                        $('#results').html(html);
                    },
                    error: function(err) {
                        $('#results').html('<p>Error al buscar vuelos.</p>');
                    }
                });
            });

            $('#results').on('click', '.btn-reservar', function() {
                let vuelo = $(this).data('vuelo');

                let reservacion = {
                    idUsuario: 'user123',
                    nombreCompleto: 'Nombre Usuario',
                    correoElectronico: 'usuario@ejemplo.com',
                    numeroVuelo: vuelo.numeroVuelo,
                    numeroReservacion: 'RES' + Math.floor(Math.random() * 10000),
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
                    data: JSON.stringify(reservacion),
                    success: function(res) {
                        alert('Reservación realizada con éxito');
                    },
                    error: function(err) {
                        alert('Error al reservar');
                    }
                });
            });
        });
    </script>
</body>
</html>
