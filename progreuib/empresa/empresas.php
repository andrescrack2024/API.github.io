<?php
session_start();
include("../conex.php");

$empresaId = $_SESSION['ID'] ?? '';
$nombreEmpresa = $_SESSION['Nombre'] ?? 'Empresa';

// Manejo de eliminación
if (isset($_GET['eliminar'])) {
    $idOferta = $_GET['eliminar'];
    $stmt = $conexion->prepare("DELETE FROM ofertas WHERE ID = ? AND Empresa_id = ?");
    $stmt->bind_param("ii", $idOferta, $empresaId);
    $stmt->execute();
    header("Location: empresas.php?mensaje=Oferta eliminada correctamente&clase=alert-success");
    exit;
}

// Obtener ofertas creadas por esta empresa
$stmt = $conexion->prepare("SELECT * FROM ofertas WHERE Empresa_id = ? ORDER BY Fecha_Publicacion DESC");
$stmt->bind_param("i", $empresaId);
$stmt->execute();
$resultado = $stmt->get_result();

// Mensajes de feedback
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
$claseMensaje = isset($_GET['clase']) ? $_GET['clase'] : '';
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empresa - ProgreUIB</title>
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

        .navbar {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .welcome-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            border: none;
        }

        .welcome-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            border-radius: 10px 10px 0 0;
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

        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .table th {
            background-color: var(--secondary-color);
            color: white;
            position: sticky;
            top: 0;
        }

        .badge-area {
            background-color: var(--primary-color);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
        }

        .action-btn {
            width: 35px;
            height: 35px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 2px;
        }

        .empty-state {
            text-align: center;
            padding: 40px;
            color: #7f8c8d;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 500;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-expired {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <i class="fas fa-briefcase me-2"></i>ProgreUIB - Panel Empresa
            </a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="fas fa-building me-1"></i> <?= htmlspecialchars($nombreEmpresa) ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i> Cerrar sesión
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container py-4">
        <?php if ($mensaje): ?>
            <div class="alert <?= $claseMensaje ?> alert-dismissible fade show" role="alert">
                <?= $mensaje ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Tarjeta de bienvenida -->
        <div class="welcome-card mb-4">
            <div class="welcome-header">
                <div class="d-flex justify-content-between align-items-center">
                    <div>
                        <h3><i class="fas fa-handshake me-2"></i> Bienvenida, <?= htmlspecialchars($nombreEmpresa) ?></h3>
                        <p class="mb-0">Gestiona tus ofertas laborales y encuentra el mejor talento</p>
                    </div>
                    <i class="fas fa-chart-line fa-3x opacity-25"></i>
                </div>
            </div>
        </div>

        <!-- Formulario para publicar oferta -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-plus-circle me-2"></i> Publicar Nueva Oferta</span>
                <i class="fas fa-bullhorn"></i>
            </div>
            <div class="card-body">
                <form action="publicar_oferta.php" method="POST">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Título del Empleo</label>
                            <input type="text" name="Titulo" class="form-control" placeholder="Ej: Desarrollador Web Senior" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Área</label>
                            <select name="Area" class="form-select" required>
                                <option value="" selected disabled>Seleccionar área</option>
                                <option value="Tecnología">Tecnología</option>
                                <option value="Salud">Salud</option>
                                <option value="Educación">Educación</option>
                                <option value="Finanzas">Finanzas</option>
                                <option value="Comercio">Comercio</option>
                                <option value="Manufactura">Manufactura</option>
                                <option value="Servicios">Servicios</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descripción</label>
                        <textarea name="Descripcion" class="form-control" rows="4" placeholder="Describe las responsabilidades y requisitos del puesto..." required></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Requisitos adicionales</label>
                            <textarea name="Requisitos" class="form-control" rows="2" placeholder="Lista de requisitos..."></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Modalidad</label>
                            <select name="Modalidad" class="form-select">
                                <option value="Presencial" selected>Presencial</option>
                                <option value="Remoto">Remoto</option>
                                <option value="Híbrido">Híbrido</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Ubicación</label>
                            <input type="text" name="Ubicacion" class="form-control" placeholder="Ej: Bogotá, Colombia">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Tipo de Contrato</label>
                            <select name="Tipo_Contrato" class="form-select">
                                <option value="" selected disabled>Seleccionar tipo</option>
                                <option value="Tiempo Completo">Tiempo Completo</option>
                                <option value="Medio Tiempo">Medio Tiempo</option>
                                <option value="Por Proyecto">Por Proyecto</option>
                                <option value="Freelance">Freelance</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Salario</label>
                            <input type="text" name="Salario" class="form-control" placeholder="Ej: $3.000.000">
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-paper-plane me-2"></i> Publicar Oferta
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de ofertas publicadas -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-list-alt me-2"></i> Ofertas Publicadas</span>
                <span class="badge bg-primary"><?= $resultado->num_rows ?> ofertas</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Área</th>
                                <th>Ubicación</th>
                                <th>Salario</th>
                                <th>Publicación</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resultado->num_rows > 0): ?>
                                <?php while ($oferta = $resultado->fetch_assoc()):
                                    $fechaPublicacion = new DateTime($oferta['Fecha_Publicacion']);
                                    $hoy = new DateTime();
                                    $diferencia = $hoy->diff($fechaPublicacion)->days;
                                    $estado = $diferencia <= 30 ? 'Activa' : 'Expirada';
                                ?>
                                    <tr>
                                        <td>
                                            <strong><?= htmlspecialchars($oferta['Titulo']) ?></strong><br>
                                            <small class="text-muted"><?= htmlspecialchars($oferta['Tipo_Contrato']) ?></small>
                                        </td>
                                        <td><span class="badge-area"><?= htmlspecialchars($oferta['Area']) ?></span></td>
                                        <td><?= htmlspecialchars($oferta['Ubicacion']) ?></td>
                                        <td><?= htmlspecialchars($oferta['Salario']) ?></td>
                                        <td><?= $fechaPublicacion->format('d/m/Y') ?></td>
                                        <td>
                                            <span class="status-badge <?= $estado === 'Activa' ? 'status-active' : 'status-expired' ?>">
                                                <?= $estado ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="editar_oferta.php?id=<?= $oferta['ID'] ?>" class="btn btn-primary btn-sm action-btn" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <a href="?eliminar=<?= $oferta['ID'] ?>" class="btn btn-danger btn-sm action-btn" title="Eliminar" onclick="return confirm('¿Estás seguro de eliminar esta oferta?')">
                                                <i class="fas fa-trash-alt"></i>
                                            </a>
                                            <a href="ver_postulaciones.php?oferta=<?= $oferta['ID'] ?>" class="btn btn-info btn-sm action-btn" title="Ver postulaciones">
                                                <i class="fas fa-users"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">
                                        <div class="empty-state py-5">
                                            <i class="fas fa-inbox fa-4x mb-3"></i>
                                            <h4>No hay ofertas publicadas</h4>
                                            <p class="text-muted">Comienza publicando tu primera oferta laboral</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Activar tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[title]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>

</html>