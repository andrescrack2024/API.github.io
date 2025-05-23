<?php
session_start();
include("../conex.php");

$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['nombre'] ?? '';
    $email = $_POST['email'] ?? '';
    $subject = $_POST['asunto'] ?? '';
    $message = $_POST['mensaje'] ?? '';
    
    // Validación básica
    if (empty($name) || empty($email) || empty($subject) || empty($message)) {
        $error = "Todos los campos son obligatorios.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "El formato del correo electrónico no es válido.";
    } else {
        try {
            // Obtener información del cliente
            $ip_address = $_SERVER['REMOTE_ADDR'];
            $user_agent = $_SERVER['HTTP_USER_AGENT'];
            
            // Preparar la consulta SQL
            $stmt = $conn->prepare("INSERT INTO contacts (name, email, subject, message, ip_address, user_agent, status) 
                                  VALUES (:name, :email, :subject, :message, :ip_address, :user_agent, 'unread')");
            
            // Ejecutar la consulta
            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':subject' => $subject,
                ':message' => $message,
                ':ip_address' => $ip_address,
                ':user_agent' => $user_agent
            ]);
            
            $success = "Tu mensaje ha sido enviado con éxito. Nos pondremos en contacto contigo pronto.";
            
            // Limpiar los campos del formulario
            $name = $email = $subject = $message = '';
            
        } catch(PDOException $e) {
            $error = "Error al enviar el mensaje: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Progreuib - Contacto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #0066cc;
            --secondary-color: #004080;
            --accent-color: #ffc107;
            --light-gray: #f5f5f7;
            --medium-gray: #d2d2d7;
            --dark-gray: #86868b;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: 'Montserrat', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: 
                linear-gradient(135deg, rgba(0, 102, 204, 0.08) 0%, rgba(255, 193, 7, 0.08) 100%),
                url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100" preserveAspectRatio="none"><path fill="%230066cc" opacity="0.05" d="M30,10L50,30L70,10L90,30L70,50L90,70L70,90L50,70L30,90L10,70L30,50L10,30L30,10Z"></path></svg>'),
                linear-gradient(to right bottom, #f5f7fa, #c3cfe2);
            background-size: 100% 100%, 60px 60px, 100% 100%;
            color: #333;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Navbar Mejorado */
        .navbar {
            background-color: rgba(0, 0, 0, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.15);
            padding: 0.8rem 0;
            font-family: 'Montserrat', sans-serif;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
            color: var(--accent-color) !important;
            display: flex;
            align-items: center;
            padding: 0.25rem 0;
        }

        .navbar-brand img {
            border: 2px solid var(--accent-color);
            margin-right: 0.75rem;
            transition: all 0.3s ease;
        }

        .navbar-brand:hover img {
            transform: rotate(10deg);
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.9) !important;
            font-weight: 500;
            font-size: 0.95rem;
            letter-spacing: 0.3px;
            padding: 0.6rem 1rem !important;
            margin: 0 0.25rem;
            border-radius: 6px;
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
            color: white !important;
            background-color: rgba(255, 255, 255, 0.1);
        }

        .nav-link:hover i {
            transform: scale(1.1);
            color: var(--accent-color);
        }

        .nav-link.active {
            color: white !important;
            background-color: rgba(255, 193, 7, 0.15);
            font-weight: 600;
            position: relative;
        }

        .nav-link.active::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 1rem;
            right: 1rem;
            height: 2px;
            background-color: var(--accent-color);
            border-radius: 2px;
        }

        .nav-link.active i {
            color: var(--accent-color);
        }

        .navbar-toggler {
            border: none;
            padding: 0.5rem;
            color: var(--accent-color) !important;
        }

        .navbar-toggler:focus {
            box-shadow: none;
        }

        .navbar-toggler i {
            font-size: 1.8rem;
        }

        /* Contact Container */
        .contact-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5rem 0 3rem;
        }

        .contact-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: none;
            overflow: hidden;
            background-color: rgba(255, 255, 255, 0.98);
            width: 100%;
            max-width: 900px;
            position: relative;
            z-index: 1;
        }

        .contact-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: -2px;
            right: -2px;
            bottom: -2px;
            background: linear-gradient(45deg, var(--primary-color), var(--accent-color));
            z-index: -1;
            border-radius: 16px;
            opacity: 0.3;
        }

        .contact-info-section {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 3rem;
            position: relative;
            overflow: hidden;
        }

        .contact-info-section::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.1);
        }

        .contact-info-section::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -30px;
            width: 250px;
            height: 250px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
        }

        .contact-form-section {
            padding: 3rem;
        }

        .contact-header {
            text-align: center;
            margin-bottom: 2rem;
            position: relative;
            z-index: 2;
        }

        .contact-header h2 {
            font-weight: 600;
            color: white;
            margin-bottom: 1rem;
        }

        .contact-header i {
            font-size: 2.5rem;
            color: white;
            margin-bottom: 1rem;
        }

        .contact-details {
            position: relative;
            z-index: 2;
        }

        .contact-details div {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }

        .contact-details i {
            font-size: 1.2rem;
            margin-right: 15px;
            color: var(--accent-color);
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: var(--secondary-color);
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            transition: all 0.3s;
            border: 1px solid var(--medium-gray);
            margin-bottom: 1.5rem;
        }

        .form-control:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(0, 102, 204, 0.25);
        }

        textarea.form-control {
            min-height: 150px;
        }

        .btn-send {
            background-color: var(--accent-color);
            border: none;
            font-weight: 500;
            padding: 0.75rem 2rem;
            transition: all 0.3s;
            border-radius: 8px;
            color: #000;
            display: inline-flex;
            align-items: center;
        }

        .btn-send:hover {
            background-color: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .btn-send i {
            margin-right: 8px;
        }

        /* Mensajes */
        .error-message {
            color: #dc3545;
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            background-color: rgba(220, 53, 69, 0.1);
            border-radius: 8px;
            border-left: 4px solid #dc3545;
        }

        .success-message {
            color: #28a745;
            text-align: center;
            margin-bottom: 1rem;
            padding: 0.75rem 1.25rem;
            background-color: rgba(40, 167, 69, 0.1);
            border-radius: 8px;
            border-left: 4px solid #28a745;
        }

        /* Footer Elegante */
        .footer-elegante {
            background-color: #121212;
            color: rgba(255, 255, 255, 0.7);
            padding: 3rem 0 2rem;
            margin-top: auto;
        }

        .footer-brand {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--accent-color);
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
        }

        .footer-links h5::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 40px;
            height: 2px;
            background: var(--accent-color);
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
            color: var(--accent-color);
            padding-left: 5px;
        }

        .social-links a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            background: rgba(255, 193, 7, 0.1);
            border-radius: 50%;
            color: var(--accent-color);
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        .social-links a:hover {
            background: var(--accent-color);
            color: #000;
            transform: translateY(-3px);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 2rem;
            margin-top: 3rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.5);
        }

        /* Responsive */
        @media (max-width: 992px) {
            .navbar-collapse {
                padding: 1rem 0;
                background-color: rgba(0, 0, 0, 0.95);
                border-radius: 0 0 10px 10px;
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            }
            
            .nav-link {
                margin: 0.25rem 0;
                padding: 0.8rem 1.5rem !important;
            }
            
            .nav-link.active::after {
                left: 1.5rem;
                right: 1.5rem;
            }
        }

        @media (max-width: 768px) {
            .contact-container {
                padding: 4rem 0 2rem;
            }
            
            .contact-card {
                flex-direction: column;
                margin: 0 1rem;
            }
            
            .contact-info-section, .contact-form-section {
                padding: 2rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navbar Mejorado -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../img/icono.jpeg" alt="Logo" width="30" height="30" class="rounded-circle">
                Progreuib
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <i class='bx bx-menu'></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../index.php">
                            <i class='bx bx-home'></i> Inicio
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../ofertas/ofertas.php">
                            <i class='bx bx-briefcase'></i> Ofertas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../register/register.php">
                            <i class='bx bx-user-plus'></i> Registro
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/login.php">
                            <i class='bx bx-log-in'></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class='bx bx-envelope'></i> Contacto
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <div class="contact-container">
        <div class="card contact-card">
            <div class="row g-0">
                <div class="col-lg-5">
                    <div class="contact-info-section">
                        <div class="contact-header">
                            <i class='bx bx-envelope'></i>
                            <h2>Contáctanos</h2>
                            <p>¿Tienes preguntas o sugerencias? Estamos aquí para ayudarte.</p>
                        </div>
                        
                        <div class="contact-details">
                            <div>
                                <i class='bx bx-envelope'></i>
                                <span>contacto@progreuib.com</span>
                            </div>
                            <div>
                                <i class='bx bx-phone'></i>
                                <span>+57 312 660 2583</span>
                            </div>
                            <div>
                                <i class='bx bx-map'></i>
                                <span>Quibdó, Chocó - Colombia</span>
                            </div>
                            <div>
                                <i class='bx bx-time'></i>
                                <span>Lunes a Viernes, 8am - 6pm</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-7">
                    <div class="contact-form-section">
                        <h2 class="mb-4" style="color: var(--primary-color);">Envía un mensaje</h2>
                        
                        <?php if(!empty($error)): ?>
                            <div class="error-message"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <?php if(!empty($success)): ?>
                            <div class="success-message"><?php echo $success; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST" action="">
                            <div class="form-group">
                                <label for="nombre" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required 
                                       value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>" 
                                       placeholder="Ingresa tu nombre">
                            </div>
                            
                            <div class="form-group">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input type="email" class="form-control" id="email" name="email" required 
                                       value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>" 
                                       placeholder="Ingresa tu correo electrónico">
                            </div>
                            
                            <div class="form-group">
                                <label for="asunto" class="form-label">Asunto</label>
                                <input type="text" class="form-control" id="asunto" name="asunto" required 
                                       value="<?php echo isset($subject) ? htmlspecialchars($subject) : ''; ?>" 
                                       placeholder="¿Cuál es el motivo de tu contacto?">
                            </div>
                            
                            <div class="form-group">
                                <label for="mensaje" class="form-label">Mensaje</label>
                                <textarea class="form-control" id="mensaje" name="mensaje" required 
                                          placeholder="Describe tu consulta con detalles..."><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>
                            </div>
                            
                            <button type="submit" class="btn btn-send">
                                <i class='bx bx-send'></i> Enviar mensaje
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer Elegante -->
    <footer class="footer-elegante">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="#" class="footer-brand d-flex align-items-center mb-4">
                        <img src="../img/icono.jpeg" alt="Logo" width="30" height="30" class="me-2 rounded-circle">
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
                            <li><a href="../index.php">Inicio</a></li>
                            <li><a href="../ofertas/ofertas.php">Ofertas</a></li>
                            <li><a href="../register/register.php">Registro</a></li>
                            <li><a href="../login/login.php">Iniciar Sesión</a></li>
                            <li><a href="#">Contacto</a></li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-3 col-md-6 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h5>Contacto</h5>
                        <ul>
                            <li><i class='bx bx-envelope me-2'></i> contacto@progreuib.com</li>
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
        // Efecto de reducción al hacer scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
                navbar.style.padding = '10px 0';
            } else {
                navbar.classList.remove('scrolled');
                navbar.style.padding = '15px 0';
            }
        });
    </script>
</body>
</html>
</html>