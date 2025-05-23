const mysql = require("mysql");
const express = require("express");
const bodyParser = require("body-parser");
const mysqlConexion = require("./conexion");

const usuarios = require("./routes/tabla_usuarios");

var app = express();
app.use(bodyParser.json());

app.use("/usuarios", usuarios);
app.listen(3000);
