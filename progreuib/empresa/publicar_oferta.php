<?php
session_start();
include("../conex.php");

if (!isset($_SESSION['Rol']) || $_SESSION['Rol'] !== 'Empresa') {
    header("Location: ../login.php");
    exit;
}

$empresaId = $_SESSION['ID'];

// Recoger datos del formulario
$titulo = $_POST['Titulo'] ?? '';
$descripcion = $_POST['Descripcion'] ?? '';
$requisitos = $_POST['Requisitos'] ?? '';
$area = $_POST['Area'] ?? '';
$ubicacion = $_POST['Ubicacion'] ?? '';
$tipoContrato = $_POST['Tipo_Contrato'] ?? '';
$salario = $_POST['Salario'] ?? '';
$modalidad = $_POST['Modalidad'] ?? 'Presencial';

// Validar datos requeridos
if (empty($titulo) || empty($descripcion) || empty($area)) {
    header("Location: empresas.php?mensaje=Faltan campos requeridos&clase=alert-danger");
    exit;
}

// Preparar la consulta sin campo de imagen
$stmt = $conexion->prepare("INSERT INTO ofertas (
    Titulo, 
    Descripcion, 
    Requisitos, 
    Area, 
    Empresa_id, 
    Ubicacion, 
    Tipo_Contrato, 
    Salario,
    Modalidad,
    Fecha_Publicacion,
    Estado
) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 'Activa')");

$stmt->bind_param(
    "ssssissss",
    $titulo,
    $descripcion,
    $requisitos,
    $area,
    $empresaId,
    $ubicacion,
    $tipoContrato,
    $salario,
    $modalidad
);

if ($stmt->execute()) {
    header("Location: empresas.php?mensaje=Oferta publicada correctamente&clase=alert-success");
} else {
    header("Location: empresas.php?mensaje=Error al publicar la oferta&clase=alert-danger");
}

$stmt->close();
$conexion->close();
