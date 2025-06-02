<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class ReservationController extends Controller
{
    public function index()
    {
        $client = new Client();

        try {
            $response = $client->request('GET', 'http://localhost:3000/api/reservaciones');
            $reservations = json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            $reservations = [];
        }

        return view('reservations.index', compact('reservations'));
    }
}
