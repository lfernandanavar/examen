const mongoose = require('mongoose');

const vueloSchema = new mongoose.Schema({
  numeroVuelo: String,
  origen: String,
  destino: String,
  aeropuerto: String,
  salida: Date,
  llegada: Date,
  duracion: String,
  asientosDisponibles: Number
});

module.exports = mongoose.model('Vuelo', vueloSchema);
