<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreuib - Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0a192f;
            --secondary-color: #172a45;
            --accent-color: #64ffda;
            --text-primary: #ccd6f6;
            --text-secondary: #8892b0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', sans-serif;
            color: var(--text-primary);
            background-color: var(--primary-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Elegante */
        .navbar {
            background-color: rgba(10, 25, 47, 0.95);
            backdrop-filter: blur(10px);
            padding: 1rem 0;
            border-bottom: 1px solid rgba(100, 255, 218, 0.1);
            transition: all 0.4s ease;
        }

        .navbar.scrolled {
            padding: 0.7rem 0;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--accent-color) !important;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
        }

        .navbar-brand img {
            border: 1px solid var(--accent-color);
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: scale(1.1);
            box-shadow: 0 0 10px rgba(100, 255, 218, 0.5);
        }

        .nav-link {
            color: var(--text-primary) !important;
            font-weight: 500;
            margin: 0 0.5rem;
            padding: 0.5rem 1rem !important;
            position: relative;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
        }

        .nav-link i {
            font-size: 1.2rem;
            margin-right: 0.5rem;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--accent-color) !important;
        }

        .nav-link:hover i {
            transform: scale(1.1);
        }

        .nav-link.active {
            color: var(--accent-color) !important;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 1rem;
            width: calc(100% - 2rem);
            height: 2px;
            background: var(--accent-color);
        }

        .navbar-toggler {
            border: none;
            color: var(--accent-color) !important;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler i {
            font-size: 1.8rem;
        }

        @media (max-width: 992px) {
            .navbar-collapse {
                padding: 1rem 0;
                background-color: rgba(10, 25, 47, 0.95);
                border-radius: 0 0 10px 10px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }

            .nav-link {
                margin: 0.25rem 0;
                padding: 0.8rem 1.5rem !important;
            }
        }

        /* Contenedor de Registro */
        .registration-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
            background: linear-gradient(135deg, rgba(10, 25, 47, 0.9) 0%, rgba(23, 42, 69, 0.9) 100%);
        }

        .registration-card {
            border-radius: 10px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
            border: 1px solid rgba(100, 255, 218, 0.2);
            overflow: hidden;
            background: rgba(23, 42, 69, 0.8);
            backdrop-filter: blur(5px);
            width: 100%;
            max-width: 600px;
            padding: 2.5rem;
            position: relative;
            z-index: 1;
            margin: 1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .registration-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
        }

        .registration-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--accent-color), #0a192f);
            z-index: 2;
        }

        .registration-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .registration-header i {
            font-size: 3rem;
            color: var(--accent-color);
            margin-bottom: 1rem;
            display: inline-block;
            transition: transform 0.3s ease;
        }

        .registration-header h2 {
            font-weight: 600;
            color: var(--accent-color);
            margin-bottom: 0.5rem;
            font-size: 2rem;
        }

        .registration-header p {
            color: var(--text-secondary);
            font-size: 1rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--text-primary);
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 0.5rem;
            color: var(--accent-color);
            font-size: 1.1rem;
        }

        .input-group-text {
            background-color: rgba(10, 25, 47, 0.8);
            border: 1px solid rgba(100, 255, 218, 0.2);
            color: var(--accent-color);
        }

        .form-control,
        .form-select {
            background-color: rgba(10, 25, 47, 0.8);
            border: 1px solid rgba(100, 255, 218, 0.2);
            color: var(--text-primary);
            padding: 0.75rem 1rem;
            transition: all 0.3s;
        }

        .form-control:focus,
        .form-select:focus {
            background-color: rgba(10, 25, 47, 0.9);
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.25rem rgba(100, 255, 218, 0.1);
            color: var(--text-primary);
        }

        .btn-register {
            background-color: var(--accent-color);
            border: none;
            font-weight: 600;
            padding: 0.75rem;
            transition: all 0.3s;
            width: 100%;
            border-radius: 5px;
            color: var(--primary-color);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 1rem;
        }

        .btn-register:hover {
            background-color: #52e0c4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(100, 255, 218, 0.3);
        }

        .password-toggle {
            cursor: pointer;
            background-color: rgba(10, 25, 47, 0.8);
            border: 1px solid rgba(100, 255, 218, 0.2);
            color: var(--accent-color);
            transition: all 0.3s;
        }

        .password-toggle:hover {
            background-color: rgba(100, 255, 218, 0.1);
        }

        .progress {
            height: 5px;
            border-radius: 2.5px;
            background-color: rgba(10, 25, 47, 0.8);
            margin-top: 0.5rem;
        }

        .progress-bar {
            transition: width 0.3s ease;
        }

        .login-link {
            text-align: center;
            margin-top: 1.5rem;
            color: var(--text-secondary);
        }

        .login-link a {
            color: var(--accent-color);
            text-decoration: none;
            transition: all 0.3s;
            font-weight: 500;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        /* Footer Elegante */
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

        .social-links {
            display: flex;
            gap: 1rem;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            background: rgba(100, 255, 218, 0.1);
            border-radius: 50%;
            color: var(--accent-color);
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--accent-color);
            color: var(--primary-color);
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(100, 255, 218, 0.1);
            padding-top: 1.5rem;
            margin-top: 2rem;
            text-align: center;
            color: var(--text-secondary);
            font-size: 0.8rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .registration-card {
                padding: 1.5rem;
            }

            .registration-header h2 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Mejorado -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="../img/icono.jpeg" alt="Logo" width="30" height="30" class="rounded-circle">
                Progreuib
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class='bx bx-menu'></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">
                            <i class='bx bx-home'></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/empleos.php">
                            <i class='bx bx-briefcase'></i> Ofertas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="/register/register.php">
                            <i class='bx bx-user-plus'></i> Registro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/login/login.php">
                            <i class='bx bx-log-in'></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/contact/contact.php">
                            <i class='bx bx-envelope'></i> Contacto
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="registration-container">
        <div class="card registration-card">

            <?php
            $mensaje = $_GET['mensaje'] ?? '';
            $mensaje_clase = $_GET['clase'] ?? '';
            ?>

            <?php if ($mensaje): ?>
                <div class="container mt-4">
                    <div class="alert <?php echo htmlspecialchars($mensaje_clase); ?> alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($mensaje); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
                    </div>
                </div>

                <div class="container text-center fs-4">
                    <p>Serás redirigido en <span id="contador">3</span> segundos...</p>
                </div>

                <script>
                    let segundos = 3;

                    function cuentaRegresiva() {
                        if (segundos > 0) {
                            document.getElementById('contador').textContent = segundos;
                            segundos--;
                            setTimeout(cuentaRegresiva, 1000);
                        } else {
                            window.location.href = "../login/login.php";
                        }
                    }
                    window.onload = cuentaRegresiva;
                </script>
            <?php endif; ?>

            <div class="registration-header">
                <i class='bx bx-user-plus'></i>
                <h2>Únete a Progreuib</h2>
                <p>Completa el formulario para crear tu cuenta</p>
            </div>

            <form action="procesar/procesar_registro.php" method="POST">
                <div class="mb-3">
                    <label for="nombre" class="form-label">
                        <i class='bx bx-user'></i> Nombre Completo
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-user'></i></span>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingresa tu nombre" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">
                        <i class='bx bx-envelope'></i> Correo Electrónico
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-envelope'></i></span>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Ingresa tu correo" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="rol" class="form-label">
                        <i class='bx bx-briefcase'></i> Área o Rol
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-briefcase'></i></span>
                        <select name="rol" id="rol" class="form-select" required>
                            <option value="">Selecciona un rol</option>
                            <option value="Trabajador">Trabajador</option>
                            <option value="Empresa">Empresa</option>
                            <option value="Administrador">Administrador</option>
                            <option value="Vendedor">Vendedor</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="area" class="form-label">
                        <i class='bx bx-category'></i> Área de Interés
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-category'></i></span>
                        <select class="form-select" id="area" name="area" required>
                            <option value="">Selecciona un área</option>
                            <option value="Tecnología">Tecnología</option>
                            <option value="Educación">Educación</option>
                            <option value="Ventas">Ventas</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Recursos Humanos">Recursos Humanos</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="especialidad" class="form-label">
                        <i class='bx bxs-graduation'></i> Especialidad
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bxs-graduation'></i></span>
                        <select id="especialidad" name="especialidad" class="form-control">
                            <option value="">Selecciona una especialidad</option>
                            <option value="Programador">Programador</option>
                            <option value="Docente">Docente</option>
                            <option value="Analista de Datos">Analista de Datos</option>
                        </select>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">
                        <i class='bx bx-lock'></i> Contraseña
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-lock'></i></span>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Crea una contraseña" required>
                        <span class="input-group-text password-toggle" onclick="togglePassword('password')">
                            <i class='bx bx-show' id="togglePasswordIcon"></i>
                        </span>
                    </div>
                    <div class="progress">
                        <div id="password-strength" class="progress-bar" role="progressbar" style="width: 0%"></div>
                    </div>
                    <small id="password-strength-text" class="text-muted"></small>
                </div>

                <div class="mb-4">
                    <label for="confirm-password" class="form-label">
                        <i class='bx bx-lock-alt'></i> Confirmar Contraseña
                    </label>
                    <div class="input-group">
                        <span class="input-group-text"><i class='bx bx-lock-alt'></i></span>
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Confirma tu contraseña" required>
                        <span class="input-group-text password-toggle" onclick="togglePassword('confirm-password')">
                            <i class='bx bx-show' id="togglePasswordIcon2"></i>
                        </span>
                    </div>
                    <small id="password-match" class="text-danger"></small>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-register">
                        <i class='bx bx-check-circle'></i> Crear Cuenta
                    </button>
                </div>
            </form>

            <div class="login-link">
                <p>¿Ya tienes cuenta? <a href="http://progreuib.edu.co/login/login.php">Inicia sesión aquí</a></p>
            </div>
        </div>
    </div>

    <!-- Footer Mejorado -->
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
    <script>
        // Función para mostrar/ocultar contraseña
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const icon = document.getElementById(`togglePasswordIcon${fieldId === 'confirm-password' ? '2' : ''}`);

            if (field.type === "password") {
                field.type = "text";
                icon.classList.remove("bx-show");
                icon.classList.add("bx-hide");
            } else {
                field.type = "password";
                icon.classList.remove("bx-hide");
                icon.classList.add("bx-show");
            }
        }

        // Validación de fortaleza de contraseña
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strengthBar = document.getElementById('password-strength');
            const strengthText = document.getElementById('password-strength-text');

            // Reset
            strengthBar.style.width = '0%';
            strengthBar.className = 'progress-bar';

            if (password.length === 0) {
                strengthText.textContent = '';
                return;
            }

            // Calcular fortaleza
            let strength = 0;

            // Longitud mínima
            if (password.length >= 8) strength += 20;
            if (password.length >= 12) strength += 10;

            // Caracteres diversos
            if (/[A-Z]/.test(password)) strength += 20;
            if (/[0-9]/.test(password)) strength += 20;
            if (/[^A-Za-z0-9]/.test(password)) strength += 20;

            // Asegurarse que no supere 100%
            strength = Math.min(strength, 100);

            // Actualizar barra
            strengthBar.style.width = strength + '%';

            // Actualizar colores y texto
            if (strength < 40) {
                strengthBar.classList.add('bg-danger');
                strengthText.textContent = 'Débil';
                strengthText.className = 'text-danger';
            } else if (strength < 70) {
                strengthBar.classList.add('bg-warning');
                strengthText.textContent = 'Moderada';
                strengthText.className = 'text-warning';
            } else {
                strengthBar.classList.add('bg-success');
                strengthText.textContent = 'Fuerte';
                strengthText.className = 'text-success';
            }
        });

        // Validación de coincidencia de contraseñas
        document.getElementById('confirm-password').addEventListener('input', function() {
            const password = document.getElementById('password').value;
            const confirmPassword = this.value;
            const matchText = document.getElementById('password-match');

            if (confirmPassword.length === 0) {
                matchText.textContent = '';
                return;
            }

            if (password !== confirmPassword) {
                matchText.textContent = 'Las contraseñas no coinciden';
                matchText.className = 'text-danger';
            } else {
                matchText.textContent = 'Las contraseñas coinciden';
                matchText.className = 'text-success';
            }
        });

        // Dinámica de áreas y especialidades
        document.addEventListener('DOMContentLoaded', function() {
            const rolSelect = document.getElementById('rol');
            const areaSelect = document.getElementById('area');
            const especialidadSelect = document.getElementById('especialidad');

            // Mapeo completo de especialidades por área
            const especialidadesPorArea = {
                'Tecnología': ['Programador', 'Desarrollador Web', 'Analista de Datos', 'Ingeniero de Software'],
                'Educación': ['Docente', 'Psicopedagogo', 'Coordinador Académico'],
                'Ventas': ['Vendedor', 'Ejecutivo de Ventas', 'Asesor Comercial'],
                'Marketing': ['Especialista en Marketing', 'Community Manager', 'Analista de Mercado'],
                'Recursos Humanos': ['Reclutador', 'Especialista en Capacitación', 'Gestor de Talento'],
                'Salud': ['Médico', 'Enfermero', 'Psicólogo'],
                'Administración': ['Administrador']
            };

            // Mapeo de áreas disponibles por rol
            const areasPorRol = {
                'Trabajador': ['Tecnología', 'Educación', 'Ventas', 'Marketing', 'Recursos Humanos', 'Salud'],
                'Empresa': ['Tecnología', 'Ventas', 'Marketing', 'Recursos Humanos'],
                'Vendedor': ['Ventas', 'Marketing'],
                'Administrador': ['Administración']
            };

            // Función para actualizar las áreas basadas en el rol seleccionado
            function actualizarAreas() {
                const rol = rolSelect.value;

                // Limpiar selects
                areaSelect.innerHTML = '<option value="">Selecciona un área</option>';
                especialidadSelect.innerHTML = '<option value="">Selecciona una especialidad</option>';

                // Caso especial para Administrador
                if (rol === 'Administrador') {
                    areaSelect.disabled = true;
                    areaSelect.innerHTML = '<option value="Administración">Administración</option>';
                    especialidadSelect.disabled = true;
                    return;
                }

                // Habilitar y cargar áreas según el rol
                areaSelect.disabled = false;
                if (areasPorRol[rol]) {
                    areasPorRol[rol].forEach(function(area) {
                        const option = document.createElement('option');
                        option.value = area;
                        option.textContent = area;
                        areaSelect.appendChild(option);
                    });
                }
            }

            // Función para actualizar especialidades basadas en el área seleccionada
            function actualizarEspecialidades() {
                const area = areaSelect.value;

                especialidadSelect.innerHTML = '<option value="">Selecciona una especialidad</option>';

                if (especialidadesPorArea[area]) {
                    especialidadSelect.disabled = false;
                    especialidadesPorArea[area].forEach(function(especialidad) {
                        const option = document.createElement('option');
                        option.value = especialidad;
                        option.textContent = especialidad;
                        especialidadSelect.appendChild(option);
                    });
                } else {
                    especialidadSelect.disabled = true;
                }
            }

            // Event listeners
            rolSelect.addEventListener('change', function() {
                actualizarAreas();
                actualizarEspecialidades(); // Actualizar especialidades cuando cambia el rol
            });

            areaSelect.addEventListener('change', actualizarEspecialidades);

            // Inicializar al cargar la página
            actualizarAreas();
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