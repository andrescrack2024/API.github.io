<?php
require_once __DIR__ . '/../models/Empresa.php';
require_once __DIR__ . '/../utils/ResponseHandler.php';

class EmpresaController {
    private $empresaModel;

    public function __construct() {
        $this->empresaModel = new Empresa();
    }

    public function getAll() {
        try {
            $empresas = $this->empresaModel->getAll();
            ResponseHandler::sendResponse($empresas);
        } catch (Exception $e) {
            ResponseHandler::sendError(500, 'Error al obtener empresas');
        }
    }
}