<?php
session_start();
include("../conex.php");

// Validación de rol
if (!isset($_SESSION['Rol']) || $_SESSION['Rol'] !== 'Administrador') {
    header("Location: ../login.php?mensaje=Acceso no autorizado&clase=alert-danger");
    exit;
}

// Procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $correo = $conexion->real_escape_string($_POST['correo']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $area = isset($_POST['area']) ? $conexion->real_escape_string($_POST['area']) : '';
    $especialidad = isset($_POST['especialidad']) ? $conexion->real_escape_string($_POST['especialidad']) : '';

    // Verificar si el correo ya existe
    $check = $conexion->query("SELECT ID FROM usuarios WHERE Correo = '$correo'");
    if ($check->num_rows > 0) {
        $error = "El correo electrónico ya está registrado";
    } else {
        // Insertar en la tabla de usuarios (como empresa)
        $conexion->query("INSERT INTO usuarios (Nombre, Correo, Contraseña, Area, Rol, Especialidad) 
                         VALUES ('$nombre', '$correo', '$password', '$area', 'Empresa', '$especialidad')");

        // Obtener el ID del usuario recién creado
        $usuario_id = $conexion->insert_id;

        // Insertar en la tabla de empresas
        $conexion->query("INSERT INTO empresas (ID, Nombre, Correo, Password) 
                         VALUES ('$usuario_id', '$nombre', '$correo', '$password')");

        header("Location: admin.php?mensaje=Empresa registrada correctamente&clase=alert-success");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Empresa - ProgreUIB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2c3e50;
            --secondary-color: #3498db;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #27ae60;
        }

        body {
            background-color: #f5f7fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #34495e;
        }

        .auth-container {
            max-width: 600px;
            margin: 2rem auto;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .auth-card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .auth-card:hover {
            transform: translateY(-5px);
        }

        .auth-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem;
            text-align: center;
            position: relative;
        }

        .auth-header::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 20px;
            background: url('data:image/svg+xml;utf8,<svg viewBox="0 0 1200 120" xmlns="http://www.w3.org/2000/svg"><path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" fill="%23ecf0f1"/><path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" fill="%23ecf0f1"/><path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" fill="%23ecf0f1"/></svg>') no-repeat;
            background-size: cover;
        }

        .auth-body {
            padding: 2rem;
            background-color: white;
        }

        .form-control {
            border-radius: 8px;
            padding: 12px 15px;
            border: 1px solid #dfe6e9;
            transition: all 0.3s;
        }

        .form-control:focus {
            border-color: var(--secondary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }

        .form-label {
            font-weight: 600;
            color: var(--dark-color);
            margin-bottom: 0.5rem;
        }

        .btn-primary {
            background-color: var(--secondary-color);
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-primary:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }

        .btn-outline-secondary {
            border-radius: 8px;
            padding: 12px 24px;
            font-weight: 600;
        }

        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #7f8c8d;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: var(--secondary-color);
        }

        .input-group-text {
            background-color: var(--light-color);
            border-radius: 8px 0 0 8px;
        }

        .invalid-feedback {
            color: var(--accent-color);
            font-weight: 500;
        }

        .form-text {
            color: #7f8c8d;
            font-size: 0.85rem;
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #bdc3c7;
            margin: 1.5rem 0;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            border-bottom: 1px solid #dfe6e9;
        }

        .divider::before {
            margin-right: 1rem;
        }

        .divider::after {
            margin-left: 1rem;
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <h3><i class="fas fa-building me-2"></i> Registrar Nueva Empresa</h3>
                <p class="mb-0">Complete el formulario para registrar una nueva empresa</p>
            </div>

            <div class="auth-body">
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form method="POST" id="formEmpresa" class="needs-validation" novalidate>
                    <div class="mb-4">
                        <label for="nombre" class="form-label">Nombre de la Empresa</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <input type="text" class="form-control" id="nombre" name="nombre" required
                                placeholder="Ej: Tech Solutions S.A.">
                            <div class="invalid-feedback">
                                Por favor ingrese el nombre de la empresa
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email" class="form-control" id="correo" name="correo" required
                                placeholder="Ej: contacto@empresa.com">
                            <div class="invalid-feedback">
                                Por favor ingrese un correo electrónico válido
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 position-relative">
                        <label for="password" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password" required
                                placeholder="Mínimo 8 caracteres" minlength="8">
                            <i class="fas fa-eye password-toggle" id="togglePassword"></i>
                        </div>
                        <div class="form-text">La contraseña debe tener al menos 8 caracteres</div>
                    </div>

                    <div class="mb-4">
                        <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password" class="form-control" id="confirm_password" required
                                placeholder="Repite la contraseña">
                            <div class="invalid-feedback">Las contraseñas no coinciden</div>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <label for="area" class="form-label">Área Principal</label>
                            <select class="form-select" id="area" name="area" required>
                                <option value="" selected disabled>Seleccionar área</option>
                                <option value="Tecnología">Tecnología</option>
                                <option value="Salud">Salud</option>
                                <option value="Educación">Educación</option>
                                <option value="Finanzas">Finanzas</option>
                                <option value="Comercio">Comercio</option>
                                <option value="Manufactura">Manufactura</option>
                                <option value="Servicios">Servicios</option>
                                <option value="Otro">Otro</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione un área
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <input type="text" class="form-control" id="especialidad" name="especialidad"
                                placeholder="Ej: Desarrollo de Software">
                        </div>
                    </div>

                    <div class="d-grid gap-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> Registrar Empresa
                        </button>
                        <a href="admin.php" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i> Volver al Panel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mostrar/ocultar contraseña
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');

        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.classList.toggle('fa-eye-slash');
        });

        // Validación de Bootstrap
        (function() {
            'use strict'

            const forms = document.querySelectorAll('.needs-validation')

            Array.from(forms).forEach(form => {
                form.addEventListener('submit', event => {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
        })()

        // Validar que las contraseñas coincidan
        const form = document.getElementById('formEmpresa');
        const passwordInput = document.getElementById('password');
        const confirmPasswordInput = document.getElementById('confirm_password');

        form.addEventListener('submit', function(e) {
            if (passwordInput.value !== confirmPasswordInput.value) {
                e.preventDefault();
                confirmPasswordInput.classList.add('is-invalid');
            } else {
                confirmPasswordInput.classList.remove('is-invalid');
            }

            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }

            form.classList.add('was-validated');
        });

        confirmPasswordInput.addEventListener('input', function() {
            if (this.value !== passwordInput.value) {
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
            }
        });
    </script>
</body>

</html>