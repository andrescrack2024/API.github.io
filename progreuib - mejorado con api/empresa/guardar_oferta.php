<?php
session_start();
require_once '../conex.php';

// Verificar sesión y datos POST
if (!isset($_SESSION['empresa_id']) || empty($_POST['titulo'])) {
    header("Location: empresas.php");
    exit();
}

// Datos básicos de la oferta
$titulo = htmlspecialchars($_POST['titulo']);
$descripcion = htmlspecialchars($_POST['descripcion']);
$empresa_id = $_SESSION['empresa_id'];

// Conexión y consulta
$conn = new mysqli("localhost", "root", "", "progreuib");
$sql = "INSERT INTO ofertas (Titulo, Descripcion, Empresa_id) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssi", $titulo, $descripcion, $empresa_id);

if ($stmt->execute()) {
    $_SESSION['mensaje'] = "Oferta guardada correctamente";
} else {
    $_SESSION['mensaje'] = "Error al guardar: " . $stmt->error;
}

$stmt->close();
$conn->close();
header("Location: empresas.php");
exit();
?>