const mongoose = require('mongoose');

const reservacionSchema = new mongoose.Schema({
  idUsuario: { type: String, required: true },
  nombreCompleto: { type: String, required: true },
  correoElectronico: { type: String, required: true },
  numeroVuelo: { type: String, required: true },
  numeroReservacion: { type: String, required: true, unique: true },
  origen: { type: String, required: true },
  destino: { type: String, required: true },
  fechaHoraPartida: { type: Date, required: true },
  fechaHoraLlegada: { type: Date, required: true },
  costo: { type: Number, required: false }
});

module.exports = mongoose.model('Reservacion', reservacionSchema);
