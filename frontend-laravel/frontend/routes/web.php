<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConfirmacionReservacion;

Route::get('/', function () {
    return view('welcome');
});

// Ruta para el formulario de búsqueda de vuelos (pública)
Route::get('/reservations/search', [ReservationController::class, 'searchForm'])->name('reservations.searchForm');

// Ruta para buscar vuelos (consume backend NodeJS) — se puede llamar con AJAX
Route::post('/reservations/search', [ReservationController::class, 'searchFlights'])->name('reservations.searchFlights');

// Grupo para rutas protegidas (usuario autenticado)
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/reservations/search', function () {
    return view('reservations');

    Route::get('/reservations/search', function () {
    return view('reservations');

    Route::post('/enviar-reservacion', function (Illuminate\Http\Request $request) {
    $data = $request->all();

    // 1. Enviar a Node.js
    $response = Http::post('http://localhost:3000/api/reservaciones', $data);

    // 2. Si Node.js respondió bien, enviar correo
    if ($response->successful()) {
        Mail::to($data['correoElectronico'])->send(new ConfirmacionReservacion($data));
        return response()->json(['mensaje' => 'Reservación completada y correo enviado']);
    } else {
        return response()->json(['mensaje' => 'Error en el backend Node.js'], 500);
    }
});
});

});

    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');


    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';









