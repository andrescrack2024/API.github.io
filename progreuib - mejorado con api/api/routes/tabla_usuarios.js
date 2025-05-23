const express = require('express');
const router = express.Router();
const conexion = require('../database');

router.get('/usuarios', (req, res) => {
  conexion.query('SELECT * FROM usuarios', (error, resultados) => {
    if (error) throw error;
    res.render('usuarios', { usuarios: resultados });
  });
});

module.exports = router;

