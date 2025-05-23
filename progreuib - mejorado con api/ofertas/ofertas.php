<?php
include('../conex.php');

// Verificar conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Configuración de paginación
$porPagina = 10;
$pagina = isset($_GET['pagina']) && is_numeric($_GET['pagina']) ? max(1, (int)$_GET['pagina']) : 1;
$inicio = ($pagina > 1) ? ($pagina * $porPagina - $porPagina) : 0;

// Obtener parámetros de filtrado
$busqueda = isset($_GET['busqueda']) ? trim($_GET['busqueda']) : '';
$area = isset($_GET['area']) ? $_GET['area'] : '';
$ubicacion = isset($_GET['ubicacion']) ? $_GET['ubicacion'] : '';
$tipo_contrato = isset($_GET['tipo_contrato']) ? $_GET['tipo_contrato'] : '';
$modalidad = isset($_GET['modalidad']) ? $_GET['modalidad'] : '';
$experiencia = isset($_GET['experiencia']) ? $_GET['experiencia'] : '';
$salario_min = isset($_GET['salario_min']) ? (float)$_GET['salario_min'] : '';
$salario_max = isset($_GET['salario_max']) ? (float)$_GET['salario_max'] : '';

// Consulta base con filtros
$sql = "SELECT SQL_CALC_FOUND_ROWS o.*, e.Nombre AS empresa_nombre, 
               e.Descripcion AS empresa_descripcion,
               DATEDIFF(o.Fecha_Expiracion, CURDATE()) AS dias_restantes
        FROM ofertas o 
        JOIN empresas e ON o.Empresa_id = e.ID 
        WHERE o.Estado = 'Activa'";

$params = [];
$types = '';

// Aplicar filtros
if (!empty($busqueda)) {
    $sql .= " AND (o.Titulo LIKE ? OR o.Descripcion LIKE ? OR e.Nombre LIKE ?)";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
    $params[] = "%$busqueda%";
    $types .= 'sss';
}

if (!empty($area)) {
    $sql .= " AND o.Area = ?";
    $params[] = $area;
    $types .= 's';
}

if (!empty($ubicacion)) {
    $sql .= " AND o.Ubicacion = ?";
    $params[] = $ubicacion;
    $types .= 's';
}

if (!empty($tipo_contrato)) {
    $sql .= " AND o.Tipo_Contrato = ?";
    $params[] = $tipo_contrato;
    $types .= 's';
}

if (!empty($modalidad)) {
    $sql .= " AND o.Modalidad = ?";
    $params[] = $modalidad;
    $types .= 's';
}

if (!empty($experiencia)) {
    $sql .= " AND o.Experiencia = ?";
    $params[] = $experiencia;
    $types .= 's';
}

if (!empty($salario_min)) {
    $sql .= " AND REPLACE(REPLACE(o.Salario, '$', ''), '.', '') >= ?";
    $params[] = $salario_min;
    $types .= 'd';
}

if (!empty($salario_max)) {
    $sql .= " AND REPLACE(REPLACE(o.Salario, '$', ''), '.', '') <= ?";
    $params[] = $salario_max;
    $types .= 'd';
}

$sql .= " ORDER BY o.Fecha_Publicacion DESC LIMIT ?, ?";
$params[] = $inicio;
$types .= 'i';
$params[] = $porPagina;
$types .= 'i';

// Ejecutar consulta
$stmt = $conexion->prepare($sql);
if ($types) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$ofertas = $stmt->get_result();

// Obtener total de ofertas
$totalOfertas = $conexion->query("SELECT FOUND_ROWS() AS total")->fetch_assoc()['total'];
$totalPaginas = ceil($totalOfertas / $porPagina);

// Obtener opciones para filtros
$areas = $conexion->query("SELECT DISTINCT Area FROM ofertas ORDER BY Area");
$ubicaciones = $conexion->query("SELECT DISTINCT Ubicacion FROM ofertas ORDER BY Ubicacion");
$contratos = $conexion->query("SELECT DISTINCT Tipo_Contrato FROM ofertas ORDER BY Tipo_Contrato");
$modalidades = $conexion->query("SELECT DISTINCT Modalidad FROM ofertas ORDER BY Modalidad");
$experiencias = $conexion->query("SELECT DISTINCT Experiencia FROM ofertas ORDER BY Experiencia");
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ofertas Laborales - ProgreUIB</title>
    <link rel="icon" href="../img/icono.jpeg">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

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
        .page-header {
            background: linear-gradient(135deg, #0a192f 0%, #172a45 100%);
            padding: 6rem 0 4rem;
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxMDAlIiBoZWlnaHQ9IjEwMCUiPjxkZWZzPjxwYXR0ZXJuIGlkPSJwYXR0ZXJuIiB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHBhdHRlcm5Vbml0cz0idXNlclNwYWNlT25Vc2UiIHBhdHRlcm5UcmFuc2Zvcm09InJvdGF0ZSg0NSkiPjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0icmdiYSgxMDAsMjU1LDIxOCwwLjAzKSIvPjwvcGF0dGVybj48L2RlZnM+PHJlY3QgZmlsbD0idXJsKCNwYXR0ZXJuKSIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIvPjwvc3ZnPg==');
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #fff;
            margin-bottom: 1rem;
            position: relative;
        }

        .page-subtitle {
            color: rgba(255, 255, 255, 0.8);
            font-size: 1.2rem;
            max-width: 700px;
            margin: 0 auto;
        }

        /* === Sección de Filtros === */
        .filter-section {
            padding: 2rem 0;
            background: #fff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            margin-bottom: 2rem;
            border-radius: 8px;
        }

        .section-title {
            font-size: 1.8rem;
            color: #0a192f;
            margin-bottom: 1.5rem;
            position: relative;
            display: inline-block;
            font-weight: 600;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 50px;
            height: 3px;
            background: #64ffda;
        }

        .form-label {
            color: #0a192f;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .form-select,
        .form-control {
            border: 1px solid #e1e5ee;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
        }

        .form-select:focus,
        .form-control:focus {
            border-color: #64ffda;
            box-shadow: 0 0 0 0.25rem rgba(100, 255, 218, 0.25);
        }

        .btn-search {
            background: #64ffda;
            color: #0a192f;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .btn-search:hover {
            background: #52e0c4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        .btn-reset {
            background: transparent;
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .btn-reset:hover {
            background: rgba(100, 255, 218, 0.1);
            color: #64ffda;
            transform: translateY(-2px);
        }

        /* === Sección de Resultados === */
        .results-section {
            padding: 2rem 0;
        }

        .results-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e1e5ee;
        }

        .results-count {
            color: #0a192f;
            font-size: 1.2rem;
            font-weight: 500;
        }

        .sort-dropdown .btn {
            background: #fff;
            color: #0a192f;
            border: 1px solid #e1e5ee;
            font-weight: 500;
        }

        .sort-dropdown .dropdown-menu {
            border: 1px solid #e1e5ee;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .sort-dropdown .dropdown-item {
            color: #0a192f;
            padding: 0.5rem 1.5rem;
        }

        .sort-dropdown .dropdown-item:hover {
            background: #64ffda;
            color: #0a192f;
        }

        /* === Tarjetas de Ofertas === */
        .job-card {
            background: #fff;
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .job-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .job-card .card-body {
            padding: 1.5rem;
        }

        .job-title {
            color: #0a192f;
            font-weight: 600;
            margin-bottom: 0.5rem;
            font-size: 1.3rem;
        }

        .job-company {
            color: #6c757d;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            font-size: 1rem;
        }

        .job-company i {
            margin-right: 0.5rem;
            color: #64ffda;
        }

        .job-description {
            color: #6c757d;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .job-badges {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .job-badge {
            background: rgba(100, 255, 218, 0.1);
            color: #0a192f;
            border-radius: 20px;
            padding: 0.25rem 0.75rem;
            font-size: 0.8rem;
            font-weight: 500;
            border: 1px solid rgba(100, 255, 218, 0.3);
        }

        .job-badge i {
            margin-right: 0.25rem;
            color: #64ffda;
        }

        .job-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 1rem;
            border-top: 1px solid #e1e5ee;
        }

        .job-salary {
            color: #0a192f;
            font-weight: 600;
        }

        .job-salary i {
            color: #64ffda;
            margin-right: 0.25rem;
        }

        .job-date {
            color: #6c757d;
            font-size: 0.9rem;
        }

        .job-date i {
            margin-right: 0.25rem;
        }

        .btn-details {
            background: #64ffda;
            color: #0a192f;
            border: none;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
            font-weight: 500;
            border-radius: 6px;
        }

        .btn-details:hover {
            background: #52e0c4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        /* === Paginación === */
        .pagination .page-item .page-link {
            color: #0a192f;
            border: 1px solid #e1e5ee;
            margin: 0 0.25rem;
            border-radius: 6px !important;
        }

        .pagination .page-item.active .page-link {
            background: #64ffda;
            border-color: #64ffda;
            color: #0a192f;
        }

        .pagination .page-item.disabled .page-link {
            color: #adb5bd;
        }

        /* === Sin Resultados === */
        .no-results {
            text-align: center;
            padding: 4rem 0;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .no-results i {
            font-size: 4rem;
            color: #64ffda;
            margin-bottom: 1.5rem;
        }

        .no-results h4 {
            color: #0a192f;
            margin-bottom: 1rem;
            font-weight: 600;
        }

        .no-results p {
            color: #6c757d;
            margin-bottom: 2rem;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn-reload {
            background: #64ffda;
            color: #0a192f;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border-radius: 6px;
        }

        .btn-reload:hover {
            background: #52e0c4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        /* === Footer Elegante === */
        .footer {
            background: #0a192f;
            padding: 4rem 0 2rem;
            margin-top: 4rem;
            color: #fff;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #64ffda;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        .footer-about {
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 2rem;
        }

        .footer-links h5 {
            color: #fff;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
            font-weight: 600;
        }

        .footer-links h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: #64ffda;
        }

        .footer-links ul {
            list-style: none;
            padding: 0;
        }

        .footer-links li {
            margin-bottom: 0.8rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #64ffda;
            padding-left: 5px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(100, 255, 218, 0.1);
            border-radius: 50%;
            color: #64ffda;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: #64ffda;
            color: #0a192f;
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.7);
        }

        /* === Select2 Custom === */
        .select2-container--default .select2-selection--single,
        .select2-container--default .select2-selection--multiple {
            border: 1px solid #e1e5ee;
            height: auto;
            padding: 0.5rem;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: #64ffda;
            color: #0a192f;
            border: none;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #0a192f;
        }

        /* === Responsive Design === */
        @media (max-width: 992px) {
            .page-title {
                font-size: 2.2rem;
            }

            .section-title {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 768px) {
            .page-header {
                padding: 5rem 0 3rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.4rem;
            }

            .results-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .job-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }
        }

        @media (max-width: 576px) {
            .page-title {
                font-size: 1.8rem;
            }

            .page-subtitle {
                font-size: 1rem;
            }

            .job-card .card-body {
                padding: 1.25rem;
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
                        <a class="nav-link" href="../ofertas.php">
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
                        <!-- Menú de usuario con dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown">
                                <?php
                                // Obtener datos del usuario para mostrar en el navbar
                                $user_id = $_SESSION['ID'];
                                $user_query = $conexion->prepare("SELECT Nombre, Correo FROM usuarios WHERE ID = ?");
                                $user_query->bind_param("i", $user_id);
                                $user_query->execute();
                                $user_result = $user_query->get_result();

                                if ($user_data = $user_result->fetch_assoc()): ?>
                                    <div class="me-2 text-end d-none d-sm-block">
                                        <div class="fw-medium"><?= htmlspecialchars($user_data['Nombre']) ?></div>
                                        <div class="small text-white-50"><?= htmlspecialchars($user_data['Correo']) ?></div>
                                    </div>
                                    <div class="avatar bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
                                        <?= strtoupper(substr($user_data['Nombre'], 0, 1)) ?>
                                    </div>
                                <?php endif; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="userDropdown" style="min-width: 220px;">
                                <li>
                                    <a class="dropdown-item" href="../miperfil.php">
                                        <i class='bx bx-user me-2'></i> Mi Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class='bx bx-cog me-2'></i> Configuración
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class='bx bx-file me-2'></i> Mis Postulaciones
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="../logout.php">
                                        <i class='bx bx-log-out me-2'></i> Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="../login/login.php">
                                <i class='bx bx-log-in'></i> Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../register/register.php">
                                <i class='bx bx-user-plus'></i> Registrarse
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header con título claro -->
    <header class="page-header">
        <div class="container text-center">
            <h1 class="page-title">Ofertas Laborales</h1>
            <p class="page-subtitle">Encuentra las mejores oportunidades profesionales en nuestra plataforma</p>
        </div>
    </header>

    <!-- Contenido principal -->
    <main class="container">
        <!-- Sección de Filtros -->
        <section class="filter-section">
            <h2 class="section-title">Filtrar Ofertas</h2>
            <form id="filterForm" method="GET" action="empleos.php">
                <div class="row g-3">
                    <!-- Búsqueda general -->
                    <div class="col-md-12">
                        <label class="form-label">Palabras clave</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class='bx bx-search'></i></span>
                            <input type="text" name="busqueda" class="form-control" placeholder="Buscar por puesto, empresa o descripción..." value="<?= htmlspecialchars($busqueda) ?>">
                        </div>
                    </div>

                    <!-- Filtros principales -->
                    <div class="col-md-3">
                        <label class="form-label">Área</label>
                        <select name="area" class="form-select select2">
                            <option value="">Todas las áreas</option>
                            <?php while ($row = $areas->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['Area']) ?>" <?= $area == $row['Area'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['Area']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Ubicación</label>
                        <select name="ubicacion" class="form-select select2">
                            <option value="">Todas las ubicaciones</option>
                            <?php while ($row = $ubicaciones->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['Ubicacion']) ?>" <?= $ubicacion == $row['Ubicacion'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['Ubicacion']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tipo de contrato</label>
                        <select name="tipo_contrato" class="form-select select2">
                            <option value="">Todos los tipos</option>
                            <?php while ($row = $contratos->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['Tipo_Contrato']) ?>" <?= $tipo_contrato == $row['Tipo_Contrato'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['Tipo_Contrato']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Modalidad</label>
                        <select name="modalidad" class="form-select select2">
                            <option value="">Todas</option>
                            <?php while ($row = $modalidades->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['Modalidad']) ?>" <?= $modalidad == $row['Modalidad'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['Modalidad']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <!-- Filtros adicionales -->
                    <div class="col-md-4">
                        <label class="form-label">Experiencia</label>
                        <select name="experiencia" class="form-select select2">
                            <option value="">Todas</option>
                            <?php while ($row = $experiencias->fetch_assoc()): ?>
                                <option value="<?= htmlspecialchars($row['Experiencia']) ?>" <?= $experiencia == $row['Experiencia'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($row['Experiencia']) ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Salario mínimo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">$</span>
                            <input type="number" name="salario_min" class="form-control" placeholder="Mínimo" value="<?= htmlspecialchars($salario_min) ?>">
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label">Salario máximo</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white">$</span>
                            <input type="number" name="salario_max" class="form-control" placeholder="Máximo" value="<?= htmlspecialchars($salario_max) ?>">
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="col-12 d-flex justify-content-end gap-2">
                        <button type="submit" class="btn btn-search">
                            <i class='bx bx-filter-alt me-1'></i> Filtrar
                        </button>
                        <a href="empleos.php" class="btn btn-reset">
                            <i class='bx bx-reset me-1'></i> Limpiar
                        </a>
                    </div>
                </div>
            </form>
        </section>

        <!-- Sección de Resultados -->
        <section class="results-section">
            <div class="results-header">
                <div class="results-count">
                    <i class='bx bx-briefcase-alt-2 me-2'></i> <?= number_format($totalOfertas, 0, ',', '.') ?> Ofertas encontradas
                </div>
                <div class="sort-dropdown dropdown">
                    <button class="btn dropdown-toggle" type="button" id="sortDropdown" data-bs-toggle="dropdown">
                        <i class='bx bx-sort me-1'></i> Ordenar por: Más recientes
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="sortDropdown">
                        <li><a class="dropdown-item" href="#">Más recientes</a></li>
                        <li><a class="dropdown-item" href="#">Más antiguas</a></li>
                        <li><a class="dropdown-item" href="#">Mejor salario</a></li>
                        <li><a class="dropdown-item" href="#">Más relevantes</a></li>
                    </ul>
                </div>
            </div>

            <!-- Listado de ofertas -->
            <?php if ($ofertas->num_rows > 0): ?>
                <div class="row">
                    <?php while ($oferta = $ofertas->fetch_assoc()):
                        $diasPublicacion = floor((time() - strtotime($oferta['Fecha_Publicacion'])) / (60 * 60 * 24));
                    ?>
                        <div class="col-lg-6">
                            <div class="job-card card">
                                <div class="card-body">
                                    <h3 class="job-title"><?= htmlspecialchars($oferta['Titulo']) ?></h3>
                                    <div class="job-company">
                                        <i class='bx bx-buildings'></i> <?= htmlspecialchars($oferta['empresa_nombre']) ?>
                                    </div>

                                    <p class="job-description"><?= nl2br(htmlspecialchars(substr($oferta['Descripcion'], 0, 200))) ?>...</p>

                                    <div class="job-badges">
                                        <span class="job-badge">
                                            <i class='bx bx-map'></i> <?= htmlspecialchars($oferta['Ubicacion']) ?>
                                        </span>
                                        <span class="job-badge">
                                            <i class='bx bx-time-five'></i> <?= htmlspecialchars($oferta['Tipo_Contrato']) ?>
                                        </span>
                                        <span class="job-badge">
                                            <i class='bx bx-laptop'></i> <?= htmlspecialchars($oferta['Modalidad']) ?>
                                        </span>
                                        <?php if ($oferta['dias_restantes'] <= 5): ?>
                                            <span class="job-badge" style="background: <?= $oferta['dias_restantes'] <= 2 ? 'rgba(220, 53, 69, 0.1)' : 'rgba(255, 193, 7, 0.1)' ?>; color: <?= $oferta['dias_restantes'] <= 2 ? '#dc3545' : '#ffc107' ?>">
                                                <i class='bx bx-time'></i> <?= $oferta['dias_restantes'] == 1 ? 'Último día' : $oferta['dias_restantes'] . ' días restantes' ?>
                                            </span>
                                        <?php endif; ?>
                                    </div>

                                    <div class="job-footer">
                                        <div>
                                            <span class="job-salary">
                                                <i class='bx bx-dollar-circle'></i> <?= htmlspecialchars($oferta['Salario']) ?>
                                            </span>
                                            <span class="job-date ms-3">
                                                <i class='bx bx-calendar'></i> <?= $diasPublicacion < 1 ? 'Publicado hoy' : 'Publicado hace ' . $diasPublicacion . ' días' ?>
                                            </span>
                                        </div>
                                        <a href="detalle_oferta.php?id=<?= (int)$oferta['ID'] ?>" class="btn btn-details">
                                            Ver detalles <i class='bx bx-chevron-right'></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>

                <!-- Paginación -->
                <?php if ($totalPaginas > 1): ?>
                    <nav aria-label="Page navigation" class="mt-5">
                        <ul class="pagination justify-content-center">
                            <?php if ($pagina > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="empleos.php?<?=
                                                                            http_build_query(array_merge(
                                                                                $_GET,
                                                                                ['pagina' => $pagina - 1]
                                                                            ))
                                                                            ?>" aria-label="Previous">
                                        <i class='bx bx-chevron-left'></i>
                                    </a>
                                </li>
                            <?php endif; ?>

                            <?php for ($i = 1; $i <= $totalPaginas; $i++): ?>
                                <li class="page-item <?= $i == $pagina ? 'active' : '' ?>">
                                    <a class="page-link" href="empleos.php?<?=
                                                                            http_build_query(array_merge(
                                                                                $_GET,
                                                                                ['pagina' => $i]
                                                                            ))
                                                                            ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>

                            <?php if ($pagina < $totalPaginas): ?>
                                <li class="page-item">
                                    <a class="page-link" href="empleos.php?<?=
                                                                            http_build_query(array_merge(
                                                                                $_GET,
                                                                                ['pagina' => $pagina + 1]
                                                                            ))
                                                                            ?>" aria-label="Next">
                                        <i class='bx bx-chevron-right'></i>
                                    </a>
                                </li>
                            <?php endif; ?>
                        </ul>
                    </nav>
                <?php endif; ?>
            <?php else: ?>
                <div class="no-results">
                    <i class='bx bx-inbox'></i>
                    <h4>No se encontraron ofertas</h4>
                    <p>No hay ofertas disponibles con los filtros seleccionados</p>
                    <a href="empleos.php" class="btn btn-reload">
                        <i class='bx bx-reset me-1'></i> Reiniciar filtros
                    </a>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Footer Elegante -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="../index.php" class="footer-brand d-flex align-items-center mb-4">
                        <img src="../img/icono.jpeg" alt="Logo" width="30" height="30" class="me-2 rounded-circle">
                        ProgreUIB
                    </a>
                    <p class="footer-about">Conectando Educación y Trabajo desde el corazón del Chocó.</p>
                    <div class="social-links">
                        <a href="#"><i class='bx bxl-facebook'></i></a>
                        <a href="#"><i class='bx bxl-instagram'></i></a>
                        <a href="#"><i class='bx bxl-twitter'></i></a>
                        <a href="#"><i class='bx bxl-linkedin'></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-6 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h5>Navegación</h5>
                        <ul>
                            <li><a href="../index.php">Inicio</a></li>
                            <li><a href="../ofertas.php">Ofertas</a></li>
                            <li><a href="../register/register.php">Registro</a></li>
                            <li><a href="../login/login.php">Iniciar Sesión</a></li>
                            <li><a href="../contact/contact.php">Contacto</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h5>Contacto</h5>
                        <ul>
                            <li><i class='bx bx-envelope me-2'></i> contacto@progreuib.com</li>
                            <li><i class='bx bx-phone me-2'></i> +312 660 2583</li>
                            <li><i class='bx bx-map me-2'></i> Quibdó, Chocó - Colombia</li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6">
                    <div class="footer-links">
                        <h5>Newsletter</h5>
                        <p class="footer-about">Suscríbete para recibir las últimas ofertas.</p>
                        <form class="mt-4">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Tu correo">
                                <button class="btn btn-outline-light" type="button">
                                    <i class='bx bx-send'></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="mb-0">&copy; <?= date('Y') ?> <strong>ProgreUIB</strong>. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>

    <script>
        // Inicializar Select2
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Seleccione opciones",
                allowClear: true
            });

            // Manejar el envío del formulario con Select2
            $('#filterForm').on('submit', function() {
                $(this).find('.select2-hidden-accessible').prop('disabled', true);
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
        });
    </script>
</body>

</html>