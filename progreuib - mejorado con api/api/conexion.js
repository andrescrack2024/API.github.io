const mysql = require("mysql");

const mysqlConexion = mysql.createConnection({
    host: "localhost",
    user: "root",
    password: "",
    database: "progreuib",
    multipleStatements: true
});

mysqlConexion.connect((err) => {
    if (!err) {
        console.log("Estoy conectado a la base de datos Mysql");
    } else {
        console.log("No estoy conectado. Error");
    }
});

module.exports = mysqlConexion;
