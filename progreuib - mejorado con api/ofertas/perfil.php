<?php
session_start();
include('../conex.php');

// Verificar autenticación
if (!isset($_SESSION['ID'])) {
    header("Location: ../login/login.php");
    exit;
}

$usuarioId = $_SESSION['ID'];
$mensaje = '';
$claseMensaje = '';

// Obtener datos actuales del usuario
$stmt = $conexion->prepare("SELECT * FROM usuarios WHERE ID = ?");
$stmt->bind_param("i", $usuarioId);
$stmt->execute();
$resultado = $stmt->get_result();
$usuario = $resultado->fetch_assoc();

// Procesar actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $correo = $_POST['correo'] ?? '';
    $area = $_POST['area'] ?? '';
    $especialidad = $_POST['especialidad'] ?? '';

    // Validar campos requeridos
    if (empty($nombre) || empty($correo)) {
        $mensaje = "Nombre y correo son campos obligatorios";
        $claseMensaje = "alert-danger";
    } else {
        // Actualizar contraseña solo si se proporcionó una nueva
        if (!empty($_POST['password'])) {
            $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $stmt = $conexion->prepare("UPDATE usuarios SET Nombre = ?, Correo = ?, Area = ?, Especialidad = ?, Contraseña = ? WHERE ID = ?");
            $stmt->bind_param("sssssi", $nombre, $correo, $area, $especialidad, $password, $usuarioId);
        } else {
            $stmt = $conexion->prepare("UPDATE usuarios SET Nombre = ?, Correo = ?, Area = ?, Especialidad = ? WHERE ID = ?");
            $stmt->bind_param("ssssi", $nombre, $correo, $area, $especialidad, $usuarioId);
        }

        if ($stmt->execute()) {
            $mensaje = "Perfil actualizado correctamente";
            $claseMensaje = "alert-success";
            // Actualizar datos en sesión
            $_SESSION['Nombre'] = $nombre;
            // Refrescar datos del usuario
            $stmt = $conexion->prepare("SELECT * FROM usuarios WHERE ID = ?");
            $stmt->bind_param("i", $usuarioId);
            $stmt->execute();
            $resultado = $stmt->get_result();
            $usuario = $resultado->fetch_assoc();
        } else {
            $mensaje = "Error al actualizar el perfil";
            $claseMensaje = "alert-danger";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es" data-bs-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - ProgreUIB</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #2563eb;
            --primary-hover: #1d4ed8;
            --secondary-color: #334155;
            --light-color: #f8fafc;
        }

        body {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }

        .profile-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .profile-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 2rem;
            text-align: center;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid white;
            object-fit: cover;
            margin-bottom: 1rem;
            background-color: #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1rem;
        }

        .profile-avatar i {
            font-size: 3rem;
            color: var(--secondary-color);
        }

        .profile-body {
            padding: 2rem;
            background: white;
        }

        .form-label {
            font-weight: 500;
            color: var(--secondary-color);
        }

        .btn-save {
            background-color: var(--primary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
        }

        .btn-save:hover {
            background-color: var(--primary-hover);
        }

        .nav-pills .nav-link.active {
            background-color: var(--primary-color);
        }

        .nav-pills .nav-link {
            color: var(--secondary-color);
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <!-- Navbar mejorado -->
    <!-- Navbar mejorado -->
<nav class="navbar navbar-expand-lg navbar-dark" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="../index.php">
            <i class="fas fa-briefcase me-2"></i>
            <span class="fw-bold">ProgreUIB</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../ofertas.php">
                        <i class="fas fa-search me-1"></i> Buscar Ofertas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="fas fa-bell me-1"></i> Alertas
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
                            
                            if($user_data = $user_result->fetch_assoc()): ?>
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
                                    <i class="fas fa-user-circle me-2 text-primary"></i> Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cog me-2 text-primary"></i> Configuración
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-file-alt me-2 text-primary"></i> Mis Postulaciones
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="../logout.php">
                                    <i class="fas fa-sign-out-alt me-2 text-primary"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="../login/login.php">
                            <i class="fas fa-sign-in-alt me-1"></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../register/register.php">
                            <i class="fas fa-user-plus me-1"></i> Registrarse
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Validación básica de contraseña
        document.querySelector('form').addEventListener('submit', function(e) {
            const password = document.getElementById('new-password')?.value;
            const confirmPassword = document.getElementById('confirm-password')?.value;

            if (password && password.length < 8) {
                alert('La contraseña debe tener al menos 8 caracteres');
                e.preventDefault();
            }

            if (password && confirmPassword && password !== confirmPassword) {
                alert('Las contraseñas no coinciden');
                e.preventDefault();
            }
        });
    </script>
</body>

</html>