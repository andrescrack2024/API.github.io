<?php
session_start();
include("../conex.php");

// Verificar autenticación y rol
if (!isset($_SESSION['Rol']) || $_SESSION['Rol'] !== 'Empresa') {
    header("Location: ../login.php?mensaje=Acceso no autorizado&clase=alert-danger");
    exit;
}

$empresaId = $_SESSION['ID'] ?? '';

// Obtener ID de la oferta a editar
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: empresas.php?mensaje=ID de oferta no válido&clase=alert-danger");
    exit;
}

$idOferta = (int)$_GET['id'];

// Obtener datos actuales de la oferta
$stmt = $conexion->prepare("SELECT * FROM ofertas WHERE ID = ? AND Empresa_id = ?");
$stmt->bind_param("ii", $idOferta, $empresaId);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows === 0) {
    header("Location: empresas.php?mensaje=Oferta no encontrada&clase=alert-danger");
    exit;
}

$oferta = $resultado->fetch_assoc();

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger datos del formulario
    $titulo = $_POST['Titulo'] ?? '';
    $descripcion = $_POST['Descripcion'] ?? '';
    $requisitos = $_POST['Requisitos'] ?? '';
    $area = $_POST['Area'] ?? '';
    $ubicacion = $_POST['Ubicacion'] ?? '';
    $tipoContrato = $_POST['Tipo_Contrato'] ?? '';
    $salario = $_POST['Salario'] ?? '';
    $modalidad = $_POST['Modalidad'] ?? 'Presencial';
    $estado = $_POST['Estado'] ?? 'Activa';

    // Validar datos requeridos
    if (empty($titulo) || empty($descripcion) || empty($area)) {
        $mensaje = "Faltan campos requeridos";
        $claseMensaje = "alert-danger";
    } else {
        // Actualizar la oferta en la base de datos (sin campo de imagen)
        $stmt = $conexion->prepare("UPDATE ofertas SET 
            Titulo = ?, 
            Descripcion = ?, 
            Requisitos = ?, 
            Area = ?, 
            Ubicacion = ?, 
            Tipo_Contrato = ?, 
            Salario = ?,
            Modalidad = ?,
            Estado = ?
            WHERE ID = ? AND Empresa_id = ?");

        $stmt->bind_param(
            "sssssssssii",
            $titulo,
            $descripcion,
            $requisitos,
            $area,
            $ubicacion,
            $tipoContrato,
            $salario,
            $modalidad,
            $estado,
            $idOferta,
            $empresaId
        );

        if ($stmt->execute()) {
            header("Location: empresas.php?mensaje=Oferta actualizada correctamente&clase=alert-success");
            exit;
        } else {
            $mensaje = "Error al actualizar la oferta";
            $claseMensaje = "alert-danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Oferta - ProgreUIB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2c3e50;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --success-color: #27ae60;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
        }

        .card-header {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: white;
            font-weight: 600;
            border-radius: 10px 10px 0 0 !important;
        }

        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .btn-primary:hover {
            background-color: #2980b9;
            border-color: #2980b9;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));">
        <div class="container">
            <a class="navbar-brand" href="#">
                <i class="fas fa-briefcase me-2"></i>ProgreUIB - Editar Oferta
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="empresas.php">
                            <i class="fas fa-arrow-left me-1"></i> Volver
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container py-4">
        <?php if (isset($mensaje)): ?>
            <div class="alert <?= $claseMensaje ?> alert-dismissible fade show" role="alert">
                <?= $mensaje ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-edit me-2"></i> Editar Oferta Laboral</h4>
            </div>
            <div class="card-body">
                <form method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Título del Empleo</label>
                            <input type="text" name="Titulo" class="form-control"
                                value="<?= htmlspecialchars($oferta['Titulo']) ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Área</label>
                            <select name="Area" class="form-select" required>
                                <option value="Tecnología" <?= $oferta['Area'] === 'Tecnología' ? 'selected' : '' ?>>Tecnología</option>
                                <option value="Salud" <?= $oferta['Area'] === 'Salud' ? 'selected' : '' ?>>Salud</option>
                                <option value="Educación" <?= $oferta['Area'] === 'Educación' ? 'selected' : '' ?>>Educación</option>
                                <option value="Finanzas" <?= $oferta['Area'] === 'Finanzas' ? 'selected' : '' ?>>Finanzas</option>
                                <option value="Comercio" <?= $oferta['Area'] === 'Comercio' ? 'selected' : '' ?>>Comercio</option>
                                <option value="Manufactura" <?= $oferta['Area'] === 'Manufactura' ? 'selected' : '' ?>>Manufactura</option>
                                <option value="Servicios" <?= $oferta['Area'] === 'Servicios' ? 'selected' : '' ?>>Servicios</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="Descripcion" class="form-control" rows="4" required><?= htmlspecialchars($oferta['Descripcion']) ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Requisitos adicionales</label>
                            <textarea name="Requisitos" class="form-control" rows="2"><?= htmlspecialchars($oferta['Requisitos']) ?></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Modalidad</label>
                            <select name="Modalidad" class="form-select">
                                <option value="Presencial" <?= $oferta['Modalidad'] === 'Presencial' ? 'selected' : '' ?>>Presencial</option>
                                <option value="Remoto" <?= $oferta['Modalidad'] === 'Remoto' ? 'selected' : '' ?>>Remoto</option>
                                <option value="Híbrido" <?= $oferta['Modalidad'] === 'Híbrido' ? 'selected' : '' ?>>Híbrido</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Ubicación</label>
                            <input type="text" name="Ubicacion" class="form-control"
                                value="<?= htmlspecialchars($oferta['Ubicacion']) ?>">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo de Contrato</label>
                            <select name="Tipo_Contrato" class="form-select">
                                <option value="Tiempo Completo" <?= $oferta['Tipo_Contrato'] === 'Tiempo Completo' ? 'selected' : '' ?>>Tiempo Completo</option>
                                <option value="Medio Tiempo" <?= $oferta['Tipo_Contrato'] === 'Medio Tiempo' ? 'selected' : '' ?>>Medio Tiempo</option>
                                <option value="Por Proyecto" <?= $oferta['Tipo_Contrato'] === 'Por Proyecto' ? 'selected' : '' ?>>Por Proyecto</option>
                                <option value="Freelance" <?= $oferta['Tipo_Contrato'] === 'Freelance' ? 'selected' : '' ?>>Freelance</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Salario</label>
                            <input type="text" name="Salario" class="form-control"
                                value="<?= htmlspecialchars($oferta['Salario']) ?>">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Estado</label>
                            <select name="Estado" class="form-select">
                                <option value="Activa" <?= $oferta['Estado'] === 'Activa' ? 'selected' : '' ?>>Activa</option>
                                <option value="Inactiva" <?= $oferta['Estado'] === 'Inactiva' ? 'selected' : '' ?>>Inactiva</option>
                                <option value="Cerrada" <?= $oferta['Estado'] === 'Cerrada' ? 'selected' : '' ?>>Cerrada</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="empresas.php" class="btn btn-secondary me-md-2">
                            <i class="fas fa-times me-1"></i> Cancelar
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-1"></i> Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>