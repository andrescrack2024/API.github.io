<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Empresa - Gestión de Ofertas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #343a40;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
        }
        .sidebar .nav-link:hover {
            color: #fff;
        }
        .sidebar .nav-link.active {
            color: #fff;
            background-color: #007bff;
        }
        .card-counter {
            box-shadow: 2px 2px 10px #DADADA;
            margin: 5px;
            padding: 20px 10px;
            border-radius: 5px;
        }
        .card-counter.primary {
            background-color: #007bff;
            color: #FFF;
        }
        .card-counter.warning {
            background-color: #ffc107;
            color: #000;
        }
        .card-counter.success {
            background-color: #28a745;
            color: #FFF;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-2 d-none d-md-block sidebar">
                <div class="sidebar-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-home mr-2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="#">
                                <i class="fas fa-briefcase mr-2"></i> Ofertas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-users mr-2"></i> Candidatos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-building mr-2"></i> Perfil Empresa
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-cog mr-2"></i> Configuración
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                <i class="fas fa-sign-out-alt mr-2"></i> Cerrar Sesión
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main Content -->
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Gestión de Ofertas</h1>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevaOfertaModal">
                        <i class="fas fa-plus"></i> Nueva Oferta
                    </button>
                </div>

                <!-- Stats Cards -->
                <div class="row">
                    <div class="col-md-4">
                        <div class="card-counter primary">
                            <i class="fas fa-briefcase fa-3x"></i>
                            <span class="count-numbers">12</span>
                            <span class="count-name">Ofertas Activas</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-counter warning">
                            <i class="fas fa-pause-circle fa-3x"></i>
                            <span class="count-numbers">3</span>
                            <span class="count-name">Ofertas Inactivas</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card-counter success">
                            <i class="fas fa-check-circle fa-3x"></i>
                            <span class="count-numbers">5</span>
                            <span class="count-name">Ofertas Cerradas</span>
                        </div>
                    </div>
                </div>

                <!-- Ofertas Table -->
                <div class="table-responsive mt-4">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Área</th>
                                <th>Ubicación</th>
                                <th>Modalidad</th>
                                <th>Publicación</th>
                                <th>Expiración</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Conexión a la base de datos
                            $conn = new mysqli("localhost", "root", "", "progreuib");
                            
                            if ($conn->connect_error) {
                                die("Error de conexión: " . $conn->connect_error);
                            }
                            
                            // Consulta para obtener las ofertas de esta empresa (asumiendo que tenemos el ID de empresa en sesión)
                            $empresa_id = 24; // Esto debería venir de la sesión
                            $sql = "SELECT * FROM ofertas WHERE Empresa_id = $empresa_id ORDER BY Fecha_Publicacion DESC";
                            $result = $conn->query($sql);
                            
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row['ID'] . "</td>";
                                    echo "<td>" . $row['Titulo'] . "</td>";
                                    echo "<td>" . $row['Area'] . "</td>";
                                    echo "<td>" . $row['Ubicacion'] . "</td>";
                                    echo "<td>" . $row['Modalidad'] . "</td>";
                                    echo "<td>" . date('d/m/Y', strtotime($row['Fecha_Publicacion'])) . "</td>";
                                    echo "<td>" . ($row['Fecha_Expiracion'] ? date('d/m/Y', strtotime($row['Fecha_Expiracion'])) : 'No definida') . "</td>";
                                    echo "<td><span class='badge " . getEstadoBadge($row['Estado']) . "'>" . $row['Estado'] . "</span></td>";
                                    echo "<td>
                                            <button class='btn btn-sm btn-info' onclick='verOferta(" . $row['ID'] . ")'><i class='fas fa-eye'></i></button>
                                            <button class='btn btn-sm btn-warning' onclick='editarOferta(" . $row['ID'] . ")'><i class='fas fa-edit'></i></button>
                                            <button class='btn btn-sm btn-danger' onclick='eliminarOferta(" . $row['ID'] . ")'><i class='fas fa-trash'></i></button>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='9' class='text-center'>No hay ofertas registradas</td></tr>";
                            }
                            
                            function getEstadoBadge($estado) {
                                switch($estado) {
                                    case 'Activa': return 'bg-success';
                                    case 'Inactiva': return 'bg-warning text-dark';
                                    case 'Cerrada': return 'bg-secondary';
                                    default: return 'bg-primary';
                                }
                            }
                            
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Nueva Oferta -->
    <div class="modal fade" id="nuevaOfertaModal" tabindex="-1" aria-labelledby="nuevaOfertaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevaOfertaModalLabel">Nueva Oferta Laboral</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNuevaOferta" action="guardar_oferta.php" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="titulo" class="form-label">Título</label>
                                    <input type="text" class="form-control" id="titulo" name="titulo" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="area" class="form-label">Área</label>
                                    <select class="form-select" id="area" name="area" required>
                                        <option value="">Seleccionar área</option>
                                        <option value="Tecnología">Tecnología</option>
                                        <option value="Administración">Administración</option>
                                        <option value="Finanzas">Finanzas</option>
                                        <option value="Marketing">Marketing</option>
                                        <option value="Recursos Humanos">Recursos Humanos</option>
                                        <option value="Otro">Otro</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="descripcion" class="form-label">Descripción del puesto</label>
                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" required></textarea>
                        </div>
                        
                        <div class="mb-3">
                            <label for="requisitos" class="form-label">Requisitos</label>
                            <textarea class="form-control" id="requisitos" name="requisitos" rows="3"></textarea>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="ubicacion" class="form-label">Ubicación</label>
                                    <input type="text" class="form-control" id="ubicacion" name="ubicacion">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="tipo_contrato" class="form-label">Tipo de Contrato</label>
                                    <select class="form-select" id="tipo_contrato" name="tipo_contrato">
                                        <option value="">Seleccionar</option>
                                        <option value="Tiempo Completo">Tiempo Completo</option>
                                        <option value="Medio Tiempo">Medio Tiempo</option>
                                        <option value="Por Proyecto">Por Proyecto</option>
                                        <option value="Temporal">Temporal</option>
                                        <option value="Prácticas">Prácticas</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="salario" class="form-label">Salario</label>
                                    <input type="text" class="form-control" id="salario" name="salario">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="modalidad" class="form-label">Modalidad</label>
                                    <select class="form-select" id="modalidad" name="modalidad">
                                        <option value="Presencial">Presencial</option>
                                        <option value="Remoto">Remoto</option>
                                        <option value="Híbrido">Híbrido</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="experiencia" class="form-label">Experiencia requerida</label>
                                    <input type="text" class="form-control" id="experiencia" name="experiencia">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="vacantes" class="form-label">Vacantes</label>
                                    <input type="number" class="form-control" id="vacantes" name="vacantes" min="1" value="1">
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="fecha_expiracion" class="form-label">Fecha de Expiración</label>
                                    <input type="date" class="form-control" id="fecha_expiracion" name="fecha_expiracion">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="estado" class="form-label">Estado</label>
                                    <select class="form-select" id="estado" name="estado">
                                        <option value="Activa">Activa</option>
                                        <option value="Inactiva">Inactiva</option>
                                        <option value="Cerrada">Cerrada</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <input type="hidden" name="empresa_id" value="<?php echo $empresa_id; ?>">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" form="formNuevaOferta" class="btn btn-primary">Guardar Oferta</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function verOferta(id) {
            // Lógica para ver detalles de la oferta
            alert('Mostrando detalles de la oferta ID: ' + id);
        }
        
        function editarOferta(id) {
            // Lógica para editar la oferta
            alert('Editando oferta ID: ' + id);
        }
        
        function eliminarOferta(id) {
            if(confirm('¿Estás seguro de que deseas eliminar esta oferta?')) {
                // Lógica para eliminar la oferta
                alert('Oferta ID: ' + id + ' eliminada');
                // Aquí iría una llamada AJAX o redirección para eliminar
            }
        }
    </script>
</body>
</html>