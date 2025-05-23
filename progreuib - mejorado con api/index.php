<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreuib - Conectando Educación y Trabajo</title>
    <link rel="icon" href="img/icono.jpeg">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* === Estilos generales === */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
            color: #fff;
            background-color: #0a192f;
        }

        /* === Video de fondo === */
        .video-background {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            z-index: -2;
            object-fit: cover;
            pointer-events: none;
        }

        /* === Capa oscura sobre el video === */
        .bg-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(10, 25, 47, 0.85);
            z-index: -1;
        }

        /* === Navbar Elegante === */
        .navbar {
            background-color: rgba(10, 25, 47, 0.9);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            transition: all 0.4s ease;
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
        }

        .navbar.scrolled {
            padding: 0.7rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: #64ffda !important;
            letter-spacing: 1px;
        }

        .navbar-brand img {
            border: 1px solid #64ffda;
        }

        .nav-link {
            color: #ccd6f6 !important;
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

        /* === Hero Section Moderna === */
        .hero-section {
            height: 100vh;
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 80px;
        }

        .navbar-brand img {
            border: 1px solid #64ffda;
            transition: all 0.3s ease;
            /* Agregado para suavizar la transición */
        }

        .navbar-brand:hover img {
            transform: scale(1.1);
            /* Efecto de escala al hacer hover */
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
            /* Sombra verde al hacer hover */
        }

        .hero-content {
            max-width: 800px;
        }

        .hero-title {
            font-size: 4.5rem;
            font-weight: 700;
            color: #e6f1ff;
            margin-bottom: 1.5rem;
            line-height: 1.1;
        }

        .hero-subtitle {
            font-size: 1.5rem;
            color: #8892b0;
            margin-bottom: 2.5rem;
            font-style: italic;
        }

        .hero-title span {
            color: #64ffda;
            display: block;
        }

        .btn-primary-custom {
            background: transparent;
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 500;
            border-radius: 4px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary-custom:hover {
            background: rgba(100, 255, 218, 0.1);
            transform: translateY(-3px);
            color: #64ffda;
        }

        /* === Sección de Búsqueda === */
        .search-section {
            padding: 5rem 0;
            background: rgba(10, 25, 47, 0.7);
            backdrop-filter: blur(5px);
        }

        .section-title {
            font-size: 2rem;
            color: #ccd6f6;
            margin-bottom: 2rem;
            text-align: center;
            position: relative;
            display: inline-block;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 70px;
            height: 2px;
            background: #64ffda;
        }

        .search-card {
            background: rgba(23, 42, 69, 0.7);
            border: none;
            border-radius: 8px;
            backdrop-filter: blur(5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            padding: 2rem;
            transition: transform 0.3s ease;
        }

        .search-card:hover {
            transform: translateY(-5px);
        }

        .form-label {
            color: #ccd6f6;
            font-weight: 500;
        }

        .form-select,
        .form-control {
            background: rgba(10, 25, 47, 0.8);
            border: 1px solid #233554;
            color: #e6f1ff;
            padding: 0.75rem 1rem;
        }

        .form-select:focus,
        .form-control:focus {
            background: rgba(10, 25, 47, 0.9);
            border-color: #64ffda;
            box-shadow: 0 0 0 0.25rem rgba(100, 255, 218, 0.25);
            color: #e6f1ff;
        }

        .btn-search {
            background: #64ffda;
            color: #0a192f;
            border: none;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-search:hover {
            background: #52e0c4;
            transform: translateY(-2px);
        }

        /* === Sección de Ofertas === */
        .jobs-section {
            padding: 5rem 0;
            background: rgba(10, 25, 47, 0.9);
        }

        .job-card {
            background: rgba(23, 42, 69, 0.7);
            border: none;
            border-radius: 8px;
            transition: all 0.3s ease;
            height: 100%;
            overflow: hidden;
        }

        .job-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .job-card .card-body {
            padding: 2rem;
        }

        .job-title {
            color: #e6f1ff;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .job-company {
            color: #8892b0;
            margin-bottom: 1.5rem;
        }

        .btn-outline-custom {
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s ease;
        }

        .btn-outline-custom:hover {
            background: rgba(100, 255, 218, 0.1);
            color: #64ffda;
        }

        .btn-view-all {
            background: transparent;
            color: #64ffda;
            border: 1px solid #64ffda;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-view-all:hover {
            background: rgba(100, 255, 218, 0.1);
            transform: translateY(-3px);
        }

        /* === Footer Elegante === */
        .footer {
            background: #0a192f;
            padding: 4rem 0 2rem;
            border-top: 1px solid rgba(100, 255, 218, 0.1);
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: #64ffda;
            margin-bottom: 1.5rem;
            display: inline-block;
        }

        .footer-about {
            color: #8892b0;
            margin-bottom: 2rem;
        }

        .footer-links h5 {
            color: #ccd6f6;
            font-size: 1.2rem;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.5rem;
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
            color: #8892b0;
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
            border-top: 1px solid rgba(100, 255, 218, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: #8892b0;
        }

        /* === Responsive Design === */
        @media (max-width: 992px) {
            .hero-title {
                font-size: 3.5rem;
            }

            .hero-subtitle {
                font-size: 1.3rem;
            }
        }

        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.8rem;
            }

            .hero-subtitle {
                font-size: 1.1rem;
            }

            .section-title {
                font-size: 1.8rem;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .btn-primary-custom {
                padding: 0.8rem 1.5rem;
                font-size: 1rem;
            }

            .search-card,
            .job-card .card-body {
                padding: 1.5rem;
            }
        }
    </style>
</head>

<body>
    <!-- Video de fondo -->
    <video autoplay muted loop class="video-background">
        <source src="mp4/Quibdó - Chocó cinematic video..mp4" type="video/mp4">
        Tu navegador no soporta videos en HTML5.
    </video>
    <div class="bg-overlay"></div>

    <!-- Navbar Elegante -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="http://progreuib.edu.co/">
                <img src="img/icono.jpeg" alt="Logo" width="30" height="30" class="me-2 rounded-circle">
                Progreuib
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class='bx bx-menu'></i>
            </button>

            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">
                            <i class='bx bx-home'></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="ofertas/ofertas.php">
                            <i class='bx bx-briefcase'></i> Ofertas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="register/register.php">
                            <i class='bx bx-user-plus'></i> Registro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login/login.php">
                            <i class='bx bx-log-in'></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="contact/contact.php">
                            <i class='bx bx-envelope'></i> Contacto
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="hero-section">
        <div class="container">
            <div class="hero-content">
                <h1 class="hero-title">
                    <span>PROGREUIB</span>
                    CONECTANDO EDUCACIÓN Y TRABAJO
                </h1>
                <p class="hero-subtitle">Educación con propósito, trabajo con impacto. ¡Construyamos el cambio desde el Chocó!</p>
                <a href="register/register.php" class="btn btn-primary-custom">
                    <i class='bx bx-rocket'></i> Comenzar Ahora
                </a>
            </div>
        </div>
    </header>

    <!-- Sección de Búsqueda -->
    <section class="search-section">
        <div class="container">
            <h2 class="section-title">Encuentra la oportunidad ideal para ti</h2>
            <div class="search-card">
                <form action="empleos.php" method="GET" class="row g-3 align-items-center justify-content-center">
                    <div class="col-md-8">
                        <label for="area" class="form-label">Área profesional</label>
                        <select name="q" id="area" class="form-select form-select-lg">
                            <option value="">Selecciona un área</option>
                            <option value="Programador">Programador</option>
                            <option value="Docente">Docente</option>
                            <option value="Analista de Datos">Analista de Datos</option>
                            <option value="Diseñador Gráfico">Diseñador Gráfico</option>
                            <option value="Ingeniero de Software">Ingeniero de Software</option>
                            <option value="Soporte Técnico">Soporte Técnico</option>
                            <option value="Administrador de Redes">Administrador de Redes</option>
                            <option value="Community Manager">Community Manager</option>
                            <option value="Marketing Digital">Marketing Digital</option>
                            <option value="Contador">Contador</option>
                            <option value="Asistente Administrativo">Asistente Administrativo</option>
                            <option value="Gestor de Proyectos">Gestor de Proyectos</option>
                            <option value="Psicólogo Organizacional">Psicólogo Organizacional</option>
                            <option value="Redactor de Contenidos">Redactor de Contenidos</option>
                            <option value="Especialista en Recursos Humanos">Especialista en Recursos Humanos</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-grid">
                        <button type="submit" class="btn btn-search btn-lg">
                            <i class='bx bx-search'></i> Buscar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Sección de Ofertas -->
    <section class="jobs-section">
        <div class="container">
            <h2 class="section-title">Últimas Ofertas de Trabajo</h2>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card job-card">
                        <div class="card-body">
                            <h5 class="job-title">Desarrollador Web</h5>
                            <p class="job-company">Empresa X | Jornada completa</p>
                            <a href="detalle_empleo.php?id=1" class="btn btn-outline-custom">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card job-card">
                        <div class="card-body">
                            <h5 class="job-title">Docente de Matemáticas</h5>
                            <p class="job-company">Colegio Y | Medio tiempo</p>
                            <a href="detalle_empleo.php?id=2" class="btn btn-outline-custom">Ver Detalles</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card job-card">
                        <div class="card-body">
                            <h5 class="job-title">Analista de Datos</h5>
                            <p class="job-company">Compañía Z | Modalidad remota</p>
                            <a href="detalle_empleo.php?id=3" class="btn btn-outline-custom">Ver Detalles</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-5">
                <a href="empleos.php" class="btn btn-view-all">Ver todas las ofertas</a>
            </div>
        </div>
    </section>

    <!-- Footer Elegante -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="#" class="footer-brand d-flex align-items-center mb-4">
                        <img src="img/icono.jpeg" alt="Logo" width="30" height="30" class="me-2 rounded-circle">
                        Progreuib
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
                            <li><a href="index.php">Inicio</a></li>
                            <li><a href="empleos.php">Ofertas</a></li>
                            <li><a href="register/register.php">Registro</a></li>
                            <li><a href="login/login.php">Iniciar Sesión</a></li>
                            <li><a href="contact/contact.php">Contacto</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h5>Contacto</h5>
                        <ul>
                            <li><i class='bx bx-envelope me-2'></i> sharly@gmail.com</li>
                            <li><i class='bx bx-phone me-2'></i> +57 312 660 2583</li>
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
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class='bx bx-send'></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="footer-bottom">
                <p class="mb-0">&copy; 2025 <strong>Progreuib</strong>. Todos los derechos reservados a @sharly 💙.</p>
            </div>
        </div>
    </footer>

    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Efecto de scroll en navbar
        window.addEventListener("scroll", function() {
            const navbar = document.querySelector(".navbar");
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });

        // Animación suave para los enlaces
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>