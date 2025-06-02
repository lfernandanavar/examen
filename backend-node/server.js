const express = require('express');
const mongoose = require('mongoose');
const cors = require('cors');
require('dotenv').config();

const vuelosRoutes = require('./routes/vuelos');
const reservacionesRoutes = require('./routes/reservaciones');

const app = express();
app.use(cors());
app.use(express.json());

app.use('/api/vuelos', require('./routes/vuelos'));
app.use('/api/reservaciones', require('./routes/reservaciones'));



mongoose.connect(process.env.MONGODB_URI)
  .then(() => {
    console.log('Conectado a MongoDB');
    app.listen(process.env.PORT, () => {
      console.log(`Servidor corriendo en http://localhost:${process.env.PORT}`);
    });
  })
  .catch(err => console.error('Error al conectar MongoDB', err));


