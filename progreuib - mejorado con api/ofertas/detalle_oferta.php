<?php
include('../conex.php');
session_start();

// Verificar si se proporcionó un ID válido
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: empleos.php");
    exit();
}

$idOferta = (int)$_GET['id'];

// Consulta para obtener los detalles completos de la oferta
$sql = "SELECT 
            o.*, 
            e.Nombre AS empresa_nombre, 
            e.Descripcion AS empresa_descripcion,
            e.Logo AS empresa_logo,
            DATEDIFF(o.Fecha_Expiracion, CURDATE()) AS dias_restantes
        FROM ofertas o 
        JOIN empresas e ON o.Empresa_id = e.ID 
        WHERE o.ID = ?";

$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $idOferta);
$stmt->execute();
$resultado = $stmt->get_result();

// Si no existe la oferta, redirigir
if ($resultado->num_rows === 0) {
    header("Location: empleos.php");
    exit();
}

$oferta = $resultado->fetch_assoc();
$diasPublicacion = floor((time() - strtotime($oferta['Fecha_Publicacion'])) / (60 * 60 * 24));

// Obtener datos del usuario si está logueado
$usuario = null;
if (isset($_SESSION['ID'])) {
    $sqlUsuario = "SELECT * FROM usuarios WHERE ID = ?";
    $stmtUsuario = $conexion->prepare($sqlUsuario);
    $stmtUsuario->bind_param("i", $_SESSION['ID']);
    $stmtUsuario->execute();
    $resultadoUsuario = $stmtUsuario->get_result();
    $usuario = $resultadoUsuario->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($oferta['Titulo']) ?> - ProgreUIB</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* === Estilos generales === */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
            background-color: #f8f9fa;
        }

        /* === Navbar Elegante === */
        .navbar {
            background-color: #0a192f;
            padding: 1rem 0;
            transition: all 0.4s ease;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .navbar.scrolled {
            padding: 0.7rem 0;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #64ffda !important;
            letter-spacing: 1px;
        }

        .navbar-brand img {
            border: 1px solid #64ffda;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: #64ffda !important;
        }

        .nav-link.active {
            color: #64ffda !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 1rem;
            width: calc(100% - 2rem);
            height: 2px;
            background: #64ffda;
        }

        .navbar-toggler {
            border: none;
            color: #64ffda !important;
        }

        /* === Header con título claro === */
        .job-header {
            background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
            padding: 3rem 0;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
            color: white;
            border-radius: 8px;
        }

        .job-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgxMDAsMjU1LDIxOCwwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3QgZmlsbD0idXJsKCNwYXR0ZXJuKSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPjwvc3ZnPg==');
        }

        .company-logo {
            width: 100px;
            height: 100px;
            object-fit: contain;
            border-radius: 50%;
            border: 2px solid rgba(100, 255, 218, 0.3);
            background: white;
            padding: 5px;
        }

        .job-title {
            font-size: 2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .company-name {
            font-size: 1.3rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1.5rem;
        }

        .job-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .job-badge {
            background: rgba(100, 255, 218, 0.1);
            color: white;
            border-radius: 20px;
            padding: 0.5rem 1rem;
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid rgba(100, 255, 218, 0.3);
        }

        .job-badge i {
            margin-right: 0.5rem;
        }

        .job-meta {
            display: flex;
            align-items: center;
            gap: 1.5rem;
            color: rgba(255, 255, 255, 0.8);
        }

        .job-meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-apply {
            background: #64ffda;
            color: #0a192f;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 6px;
            width: 100%;
            margin-bottom: 1rem;
        }

        .btn-apply:hover {
            background: #52e0c4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        .btn-back {
            background: transparent;
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 6px;
            width: 100%;
        }

        .btn-back:hover {
            background: rgba(100, 255, 218, 0.1);
            color: #64ffda;
        }

        /* === Secciones de contenido === */
        .section-card {
            background: white;
            border: none;
            border-radius: 8px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 1.5rem;
            color: #0a192f;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 50px;
            height: 3px;
            background: #64ffda;
        }

        .section-title i {
            color: #64ffda;
            margin-right: 0.75rem;
        }

        .job-description {
            color: #555;
            line-height: 1.8;
            margin-bottom: 1.5rem;
        }

        .requirements-list {
            padding-left: 1.5rem;
        }

        .requirements-list li {
            margin-bottom: 0.5rem;
            color: #555;
        }

        /* === Sección de empresa === */
        .company-card {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 1.5rem;
            height: 100%;
        }

        .company-card-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 1rem;
            color: #0a192f;
        }

        .company-details-list {
            list-style: none;
            padding: 0;
        }

        .company-details-list li {
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        .company-details-list i {
            width: 24px;
            color: #64ffda;
            margin-right: 0.75rem;
        }

        /* === Dropdown de perfil === */
        .profile-dropdown {
            position: relative;
        }

        .profile-btn {
            background: none;
            border: none;
            color: white;
            padding: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-img {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid rgba(100, 255, 218, 0.3);
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            background-color: white;
            min-width: 220px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            border-radius: 8px;
            overflow: hidden;
        }

        .dropdown-content a {
            color: #333;
            padding: 0.75rem 1.5rem;
            text-decoration: none;
            display: block;
            transition: all 0.3s ease;
        }

        .dropdown-content a:hover {
            background: #f8f9fa;
            color: #0a192f;
            padding-left: 1.75rem;
        }

        .dropdown-content i {
            width: 20px;
            margin-right: 0.75rem;
            color: #64ffda;
        }

        .dropdown-divider {
            border-top: 1px solid #eee;
            margin: 0;
        }

        .profile-dropdown:hover .dropdown-content {
            display: block;
        }

        /* === Footer === */
        .footer {
            background: #0a192f;
            padding: 3rem 0 1.5rem;
            margin-top: 4rem;
            color: white;
        }

        .footer-copyright {
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
            padding-top: 1.5rem;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* === Responsive Design === */
        @media (max-width: 992px) {
            .job-title {
                font-size: 1.8rem;
            }
            
            .company-name {
                font-size: 1.1rem;
            }
        }

        @media (max-width: 768px) {
            .job-header {
                padding: 2rem 0;
            }
            
            .job-title {
                font-size: 1.6rem;
            }
            
            .job-badges {
                justify-content: center;
            }
            
            .job-meta {
                justify-content: center;
                flex-wrap: wrap;
                gap: 1rem;
            }
            
            .btn-apply, .btn-back {
                max-width: 300px;
                margin-left: auto;
                margin-right: auto;
            }
        }

        @media (max-width: 576px) {
            .job-title {
                font-size: 1.4rem;
                text-align: center;
            }
            
            .company-name {
                text-align: center;
            }
            
            .company-logo {
                width: 80px;
                height: 80px;
                margin-left: auto;
                margin-right: auto;
                margin-bottom: 1rem;
            }
            
            .section-card {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Elegante -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="../index.php">
                <img src="../img/icono.jpeg" alt="Logo" width="30" height="30" class="me-2 rounded-circle">
                ProgreUIB
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class='bx bx-menu'></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="empleos.php">
                            <i class='bx bx-search-alt-2'></i> Buscar Ofertas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class='bx bx-bell'></i> Alertas
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav ms-auto">
                    <?php if (isset($_SESSION['ID'])): ?>
                        <li class="nav-item profile-dropdown">
                            <button class="profile-btn nav-link">
                                <?php if (!empty($usuario['Foto'])): ?>
                                    <img src="../uploads/perfiles/<?= htmlspecialchars($usuario['Foto']) ?>" class="profile-img" alt="Foto de perfil">
                                <?php else: ?>
                                    <img src="../img/default-profile.png" class="profile-img" alt="Foto de perfil">
                                <?php endif; ?>
                                <span class="d-none d-sm-inline"><?= htmlspecialchars($usuario['Nombre'] ?? 'Usuario') ?></span>
                            </button>
                            <div class="dropdown-content">
                                <a href="perfil.php">
                                    <i class='bx bx-user'></i> Mi Perfil
                                </a>
                                <a href="../mis-postulaciones.php">
                                    <i class='bx bx-file'></i> Mis Postulaciones
                                </a>
                                <?php if ($_SESSION['Rol'] == 'Empresa'): ?>
                                    <a href="../mis-ofertas.php">
                                        <i class='bx bx-briefcase'></i> Mis Ofertas
                                    </a>
                                <?php endif; ?>
                                <div class="dropdown-divider"></div>
                                <a href="../configuracion.php">
                                    <i class='bx bx-cog'></i> Configuración
                                </a>
                                <div class="dropdown-divider"></div>
                                <a href="../logout.php">
                                    <i class='bx bx-log-out'></i> Cerrar Sesión
                                </a>
                            </div>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../login.php">
                                <i class='bx bx-log-in'></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../registro.php">
                                <i class='bx bx-user-plus'></i> Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <main class="container" style="margin-top: 80px;">
        <!-- Encabezado de la oferta -->
        <div class="job-header">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Logo de la empresa -->
                    <div class="col-md-2 text-center mb-4 mb-md-0">
                        <?php if (!empty($oferta['empresa_logo'])): ?>
                            <img src="../uploads/logos/<?= htmlspecialchars($oferta['empresa_logo']) ?>" alt="Logo de <?= htmlspecialchars($oferta['empresa_nombre']) ?>" class="company-logo">
                        <?php else: ?>
                            <div class="company-logo d-flex align-items-center justify-content-center mx-auto">
                                <i class='bx bx-building-house text-dark' style="font-size: 2.5rem;"></i>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Título y datos principales -->
                    <div class="col-md-7">
                        <h1 class="job-title"><?= htmlspecialchars($oferta['Titulo']) ?></h1>
                        <h4 class="company-name"><?= htmlspecialchars($oferta['empresa_nombre']) ?></h4>

                        <div class="job-badges">
                            <span class="job-badge">
                                <i class='bx bx-map'></i> <?= htmlspecialchars($oferta['Ubicacion']) ?>
                            </span>
                            <span class="job-badge">
                                <i class='bx bx-time'></i> <?= htmlspecialchars($oferta['Tipo_Contrato']) ?>
                            </span>
                            <span class="job-badge">
                                <i class='bx bx-laptop'></i> <?= htmlspecialchars($oferta['Modalidad']) ?>
                            </span>
                            <span class="job-badge">
                                <i class='bx bx-dollar-circle'></i> <?= htmlspecialchars($oferta['Salario']) ?>
                            </span>
                        </div>

                        <div class="job-meta">
                            <span class="job-meta-item">
                                <i class='bx bx-calendar'></i>
                                <?= $diasPublicacion < 1 ? 'Publicado hoy' : 'Publicado hace ' . $diasPublicacion . ' días' ?>
                            </span>
                            <?php if ($oferta['dias_restantes'] <= 5): ?>
                                <span class="job-meta-item" style="color: <?= $oferta['dias_restantes'] <= 2 ? '#ff6b6b' : '#ffd166' ?>">
                                    <i class='bx bx-time-five'></i>
                                    <?= $oferta['dias_restantes'] == 1 ? 'Último día' : $oferta['dias_restantes'] . ' días restantes' ?>
                                </span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Botón de postulación -->
                    <div class="col-md-3">
                        <?php if (isset($_SESSION['ID']) && $_SESSION['Rol'] == 'Trabajador'): ?>
                            <button class="btn btn-apply">
                                <i class='bx bx-paper-plane'></i> Postularme
                            </button>
                        <?php elseif (!isset($_SESSION['ID'])): ?>
                            <a href="../login.php" class="btn btn-apply">
                                <i class='bx bx-log-in'></i> Iniciar sesión para postular
                            </a>
                        <?php endif; ?>
                        <a href="empleos.php" class="btn btn-back">
                            <i class='bx bx-arrow-back'></i> Volver
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Descripción de la oferta -->
        <div class="section-card">
            <h3 class="section-title"><i class='bx bx-align-left'></i>Descripción del puesto</h3>
            <div class="job-description">
                <?= nl2br(htmlspecialchars($oferta['Descripcion'])) ?>
            </div>

            <?php if (!empty($oferta['Requisitos'])): ?>
                <h5 class="mt-4" style="font-weight: 600; color: #0a192f;">Requisitos:</h5>
                <div class="job-description">
                    <?= nl2br(htmlspecialchars($oferta['Requisitos'])) ?>
                </div>
            <?php endif; ?>
        </div>

        <!-- Información de la empresa -->
        <div class="section-card">
            <h3 class="section-title"><i class='bx bx-buildings'></i>Sobre la empresa</h3>
            <div class="row">
                <div class="col-lg-8 mb-4 mb-lg-0">
                    <h4 style="font-weight: 600; color: #0a192f; margin-bottom: 1rem;"><?= htmlspecialchars($oferta['empresa_nombre']) ?></h4>
                    <?php if (!empty($oferta['empresa_descripcion'])): ?>
                        <div class="job-description">
                            <?= nl2br(htmlspecialchars($oferta['empresa_descripcion'])) ?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Esta empresa no ha proporcionado una descripción.</p>
                    <?php endif; ?>
                </div>
                <div class="col-lg-4">
                    <div class="company-card">
                        <h5 class="company-card-title">Detalles de la oferta</h5>
                        <ul class="company-details-list">
                            <li>
                                <i class='bx bx-category'></i>
                                <div>
                                    <strong>Área:</strong><br>
                                    <?= htmlspecialchars($oferta['Area']) ?>
                                </div>
                            </li>
                            <li>
                                <i class='bx bx-user'></i>
                                <div>
                                    <strong>Vacantes:</strong><br>
                                    <?= (int)$oferta['Vacantes'] ?>
                                </div>
                            </li>
                            <li>
                                <i class='bx bx-calendar'></i>
                                <div>
                                    <strong>Publicación:</strong><br>
                                    <?= date('d/m/Y', strtotime($oferta['Fecha_Publicacion'])) ?>
                                </div>
                            </li>
                            <li>
                                <i class='bx bx-calendar-event'></i>
                                <div>
                                    <strong>Cierre:</strong><br>
                                    <?= date('d/m/Y', strtotime($oferta['Fecha_Expiracion'])) ?>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Botón de volver -->
        <div class="text-center mt-4">
            <a href="empleos.php" class="btn btn-back" style="max-width: 250px;">
                <i class='bx bx-arrow-back'></i> Volver a ofertas
            </a>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-copyright">
                <p class="mb-0">&copy; <?= date('Y') ?> ProgreUIB. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Boxicons -->
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <!-- Script para el dropdown del perfil -->
    <script>
        // Cerrar el dropdown al hacer clic fuera de él
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('.profile-dropdown');
            dropdowns.forEach(dropdown => {
                if (!dropdown.contains(event.target)) {
                    dropdown.querySelector('.dropdown-content').style.display = 'none';
                }
            });
        });

        // Efecto de scroll en navbar
        window.addEventListener("scroll", function() {
            const navbar = document.querySelector(".navbar");
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });
    </script>
</body>

</html>