<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/utils/ResponseHandler.php';
require_once __DIR__ . '/utils/DatabaseHelper.php';

// Configuración de headers
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

// Manejo de CORS para OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Endpoints disponibles
switch (true) {
    // Endpoint para empresas
    case $requestUri === '/api/empresas' && $requestMethod === 'GET':
        require_once __DIR__ . '/controllers/EmpresaController.php';
        (new EmpresaController())->getAll();
        break;
        
    // Endpoint para ofertas laborales
    case $requestUri === '/api/ofertas' && $requestMethod === 'GET':
        require_once __DIR__ . '/controllers/OfertaController.php';
        (new OfertaController())->getAll();
        break;
        
    // Endpoint para usuarios
    case $requestUri === '/api/usuarios' && $requestMethod === 'GET':
        require_once __DIR__ . '/controllers/UsuarioController.php';
        (new UsuarioController())->getAll();
        break;
        
    // Endpoint para contactos
    case $requestUri === '/api/contactos' && $requestMethod === 'POST':
        require_once __DIR__ . '/controllers/ContactoController.php';
        (new ContactoController())->create();
        break;
        
    default:
        ResponseHandler::sendError(404, 'Endpoint no disponible');
}