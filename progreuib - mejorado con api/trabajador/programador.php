<?php
session_start();

if (!isset($_SESSION['Nombre']) || $_SESSION['Rol'] !== 'Trabajador' || $_SESSION['Area'] !== 'Programador') {
    header("Location: ../login.php?mensaje=Acceso no autorizado&clase=alert-danger");
    exit;
}

$nombre = $_SESSION['Nombre'];
$area = $_SESSION['Area'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Programador - ProgreUIB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style/style.css">
</head>
<body>

<div class="header">
    <h2>¡Hola, <?php echo $nombre; ?>!</h2>
    <p>Bienvenido a tu panel exclusivo de <strong><?php echo $area; ?></strong></p>
</div>

<div class="container mt-4">
    <h4 class="mb-4">🔎 Ofertas laborales para Programadores</h4>

    <?php
    include("../conex.php");

    $sql = "SELECT * FROM ofertas WHERE Area = 'Programador'";
    $resultado = $conexion->query($sql);

    if ($resultado->num_rows > 0):
        while ($oferta = $resultado->fetch_assoc()):
    ?>
        <div class="oferta-card">
            <h5><?php echo htmlspecialchars($oferta['Titulo']); ?></h5>
            <p><?php echo htmlspecialchars($oferta['Descripcion']); ?></p>
            <div class="oferta-meta">
                <strong>Ubicación:</strong> <?php echo htmlspecialchars($oferta['Ubicacion']); ?><br>
                <strong>Tipo de contrato:</strong> <?php echo htmlspecialchars($oferta['Tipo_Contrato']); ?><br>
                <strong>Salario:</strong> <?php echo htmlspecialchars($oferta['Salario']); ?><br>
                <strong>Fecha de publicación:</strong> <?php echo htmlspecialchars($oferta['Fecha_Publicacion']); ?>
            </div>
        </div>
    <?php endwhile; else: ?>
        <div class="alert alert-info">No hay ofertas disponibles en este momento.</div>
    <?php endif; ?>
</div>

</body>
</html>
