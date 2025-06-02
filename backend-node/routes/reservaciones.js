const express = require('express');
const router = express.Router();
const Reservacion = require('../models/Reservacion');

// Registrar una nueva reservación
router.post('/', async (req, res) => {
  try {
    const {
      idUsuario,
      nombreCompleto,
      correoElectronico,
      numeroVuelo,
      numeroReservacion,
      origen,
      destino,
      fechaHoraPartida,
      fechaHoraLlegada,
      costo
    } = req.body;

    // Crear nueva reservación
    const nuevaReservacion = new Reservacion({
      idUsuario,
      nombreCompleto,
      correoElectronico,
      numeroVuelo,
      numeroReservacion,
      origen,
      destino,
      fechaHoraPartida,
      fechaHoraLlegada,
      costo
    });

    // Guardar en la base de datos
    await nuevaReservacion.save();

    res.status(201).json({ mensaje: 'Reservación registrada con éxito', reservacion: nuevaReservacion });
  } catch (error) {
    console.error(error);
    res.status(500).json({ mensaje: 'Error al registrar la reservación' });
  }
});

// Consultar todas las reservaciones
router.get('/', async (req, res) => {
  try {
    const reservaciones = await Reservacion.find();
    res.json(reservaciones);
  } catch (error) {
    console.error(error);
    res.status(500).json({ mensaje: 'Error al obtener reservaciones' });
  }
});

module.exports = router;
