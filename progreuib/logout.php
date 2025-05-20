<?php
session_start();

// Destruir todas las variables de sesión
$_SESSION = [];

// Destruir la sesión completamente
session_destroy();

// Redirigir al login con mensaje
header("Location: login/login.php?mensaje=Sesión cerrada exitosamente&clase=alert-success");
exit;
