<?php
$conexion = new mysqli("localhost", "root", "", "progreuib");

if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}
?>
