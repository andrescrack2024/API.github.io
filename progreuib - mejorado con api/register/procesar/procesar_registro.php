<?php
include '../../conex.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];
    $correo = $_POST["email"];
    $contrasena = password_hash($_POST["password"], PASSWORD_DEFAULT);
    $rol = $_POST["rol"];
    $area = $_POST["area"];
    $especialidad = $_POST["especialidad"];

    // Verificar si ya existe el nombre de usuario o correo
    $verificar = $conexion->prepare("SELECT ID FROM usuarios WHERE Nombre = ? OR Correo = ?");
    $verificar->bind_param("ss", $nombre, $correo);
    $verificar->execute();
    $verificar->store_result();

    if ($verificar->num_rows > 0) {
        $mensaje = "Este nombre de usuario o correo ya está registrado.";
        $mensaje_clase = "alert-warning";
        header("Location: ../register.php?mensaje=" . urlencode($mensaje) . "&clase=" . urlencode($mensaje_clase));
        exit;
    }
    $verificar->close();

    // Insertar en la base de datos
    $stmt = $conexion->prepare("INSERT INTO usuarios (Nombre, Correo, Contraseña, Rol, Area, Especialidad) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssss", $nombre, $correo, $contrasena, $rol, $area, $especialidad);

    if ($stmt->execute()) {
        $mensaje = "Registro exitoso. Ahora puedes iniciar sesión.";
        $mensaje_clase = "alert-success";
    } else {
        $mensaje = "Error al registrar. Inténtalo de nuevo.";
        $mensaje_clase = "alert-danger";
    }

    $stmt->close();
    $conexion->close();

    header("Location: ../register.php?mensaje=" . urlencode($mensaje) . "&clase=" . urlencode($mensaje_clase));
    exit;
}
?>
