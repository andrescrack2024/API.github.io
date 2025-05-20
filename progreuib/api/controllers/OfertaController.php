<?php
require_once __DIR__ . '/../models/Oferta.php';
require_once __DIR__ . '/../utils/ResponseHandler.php';

class OfertaController {
    private $ofertaModel;

    public function __construct() {
        $this->ofertaModel = new Oferta();
    }

    public function getAll() {
        try {
            $ofertas = $this->ofertaModel->getAllWithCompanies();
            ResponseHandler::sendResponse($ofertas);
        } catch (Exception $e) {
            ResponseHandler::sendError(500, 'Error al obtener ofertas');
        }
    }
}