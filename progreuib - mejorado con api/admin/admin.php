<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - ProgreUIB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="icon" href="../img/icono.jpeg">
    <style>
        :root {
            --primary-color: #0a192f;
            --secondary-color: #64ffda;
            --accent-color: #1e4a8a;
            --text-color: #ccd6f6;
            --light-bg: #112240;
            --card-bg: rgba(23, 42, 69, 0.7);
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f5f7fa;
            color: #333;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: var(--primary-color);
            color: white;
            padding: 1.5rem 0;
            position: fixed;
            height: 100vh;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .sidebar-header {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            color: var(--secondary-color);
            font-weight: 700;
            font-size: 1.3rem;
            text-decoration: none;
        }

        .sidebar-brand img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            margin-right: 10px;
            border: 1px solid var(--secondary-color);
            transition: all 0.3s ease;
        }

        .sidebar-brand:hover img {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
        }

        .sidebar-menu {
            padding: 1.5rem 0;
        }

        .menu-title {
            color: var(--secondary-color);
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 0 1.5rem;
            margin-bottom: 1rem;
        }

        .menu-item {
            display: flex;
            align-items: center;
            padding: 0.8rem 1.5rem;
            color: var(--text-color);
            text-decoration: none;
            transition: all 0.3s;
            border-left: 3px solid transparent;
        }

        .menu-item:hover,
        .menu-item.active {
            background: rgba(100, 255, 218, 0.1);
            color: var(--secondary-color);
            border-left: 3px solid var(--secondary-color);
        }

        .menu-item i {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 280px;
            padding: 2rem;
            background: #f5f7fa;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--primary-color);
        }

        .user-profile {
            display: flex;
            align-items: center;
        }

        .user-profile img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            border: 2px solid var(--secondary-color);
        }

        .user-info small {
            display: block;
            color: #666;
            font-size: 0.8rem;
        }

        /* Dashboard Cards */
        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .card {
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            transition: transform 0.3s;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-header {
            background: var(--primary-color);
            color: white;
            padding: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .card-header i {
            font-size: 1.5rem;
            color: var(--secondary-color);
        }

        .card-body {
            padding: 1.5rem;
            background: white;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #666;
            font-size: 0.9rem;
        }

        .stat-growth {
            display: flex;
            align-items: center;
            margin-top: 0.5rem;
            font-size: 0.9rem;
        }

        .stat-growth.up {
            color: #28a745;
        }

        .stat-growth.down {
            color: #dc3545;
        }

        /* Tables */
        .data-table {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 1.5rem;
            background: var(--primary-color);
            color: white;
        }

        .table-title {
            font-weight: 600;
        }

        .table-actions {
            display: flex;
            gap: 10px;
        }

        .btn-primary-admin {
            background: var(--secondary-color);
            color: var(--primary-color);
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary-admin:hover {
            background: #52e0c4;
            transform: translateY(-2px);
        }

        .btn-outline-admin {
            background: transparent;
            color: var(--secondary-color);
            border: 1px solid var(--secondary-color);
            padding: 0.5rem 1rem;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-outline-admin:hover {
            background: rgba(100, 255, 218, 0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: #f8f9fa;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: var(--primary-color);
        }

        td {
            padding: 1rem;
            border-top: 1px solid #eee;
        }

        :root {
            --badge-admin: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            --badge-worker: linear-gradient(135deg, #10b981 0%, #047857 100%);
            --badge-company: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            --badge-seller: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%);
        }

        .badge {
            padding: 0.45rem 0.9rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.75rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            backdrop-filter: blur(4px);
            box-shadow:
                0 2px 4px rgba(0, 0, 0, 0.05),
                0 1px 1px rgba(255, 255, 255, 0.1) inset;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
            border: none;
        }

        .badge::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(to bottom right,
                    rgba(255, 255, 255, 0.3) 0%,
                    rgba(255, 255, 255, 0) 60%);
            transform: rotate(30deg);
            pointer-events: none;
        }

        .badge:hover {
            transform: translateY(-1px);
            box-shadow:
                0 4px 6px rgba(0, 0, 0, 0.1),
                0 1px 3px rgba(0, 0, 0, 0.08),
                0 1px 1px rgba(255, 255, 255, 0.2) inset;
        }

        /* Badge Administrador - Azul futurista */
        .badge-primary {
            background: var(--badge-admin);
            color: white;
        }

        /* Badge Trabajador - Verde neón */
        .badge-success {
            background: var(--badge-worker);
            color: white;
        }

        /* Badge Empresa - Ámbar metálico */
        .badge-warning {
            background: var(--badge-company);
            color: #111827;
        }

        /* Badge Vendedor - Púrpura eléctrico */
        .badge-info {
            background: var(--badge-seller);
            color: white;
        }

        /* Efecto de luz dinámica */
        .badge i {
            font-size: 0.9em;
            filter: drop-shadow(0 1px 1px rgba(0, 0, 0, 0.2));
        }


        .action-btn {
            background: none;
            border: none;
            color: #666;
            margin: 0 5px;
            transition: all 0.3s;
        }

        .action-btn:hover {
            color: var(--secondary-color);
            transform: scale(1.2);
        }

        /* Form Styles */
        .form-container {
            background: white;
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .form-label {
            font-weight: 600;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .form-control {
            padding: 0.75rem 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 1rem;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(100, 255, 218, 0.25);
        }

        /* Modal Styles */
        .modal-header {
            background: var(--primary-color);
            color: white;
        }

        .btn-close-white {
            filter: invert(1);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .sidebar {
                width: 80px;
                overflow: hidden;
            }

            .sidebar-brand span,
            .menu-title,
            .menu-item span {
                display: none;
            }

            .menu-item {
                justify-content: center;
                padding: 1rem;
            }

            .menu-item i {
                margin-right: 0;
                font-size: 1.5rem;
            }

            .main-content {
                margin-left: 80px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
            }

            .header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .table-header {
                flex-direction: column;
                gap: 1rem;
                align-items: flex-start;
            }

            .table-actions {
                width: 100%;
                justify-content: flex-end;
            }
        }

        @media (max-width: 576px) {
            .main-content {
                padding: 1rem;
            }

            .card-body {
                padding: 1rem;
            }

            th,
            td {
                padding: 0.75rem 0.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <a href="#" class="sidebar-brand">
                    <img src="../img/icono.jpeg" alt="ProgreUIB">
                    <span>ProgreUIB</span>
                </a>
            </div>

            <div class="sidebar-menu">
                <h6 class="menu-title">Principal</h6>
                <a href="dashboard.php" class="menu-item active">
                    <i class='bx bx-home'></i>
                    <span>Panel</span>
                </a>

                <h6 class="menu-title">Gestión</h6>
                <a href="usuarios.php" class="menu-item">
                    <i class='bx bx-user'></i>
                    <span>Usuarios</span>
                </a>
                <a href="empresas.php" class="menu-item">
                    <i class='bx bx-building'></i>
                    <span>Empresas</span>
                </a>
                <a href="ofertas.php" class="menu-item">
                    <i class='bx bx-briefcase'></i>
                    <span>Ofertas</span>
                </a>

                <h6 class="menu-title">Reportes</h6>
                <a href="reportes.php" class="menu-item">
                    <i class='bx bx-bar-chart'></i>
                    <span>Estadísticas</span>
                </a>
                <a href="logs.php" class="menu-item">
                    <i class='bx bx-file'></i>
                    <span>Registros</span>
                </a>

                <h6 class="menu-title">Configuración</h6>
                <a href="configuracion.php" class="menu-item">
                    <i class='bx bx-cog'></i>
                    <span>Ajustes</span>
                </a>
                <a href="../logout.php" class="menu-item">
                    <i class='bx bx-log-out'></i>
                    <span>Cerrar Sesión</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="header">
                <h1 class="page-title">Panel De Administrador</h1>

                <div class="user-profile">
                    <img src="img/user-profile.jpg" alt="Usuario">
                    <div class="user-info">
                        <strong>Sharly</strong>
                        <small>Administrador</small>
                    </div>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <div class="dashboard-cards">
                <div class="card">
                    <div class="card-header">
                        <span>Usuarios Registrados</span>
                        <i class='bx bx-user'></i>
                    </div>
                    <div class="card-body">
                        <div class="stat-number">26</div>
                        <div class="stat-label">Total de usuarios</div>
                        <div class="stat-growth up">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span>12% desde el mes pasado</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span>Empresas</span>
                        <i class='bx bx-building'></i>
                    </div>
                    <div class="card-body">
                        <div class="stat-number">3</div>
                        <div class="stat-label">Empresas registradas</div>
                        <div class="stat-growth up">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span>5% desde el mes pasado</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span>Ofertas Activas</span>
                        <i class='bx bx-briefcase'></i>
                    </div>
                    <div class="card-body">
                        <div class="stat-number">3</div>
                        <div class="stat-label">Ofertas publicadas</div>
                        <div class="stat-growth down">
                            <i class='bx bx-down-arrow-alt'></i>
                            <span>2% desde el mes pasado</span>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <span>Solicitudes</span>
                        <i class='bx bx-envelope'></i>
                    </div>
                    <div class="card-body">
                        <div class="stat-number">12</div>
                        <div class="stat-label">Nuevas solicitudes</div>
                        <div class="stat-growth up">
                            <i class='bx bx-up-arrow-alt'></i>
                            <span>8% desde ayer</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Users Table -->
            <div class="data-table mb-4">
                <div class="table-header">
                    <h3 class="table-title">Últimos Usuarios Registrados</h3>
                    <div class="table-actions">
                        <button class="btn btn-primary-admin" data-bs-toggle="modal" data-bs-target="#nuevoUsuarioModal">
                            <i class='bx bx-plus'></i> Nuevo Usuario
                        </button>
                        <button class="btn btn-outline-admin" id="filtrarUsuariosBtn">
                            <i class='bx bx-filter'></i> Filtrar
                        </button>
                    </div>
                </div>

                <table id="tablaUsuarios">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Registro</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>26</td>
                            <td>Daniel</td>
                            <td>daniel@hotmail.com</td>
                            <td><span class="badge badge-primary">Administrador</span></td>
                            <td>2025-05-17</td>
                            <td>
                                <button class="action-btn" title="Editar">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="action-btn" title="Eliminar">
                                    <i class='bx bx-trash'></i>
                                </button>
                                <button class="action-btn" title="Ver detalles">
                                    <i class='bx bx-show'></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>25</td>
                            <td>Andres</td>
                            <td>andres@gmail.com</td>
                            <td><span class="badge badge-success">Trabajador</span></td>
                            <td>2025-05-15</td>
                            <td>
                                <button class="action-btn" title="Editar">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="action-btn" title="Eliminar">
                                    <i class='bx bx-trash'></i>
                                </button>
                                <button class="action-btn" title="Ver detalles">
                                    <i class='bx bx-show'></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td>24</td>
                            <td>Tecnoloclik</td>
                            <td>sinergia@gmail.com</td>
                            <td><span class="badge badge-warning">Empresa</span></td>
                            <td>2025-05-13</td>
                            <td>
                                <button class="action-btn" title="Editar">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="action-btn" title="Eliminar">
                                    <i class='bx bx-trash'></i>
                                </button>
                                <button class="action-btn" title="Ver detalles">
                                    <i class='bx bx-show'></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Recent Job Offers -->
            <div class="data-table">
                <div class="table-header">
                    <h3 class="table-title">Últimas Ofertas Publicadas</h3>
                    <div class="table-actions">
                        <button class="btn btn-primary-admin" data-bs-toggle="modal" data-bs-target="#nuevaOfertaModal">
                            <i class='bx bx-plus'></i> Nueva Oferta
                        </button>
                        <button class="btn btn-outline-admin" id="filtrarOfertasBtn">
                            <i class='bx bx-filter'></i> Filtrar
                        </button>
                    </div>
                </div>

                <table id="tablaOfertas">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Empresa</th>
                            <th>Área</th>
                            <th>Modalidad</th>
                            <th>Salario</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Diseñador Grafico</td>
                            <td>Tecnoloclik</td>
                            <td>Tecnología</td>
                            <td>Presencial</td>
                            <td>$4.600.000</td>
                            <td><span class="badge badge-success">Activa</span></td>
                            <td>
                                <button class="action-btn" title="Editar">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="action-btn" title="Eliminar">
                                    <i class='bx bx-trash'></i>
                                </button>
                                <button class="action-btn" title="Ver detalles">
                                    <i class='bx bx-show'></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal para Nuevo Usuario -->
    <div class="modal fade" id="nuevoUsuarioModal" tabindex="-1" aria-labelledby="nuevoUsuarioModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoUsuarioModalLabel">Nuevo Usuario</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formUsuario">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="nombreUsuario" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="nombreUsuario" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="correoUsuario" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correoUsuario" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="passwordUsuario" class="form-label">Contraseña</label>
                                    <input type="password" class="form-control" id="passwordUsuario" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="confirmPassword" class="form-label">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" id="confirmPassword" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rolUsuario" class="form-label">Rol</label>
                                    <select class="form-select" id="rolUsuario" required>
                                        <option value="">Seleccionar Rol</option>
                                        <option value="Trabajador">Trabajador</option>
                                        <option value="Empresa">Empresa</option>
                                        <option value="Administrador">Administrador</option>
                                        <option value="Vendedor">Vendedor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="areaUsuario" class="form-label">Área/Especialidad</label>
                                    <input type="text" class="form-control" id="areaUsuario">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary-admin" id="guardarUsuarioBtn">Guardar Usuario</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nueva Oferta -->
    <div class="modal fade" id="nuevaOfertaModal" tabindex="-1" aria-labelledby="nuevaOfertaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaOfertaModalLabel">Nueva Oferta Laboral</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formOferta">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tituloOferta" class="form-label">Título</label>
                                    <input type="text" class="form-control" id="tituloOferta" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="empresaOferta" class="form-label">Empresa</label>
                                    <select class="form-select" id="empresaOferta" required>
                                        <option value="">Seleccionar Empresa</option>
                                        <option value="24">Tecnoloclik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="descripcionOferta" class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionOferta" rows="3" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="requisitosOferta" class="form-label">Requisitos</label>
                            <textarea class="form-control" id="requisitosOferta" rows="2"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="areaOferta" class="form-label">Área</label>
                                    <input type="text" class="form-control" id="areaOferta" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ubicacionOferta" class="form-label">Ubicación</label>
                                    <input type="text" class="form-control" id="ubicacionOferta">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tipoContratoOferta" class="form-label">Tipo de Contrato</label>
                                    <input type="text" class="form-control" id="tipoContratoOferta">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="salarioOferta" class="form-label">Salario</label>
                                    <input type="text" class="form-control" id="salarioOferta">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="modalidadOferta" class="form-label">Modalidad</label>
                                    <select class="form-select" id="modalidadOferta">
                                        <option value="Presencial">Presencial</option>
                                        <option value="Remoto">Remoto</option>
                                        <option value="Híbrido">Híbrido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="estadoOferta" class="form-label">Estado</label>
                                    <select class="form-select" id="estadoOferta">
                                        <option value="Activa">Activa</option>
                                        <option value="Inactiva">Inactiva</option>
                                        <option value="Cerrada">Cerrada</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="vacantesOferta" class="form-label">Vacantes</label>
                                    <input type="number" class="form-control" id="vacantesOferta" value="1" min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fechaExpiracionOferta" class="form-label">Fecha de Expiración</label>
                                    <input type="date" class="form-control" id="fechaExpiracionOferta">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary-admin" id="guardarOfertaBtn">Publicar Oferta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Detalles/Edición -->
    <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detallesModalLabel">Detalles</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detallesModalBody">
                    <!-- El contenido se cargará dinámicamente -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary-admin" id="guardarCambiosBtn" style="display: none;">Guardar Cambios</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación -->
    <div class="modal fade" id="confirmacionModal" tabindex="-1" aria-labelledby="confirmacionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmacionModalLabel">Confirmar Acción</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmacionModalBody">
                    ¿Estás seguro de que deseas eliminar este elemento?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmarAccionBtn">Confirmar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Variables globales
        let elementoActual = null;
        let accionActual = null;
        let usuarios = [{
                ID: 26,
                Nombre: 'Daniel',
                Correo: 'daniel@hotmail.com',
                Rol: 'Administrador',
                Fecha_Registro: '2025-05-17'
            },
            {
                ID: 25,
                Nombre: 'Andres',
                Correo: 'andres@gmail.com',
                Rol: 'Trabajador',
                Fecha_Registro: '2025-05-15',
                Area: 'Educación',
                Especialidad: 'Docente'
            },
            {
                ID: 24,
                Nombre: 'Tecnoloclik',
                Correo: 'sinergia@gmail.com',
                Rol: 'Empresa',
                Fecha_Registro: '2025-05-13',
                Area: 'Salud',
                Especialidad: 'Desarrollo Web'
            }
        ];

        let empresas = [{
            ID: 24,
            Nombre: 'Tecnoloclik',
            Correo: 'sinergia@gmail.com'
        }];

        let ofertas = [{
            ID: 1,
            Titulo: 'Diseñador Grafico',
            Empresa_id: 24,
            Empresa: 'Tecnoloclik',
            Descripcion: 'Se requiere un diseñador web con 20 años de experiencia',
            Requisitos: '20 años de experiencia. Titulo de Ing Software',
            Area: 'Tecnología',
            Ubicacion: 'Quibdo,Choco',
            Tipo_Contrato: 'Tiempo Completo',
            Salario: '$4.600.000',
            Modalidad: 'Presencial',
            Estado: 'Activa',
            Vacantes: 1,
            Fecha_Publicacion: '2025-05-14',
            Fecha_Expiracion: '2025-06-13'
        }];

        // Cuando el documento esté listo
        document.addEventListener('DOMContentLoaded', function() {
            // Configurar eventos
            configurarEventos();
        });

        // Función para configurar eventos
        function configurarEventos() {
            // Botón para guardar nuevo usuario
            document.getElementById('guardarUsuarioBtn').addEventListener('click', guardarUsuario);

            // Botón para guardar nueva oferta
            document.getElementById('guardarOfertaBtn').addEventListener('click', guardarOferta);

            // Botón para guardar cambios en edición
            document.getElementById('guardarCambiosBtn').addEventListener('click', guardarCambios);

            // Botón para confirmar acciones (eliminar)
            document.getElementById('confirmarAccionBtn').addEventListener('click', ejecutarAccionConfirmada);

            // Botones de filtrado
            document.getElementById('filtrarUsuariosBtn').addEventListener('click', mostrarFiltroUsuarios);
            document.getElementById('filtrarOfertasBtn').addEventListener('click', mostrarFiltroOfertas);

            // Delegación de eventos para los botones de acción en las tablas
            document.addEventListener('click', function(e) {
                if (e.target.closest('.action-btn')) {
                    const btn = e.target.closest('.action-btn');
                    const accion = btn.getAttribute('title');
                    const fila = btn.closest('tr');
                    const id = fila.querySelector('td:first-child').textContent;

                    manejarAccion(accion, id);
                }
            });
        }

        // Función para manejar las acciones (editar, eliminar, ver detalles)
        function manejarAccion(accion, id) {
            elementoActual = id;
            accionActual = accion;

            if (accion === 'Editar') {
                mostrarFormularioEdicion(id);
            } else if (accion === 'Eliminar') {
                mostrarConfirmacionEliminar(id);
            } else if (accion === 'Ver detalles') {
                mostrarDetalles(id);
            }
        }

        // Función para mostrar el formulario de edición
        function mostrarFormularioEdicion(id) {
            // Determinar si es un usuario o una oferta
            const esUsuario = usuarios.some(u => u.ID == id);
            const esOferta = ofertas.some(o => o.ID == id);

            const modal = new bootstrap.Modal(document.getElementById('detallesModal'));
            const tituloModal = document.getElementById('detallesModalLabel');
            const cuerpoModal = document.getElementById('detallesModalBody');
            const btnGuardar = document.getElementById('guardarCambiosBtn');

            if (esUsuario) {
                const usuario = usuarios.find(u => u.ID == id);
                tituloModal.textContent = `Editar Usuario: ${usuario.Nombre}`;

                cuerpoModal.innerHTML = `
                    <form id="formEditarUsuario">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editNombreUsuario" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="editNombreUsuario" value="${usuario.Nombre}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editCorreoUsuario" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="editCorreoUsuario" value="${usuario.Correo}" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editRolUsuario" class="form-label">Rol</label>
                                    <select class="form-select" id="editRolUsuario" required>
                                        <option value="Trabajador" ${usuario.Rol === 'Trabajador' ? 'selected' : ''}>Trabajador</option>
                                        <option value="Empresa" ${usuario.Rol === 'Empresa' ? 'selected' : ''}>Empresa</option>
                                        <option value="Administrador" ${usuario.Rol === 'Administrador' ? 'selected' : ''}>Administrador</option>
                                        <option value="Vendedor" ${usuario.Rol === 'Vendedor' ? 'selected' : ''}>Vendedor</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editAreaUsuario" class="form-label">Área/Especialidad</label>
                                    <input type="text" class="form-control" id="editAreaUsuario" value="${usuario.Area || ''}">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editPasswordUsuario" class="form-label">Nueva Contraseña (opcional)</label>
                            <input type="password" class="form-control" id="editPasswordUsuario">
                        </div>
                    </form>
                `;

                btnGuardar.style.display = 'block';
                modal.show();

            } else if (esOferta) {
                const oferta = ofertas.find(o => o.ID == id);
                tituloModal.textContent = `Editar Oferta: ${oferta.Titulo}`;

                cuerpoModal.innerHTML = `
                    <form id="formEditarOferta">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editTituloOferta" class="form-label">Título</label>
                                    <input type="text" class="form-control" id="editTituloOferta" value="${oferta.Titulo}" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editEmpresaOferta" class="form-label">Empresa</label>
                                    <select class="form-select" id="editEmpresaOferta" required>
                                        <option value="24" ${oferta.Empresa_id == 24 ? 'selected' : ''}>Tecnoloclik</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editDescripcionOferta" class="form-label">Descripción</label>
                            <textarea class="form-control" id="editDescripcionOferta" rows="3" required>${oferta.Descripcion}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editRequisitosOferta" class="form-label">Requisitos</label>
                            <textarea class="form-control" id="editRequisitosOferta" rows="2">${oferta.Requisitos || ''}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editAreaOferta" class="form-label">Área</label>
                                    <input type="text" class="form-control" id="editAreaOferta" value="${oferta.Area}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editUbicacionOferta" class="form-label">Ubicación</label>
                                    <input type="text" class="form-control" id="editUbicacionOferta" value="${oferta.Ubicacion || ''}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editTipoContratoOferta" class="form-label">Tipo de Contrato</label>
                                    <input type="text" class="form-control" id="editTipoContratoOferta" value="${oferta.Tipo_Contrato || ''}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editSalarioOferta" class="form-label">Salario</label>
                                    <input type="text" class="form-control" id="editSalarioOferta" value="${oferta.Salario || ''}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editModalidadOferta" class="form-label">Modalidad</label>
                                    <select class="form-select" id="editModalidadOferta">
                                        <option value="Presencial" ${oferta.Modalidad === 'Presencial' ? 'selected' : ''}>Presencial</option>
                                        <option value="Remoto" ${oferta.Modalidad === 'Remoto' ? 'selected' : ''}>Remoto</option>
                                        <option value="Híbrido" ${oferta.Modalidad === 'Híbrido' ? 'selected' : ''}>Híbrido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="editEstadoOferta" class="form-label">Estado</label>
                                    <select class="form-select" id="editEstadoOferta">
                                        <option value="Activa" ${oferta.Estado === 'Activa' ? 'selected' : ''}>Activa</option>
                                        <option value="Inactiva" ${oferta.Estado === 'Inactiva' ? 'selected' : ''}>Inactiva</option>
                                        <option value="Cerrada" ${oferta.Estado === 'Cerrada' ? 'selected' : ''}>Cerrada</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editVacantesOferta" class="form-label">Vacantes</label>
                                    <input type="number" class="form-control" id="editVacantesOferta" value="${oferta.Vacantes || 1}" min="1">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editFechaExpiracionOferta" class="form-label">Fecha de Expiración</label>
                                    <input type="date" class="form-control" id="editFechaExpiracionOferta" value="${oferta.Fecha_Expiracion ? oferta.Fecha_Expiracion.split(' ')[0] : ''}">
                                </div>
                            </div>
                        </div>
                    </form>
                `;

                btnGuardar.style.display = 'block';
                modal.show();
            }
        }

        // Función para mostrar confirmación de eliminación
        function mostrarConfirmacionEliminar(id) {
            const esUsuario = usuarios.some(u => u.ID == id);
            const esOferta = ofertas.some(o => o.ID == id);

            const modal = new bootstrap.Modal(document.getElementById('confirmacionModal'));
            const cuerpoModal = document.getElementById('confirmacionModalBody');

            if (esUsuario) {
                const usuario = usuarios.find(u => u.ID == id);
                cuerpoModal.innerHTML = `¿Estás seguro de que deseas eliminar al usuario <strong>${usuario.Nombre}</strong> (${usuario.Correo})?`;
            } else if (esOferta) {
                const oferta = ofertas.find(o => o.ID == id);
                cuerpoModal.innerHTML = `¿Estás seguro de que deseas eliminar la oferta <strong>${oferta.Titulo}</strong>?`;
            }

            modal.show();
        }

        // Función para mostrar detalles
        function mostrarDetalles(id) {
            const esUsuario = usuarios.some(u => u.ID == id);
            const esOferta = ofertas.some(o => o.ID == id);

            const modal = new bootstrap.Modal(document.getElementById('detallesModal'));
            const tituloModal = document.getElementById('detallesModalLabel');
            const cuerpoModal = document.getElementById('detallesModalBody');
            const btnGuardar = document.getElementById('guardarCambiosBtn');

            if (esUsuario) {
                const usuario = usuarios.find(u => u.ID == id);
                tituloModal.textContent = `Detalles del Usuario: ${usuario.Nombre}`;

                cuerpoModal.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>ID:</strong> ${usuario.ID}</p>
                            <p><strong>Nombre:</strong> ${usuario.Nombre}</p>
                            <p><strong>Correo:</strong> ${usuario.Correo}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Rol:</strong> ${usuario.Rol}</p>
                            <p><strong>Área:</strong> ${usuario.Area || 'No especificado'}</p>
                            <p><strong>Especialidad:</strong> ${usuario.Especialidad || 'No especificada'}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Fecha de Registro:</strong> ${formatearFecha(usuario.Fecha_Registro)}</p>
                        </div>
                    </div>
                `;

                btnGuardar.style.display = 'none';
                modal.show();

            } else if (esOferta) {
                const oferta = ofertas.find(o => o.ID == id);
                const empresa = empresas.find(e => e.ID === oferta.Empresa_id) || {
                    Nombre: 'Desconocida'
                };

                tituloModal.textContent = `Detalles de la Oferta: ${oferta.Titulo}`;

                cuerpoModal.innerHTML = `
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Título:</strong> ${oferta.Titulo}</p>
                            <p><strong>Empresa:</strong> ${empresa.Nombre}</p>
                            <p><strong>Área:</strong> ${oferta.Area}</p>
                            <p><strong>Modalidad:</strong> ${oferta.Modalidad}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Salario:</strong> ${oferta.Salario || 'No especificado'}</p>
                            <p><strong>Estado:</strong> ${oferta.Estado}</p>
                            <p><strong>Vacantes:</strong> ${oferta.Vacantes || 1}</p>
                            <p><strong>Fecha Publicación:</strong> ${formatearFecha(oferta.Fecha_Publicacion)}</p>
                            ${oferta.Fecha_Expiracion ? `<p><strong>Fecha Expiración:</strong> ${formatearFecha(oferta.Fecha_Expiracion)}</p>` : ''}
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Descripción</h5>
                            <p>${oferta.Descripcion}</p>
                        </div>
                    </div>
                    ${oferta.Requisitos ? `
                    <div class="row mt-3">
                        <div class="col-12">
                            <h5>Requisitos</h5>
                            <p>${oferta.Requisitos}</p>
                        </div>
                    </div>
                    ` : ''}
                `;

                btnGuardar.style.display = 'none';
                modal.show();
            }
        }

        // Función para ejecutar la acción confirmada (eliminar)
        function ejecutarAccionConfirmada() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('confirmacionModal'));

            // Determinar si es un usuario o una oferta
            const esUsuario = usuarios.some(u => u.ID == elementoActual);
            const esOferta = ofertas.some(o => o.ID == elementoActual);

            if (esUsuario) {
                // Simulación de eliminación - en producción sería una petición AJAX
                usuarios = usuarios.filter(u => u.ID != elementoActual);
                actualizarTablaUsuarios();
                mostrarAlerta('Éxito', 'Usuario eliminado correctamente', 'success');
            } else if (esOferta) {
                // Simulación de eliminación - en producción sería una petición AJAX
                ofertas = ofertas.filter(o => o.ID != elementoActual);
                actualizarTablaOfertas();
                mostrarAlerta('Éxito', 'Oferta eliminada correctamente', 'success');
            }

            modal.hide();
        }

        // Función para guardar un nuevo usuario
        function guardarUsuario() {
            const nombre = document.getElementById('nombreUsuario').value;
            const correo = document.getElementById('correoUsuario').value;
            const password = document.getElementById('passwordUsuario').value;
            const confirmPassword = document.getElementById('confirmPassword').value;
            const rol = document.getElementById('rolUsuario').value;
            const area = document.getElementById('areaUsuario').value;

            // Validaciones básicas
            if (password !== confirmPassword) {
                mostrarAlerta('Error', 'Las contraseñas no coinciden', 'error');
                return;
            }

            if (!nombre || !correo || !password || !rol) {
                mostrarAlerta('Error', 'Todos los campos obligatorios deben estar completos', 'error');
                return;
            }

            // Simulación de guardado - en producción sería una petición AJAX
            const nuevoId = Math.max(...usuarios.map(u => u.ID)) + 1;
            const nuevoUsuario = {
                ID: nuevoId,
                Nombre: nombre,
                Correo: correo,
                Rol: rol,
                Area: area,
                Fecha_Registro: new Date().toISOString()
            };

            usuarios.push(nuevoUsuario);
            actualizarTablaUsuarios();
            mostrarAlerta('Éxito', 'Usuario creado correctamente', 'success');

            // Cerrar el modal y limpiar el formulario
            const modal = bootstrap.Modal.getInstance(document.getElementById('nuevoUsuarioModal'));
            modal.hide();
            document.getElementById('formUsuario').reset();
        }

        // Función para guardar una nueva oferta
        function guardarOferta() {
            const titulo = document.getElementById('tituloOferta').value;
            const empresaId = document.getElementById('empresaOferta').value;
            const descripcion = document.getElementById('descripcionOferta').value;
            const requisitos = document.getElementById('requisitosOferta').value;
            const area = document.getElementById('areaOferta').value;
            const ubicacion = document.getElementById('ubicacionOferta').value;
            const tipoContrato = document.getElementById('tipoContratoOferta').value;
            const salario = document.getElementById('salarioOferta').value;
            const modalidad = document.getElementById('modalidadOferta').value;
            const estado = document.getElementById('estadoOferta').value;
            const vacantes = document.getElementById('vacantesOferta').value;
            const fechaExpiracion = document.getElementById('fechaExpiracionOferta').value;

            // Validaciones básicas
            if (!titulo || !empresaId || !descripcion || !area) {
                mostrarAlerta('Error', 'Todos los campos obligatorios deben estar completos', 'error');
                return;
            }

            // Simulación de guardado - en producción sería una petición AJAX
            const nuevaId = Math.max(...ofertas.map(o => o.ID)) + 1;
            const empresa = empresas.find(e => e.ID == empresaId);

            const nuevaOferta = {
                ID: nuevaId,
                Titulo: titulo,
                Empresa_id: empresaId,
                Empresa: empresa ? empresa.Nombre : 'Desconocida',
                Descripcion: descripcion,
                Requisitos: requisitos,
                Area: area,
                Ubicacion: ubicacion,
                Tipo_Contrato: tipoContrato,
                Salario: salario,
                Modalidad: modalidad,
                Estado: estado,
                Vacantes: vacantes,
                Fecha_Publicacion: new Date().toISOString(),
                Fecha_Expiracion: fechaExpiracion ? new Date(fechaExpiracion).toISOString() : null
            };

            ofertas.push(nuevaOferta);
            actualizarTablaOfertas();
            mostrarAlerta('Éxito', 'Oferta creada correctamente', 'success');

            // Cerrar el modal y limpiar el formulario
            const modal = bootstrap.Modal.getInstance(document.getElementById('nuevaOfertaModal'));
            modal.hide();
            document.getElementById('formOferta').reset();
        }

        // Función para guardar cambios en edición
        function guardarCambios() {
            const modal = bootstrap.Modal.getInstance(document.getElementById('detallesModal'));

            // Determinar si es un usuario o una oferta
            const esUsuario = usuarios.some(u => u.ID == elementoActual);
            const esOferta = ofertas.some(o => o.ID == elementoActual);

            if (esUsuario) {
                const nombre = document.getElementById('editNombreUsuario').value;
                const correo = document.getElementById('editCorreoUsuario').value;
                const rol = document.getElementById('editRolUsuario').value;
                const area = document.getElementById('editAreaUsuario').value;

                // Simulación de actualización - en producción sería una petición AJAX
                const index = usuarios.findIndex(u => u.ID == elementoActual);
                if (index !== -1) {
                    usuarios[index] = {
                        ...usuarios[index],
                        Nombre: nombre,
                        Correo: correo,
                        Rol: rol,
                        Area: area
                    };

                    actualizarTablaUsuarios();
                    mostrarAlerta('Éxito', 'Usuario actualizado correctamente', 'success');
                    modal.hide();
                }

            } else if (esOferta) {
                const titulo = document.getElementById('editTituloOferta').value;
                const empresaId = document.getElementById('editEmpresaOferta').value;
                const descripcion = document.getElementById('editDescripcionOferta').value;
                const requisitos = document.getElementById('editRequisitosOferta').value;
                const area = document.getElementById('editAreaOferta').value;
                const ubicacion = document.getElementById('editUbicacionOferta').value;
                const tipoContrato = document.getElementById('editTipoContratoOferta').value;
                const salario = document.getElementById('editSalarioOferta').value;
                const modalidad = document.getElementById('editModalidadOferta').value;
                const estado = document.getElementById('editEstadoOferta').value;
                const vacantes = document.getElementById('editVacantesOferta').value;
                const fechaExpiracion = document.getElementById('editFechaExpiracionOferta').value;

                // Simulación de actualización - en producción sería una petición AJAX
                const index = ofertas.findIndex(o => o.ID == elementoActual);
                if (index !== -1) {
                    const empresa = empresas.find(e => e.ID == empresaId);

                    ofertas[index] = {
                        ...ofertas[index],
                        Titulo: titulo,
                        Empresa_id: empresaId,
                        Empresa: empresa ? empresa.Nombre : 'Desconocida',
                        Descripcion: descripcion,
                        Requisitos: requisitos,
                        Area: area,
                        Ubicacion: ubicacion,
                        Tipo_Contrato: tipoContrato,
                        Salario: salario,
                        Modalidad: modalidad,
                        Estado: estado,
                        Vacantes: vacantes,
                        Fecha_Expiracion: fechaExpiracion ? new Date(fechaExpiracion).toISOString() : null
                    };

                    actualizarTablaOfertas();
                    mostrarAlerta('Éxito', 'Oferta actualizada correctamente', 'success');
                    modal.hide();
                }
            }
        }

        // Función para actualizar la tabla de usuarios
        function actualizarTablaUsuarios() {
            const tbody = document.querySelector('#tablaUsuarios tbody');
            tbody.innerHTML = '';

            usuarios.forEach(usuario => {
                const fila = document.createElement('tr');
                let badgeClass = 'badge-primary';

                if (usuario.Rol === 'Trabajador') badgeClass = 'badge-success';
                else if (usuario.Rol === 'Empresa') badgeClass = 'badge-warning';

                fila.innerHTML = `
                    <td>${usuario.ID}</td>
                    <td>${usuario.Nombre}</td>
                    <td>${usuario.Correo}</td>
                    <td><span class="badge ${badgeClass}">${usuario.Rol}</span></td>
                    <td>${formatearFecha(usuario.Fecha_Registro)}</td>
                    <td>
                        <button class="action-btn" title="Editar">
                            <i class='bx bx-edit'></i>
                        </button>
                        <button class="action-btn" title="Eliminar">
                            <i class='bx bx-trash'></i>
                        </button>
                        <button class="action-btn" title="Ver detalles">
                            <i class='bx bx-show'></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(fila);
            });
        }

        // Función para actualizar la tabla de ofertas
        function actualizarTablaOfertas() {
            const tbody = document.querySelector('#tablaOfertas tbody');
            tbody.innerHTML = '';

            ofertas.forEach(oferta => {
                const empresa = empresas.find(e => e.ID === oferta.Empresa_id) || {
                    Nombre: 'Desconocida'
                };
                const badgeClass = oferta.Estado === 'Activa' ? 'badge-success' :
                    oferta.Estado === 'Cerrada' ? 'badge-warning' : 'badge-primary';

                const fila = document.createElement('tr');
                fila.innerHTML = `
                    <td>${oferta.Titulo}</td>
                    <td>${empresa.Nombre}</td>
                    <td>${oferta.Area}</td>
                    <td>${oferta.Modalidad}</td>
                    <td>${oferta.Salario || 'No especificado'}</td>
                    <td><span class="badge ${badgeClass}">${oferta.Estado}</span></td>
                    <td>
                        <button class="action-btn" title="Editar">
                            <i class='bx bx-edit'></i>
                        </button>
                        <button class="action-btn" title="Eliminar">
                            <i class='bx bx-trash'></i>
                        </button>
                        <button class="action-btn" title="Ver detalles">
                            <i class='bx bx-show'></i>
                        </button>
                    </td>
                `;
                tbody.appendChild(fila);
            });
        }

        // Función para mostrar filtro de usuarios
        function mostrarFiltroUsuarios() {
            Swal.fire({
                title: 'Filtrar Usuarios',
                html: `
                    <div class="mb-3">
                        <label for="filtroRol" class="form-label">Rol</label>
                        <select class="form-select" id="filtroRol">
                            <option value="">Todos</option>
                            <option value="Trabajador">Trabajador</option>
                            <option value="Empresa">Empresa</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Vendedor">Vendedor</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filtroFechaDesde" class="form-label">Fecha Desde</label>
                        <input type="date" class="form-control" id="filtroFechaDesde">
                    </div>
                    <div class="mb-3">
                        <label for="filtroFechaHasta" class="form-label">Fecha Hasta</label>
                        <input type="date" class="form-control" id="filtroFechaHasta">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Aplicar Filtro',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const rol = document.getElementById('filtroRol').value;
                    const fechaDesde = document.getElementById('filtroFechaDesde').value;
                    const fechaHasta = document.getElementById('filtroFechaHasta').value;

                    // Aquí aplicarías el filtro a los datos
                    let usuariosFiltrados = [...usuarios];

                    if (rol) {
                        usuariosFiltrados = usuariosFiltrados.filter(u => u.Rol === rol);
                    }

                    if (fechaDesde) {
                        usuariosFiltrados = usuariosFiltrados.filter(u => new Date(u.Fecha_Registro) >= new Date(fechaDesde));
                    }

                    if (fechaHasta) {
                        usuariosFiltrados = usuariosFiltrados.filter(u => new Date(u.Fecha_Registro) <= new Date(fechaHasta));
                    }

                    // Actualizar la tabla con los usuarios filtrados
                    const tbody = document.querySelector('#tablaUsuarios tbody');
                    tbody.innerHTML = '';

                    usuariosFiltrados.forEach(usuario => {
                        const fila = document.createElement('tr');
                        let badgeClass = 'badge-primary';

                        if (usuario.Rol === 'Trabajador') badgeClass = 'badge-success';
                        else if (usuario.Rol === 'Empresa') badgeClass = 'badge-warning';

                        fila.innerHTML = `
                            <td>${usuario.ID}</td>
                            <td>${usuario.Nombre}</td>
                            <td>${usuario.Correo}</td>
                            <td><span class="badge ${badgeClass}">${usuario.Rol}</span></td>
                            <td>${formatearFecha(usuario.Fecha_Registro)}</td>
                            <td>
                                <button class="action-btn" title="Editar">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="action-btn" title="Eliminar">
                                    <i class='bx bx-trash'></i>
                                </button>
                                <button class="action-btn" title="Ver detalles">
                                    <i class='bx bx-show'></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(fila);
                    });

                    return usuariosFiltrados;
                }
            });
        }

        // Función para mostrar filtro de ofertas
        function mostrarFiltroOfertas() {
            Swal.fire({
                title: 'Filtrar Ofertas',
                html: `
                    <div class="mb-3">
                        <label for="filtroEstadoOferta" class="form-label">Estado</label>
                        <select class="form-select" id="filtroEstadoOferta">
                            <option value="">Todos</option>
                            <option value="Activa">Activa</option>
                            <option value="Inactiva">Inactiva</option>
                            <option value="Cerrada">Cerrada</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filtroModalidadOferta" class="form-label">Modalidad</label>
                        <select class="form-select" id="filtroModalidadOferta">
                            <option value="">Todas</option>
                            <option value="Presencial">Presencial</option>
                            <option value="Remoto">Remoto</option>
                            <option value="Híbrido">Híbrido</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="filtroAreaOferta" class="form-label">Área</label>
                        <input type="text" class="form-control" id="filtroAreaOferta" placeholder="Ej: Tecnología">
                    </div>
                `,
                showCancelButton: true,
                confirmButtonText: 'Aplicar Filtro',
                cancelButtonText: 'Cancelar',
                preConfirm: () => {
                    const estado = document.getElementById('filtroEstadoOferta').value;
                    const modalidad = document.getElementById('filtroModalidadOferta').value;
                    const area = document.getElementById('filtroAreaOferta').value;

                    // Aquí aplicarías el filtro a los datos
                    let ofertasFiltradas = [...ofertas];

                    if (estado) {
                        ofertasFiltradas = ofertasFiltradas.filter(o => o.Estado === estado);
                    }

                    if (modalidad) {
                        ofertasFiltradas = ofertasFiltradas.filter(o => o.Modalidad === modalidad);
                    }

                    if (area) {
                        ofertasFiltradas = ofertasFiltradas.filter(o =>
                            o.Area.toLowerCase().includes(area.toLowerCase())
                        );
                    }

                    // Actualizar la tabla con las ofertas filtradas
                    const tbody = document.querySelector('#tablaOfertas tbody');
                    tbody.innerHTML = '';

                    ofertasFiltradas.forEach(oferta => {
                        const empresa = empresas.find(e => e.ID === oferta.Empresa_id) || {
                            Nombre: 'Desconocida'
                        };
                        const badgeClass = oferta.Estado === 'Activa' ? 'badge-success' :
                            oferta.Estado === 'Cerrada' ? 'badge-warning' : 'badge-primary';

                        const fila = document.createElement('tr');
                        fila.innerHTML = `
                            <td>${oferta.Titulo}</td>
                            <td>${empresa.Nombre}</td>
                            <td>${oferta.Area}</td>
                            <td>${oferta.Modalidad}</td>
                            <td>${oferta.Salario || 'No especificado'}</td>
                            <td><span class="badge ${badgeClass}">${oferta.Estado}</span></td>
                            <td>
                                <button class="action-btn" title="Editar">
                                    <i class='bx bx-edit'></i>
                                </button>
                                <button class="action-btn" title="Eliminar">
                                    <i class='bx bx-trash'></i>
                                </button>
                                <button class="action-btn" title="Ver detalles">
                                    <i class='bx bx-show'></i>
                                </button>
                            </td>
                        `;
                        tbody.appendChild(fila);
                    });

                    return ofertasFiltradas;
                }
            });
        }

        // Función para formatear fechas
        function formatearFecha(fechaString) {
            if (!fechaString) return 'No especificada';

            const fecha = new Date(fechaString);
            return fecha.toLocaleDateString('es-ES', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }

        // Función para mostrar alertas
        function mostrarAlerta(titulo, mensaje, tipo) {
            Swal.fire({
                title: titulo,
                text: mensaje,
                icon: tipo,
                confirmButtonText: 'OK'
            });
        }
    </script>
</body>

</html>