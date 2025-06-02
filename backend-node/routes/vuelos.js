const express = require('express');
const router = express.Router();
const Vuelo = require('../models/Vuelo');

// GET /api/vuelos?origen=CDMX&destino=Cancun&fechaSalida=2025-06-01
router.get('/', async (req, res) => {
  try {
    const { origen, destino, fechaSalida } = req.query;

    let filtros = {};

    if (origen) {
      filtros.origen = { $regex: new RegExp(origen, 'i') };
    }

    if (destino) {
      filtros.destino = { $regex: new RegExp(destino, 'i') };
    }

    if (fechaSalida) {
      // Buscar vuelos cuya fecha de salida sea ese día
      const inicio = new Date(fechaSalida);
      const fin = new Date(fechaSalida);
      fin.setHours(23, 59, 59, 999);

      filtros.salida = { $gte: inicio, $lte: fin };
    }

    const vuelos = await Vuelo.find(filtros);
    res.json(vuelos);
  } catch (error) {
    res.status(500).json({ mensaje: 'Error al obtener vuelos', error });
  }
});

module.exports = router;
