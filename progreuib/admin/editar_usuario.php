<?php
session_start();
include("../conex.php");

if (!isset($_SESSION['Rol']) || $_SESSION['Rol'] !== 'Administrador') {
    header("Location: ../login.php?mensaje=Acceso no autorizado&clase=alert-danger");
    exit;
}

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $rol = $conexion->real_escape_string($_POST['rol']);

    $conexion->query("UPDATE usuarios SET Nombre='$nombre', Correo='$correo', Rol='$rol' WHERE ID=$id");

    header("Location: admin.php?mensaje=Usuario actualizado correctamente&clase=alert-success");
    exit;
}

// Obtener datos del usuario
if (!isset($_GET['id'])) {
    header("Location: admin.php?mensaje=ID no válido&clase=alert-danger");
    exit;
}

$idUsuario = $_GET['id'];
$resultado = $conexion->query("SELECT * FROM usuarios WHERE ID = $idUsuario");

if ($resultado->num_rows == 0) {
    header("Location: admin.php?mensaje=Usuario no encontrado&clase=alert-danger");
    exit;
}

$usuario = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario - ProgreUIB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card mx-auto" style="max-width: 600px;">
            <div class="card-header bg-primary text-white">
                ✏️ Editar Usuario
            </div>
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="id" value="<?= $usuario['ID'] ?>">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" required value="<?= $usuario['Nombre'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo:</label>
                        <input type="email" name="correo" id="correo" class="form-control" required value="<?= $usuario['Correo'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol:</label>
                        <select name="rol" id="rol" class="form-select" required>
                            <option value="Trabajador" <?= $usuario['Rol'] == 'Trabajador' ? 'selected' : '' ?>>Trabajador</option>
                            <option value="Empresa" <?= $usuario['Rol'] == 'Empresa' ? 'selected' : '' ?>>Empresa</option>
                            <option value="Administrador" <?= $usuario['Rol'] == 'Administrador' ? 'selected' : '' ?>>Administrador</option>
                            <option value="Vendedor" <?= $usuario['Rol'] == 'Vendedor' ? 'selected' : '' ?>>Vendedor</option>
                        </select>
                    </div>
                    <div class="d-flex justify-content-between">
                        <a href="admin.php" class="btn btn-secondary">↩ Volver</a>
                        <button type="submit" class="btn btn-success">💾 Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
