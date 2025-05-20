<?php
require_once __DIR__ . '/../utils/DatabaseHelper.php';

class Oferta {
    private $db;

    public function __construct() {
        $this->db = DatabaseHelper::getConnection();
    }

    public function getAllWithCompanies() {
        $query = "SELECT o.*, e.Nombre as empresa_nombre 
                 FROM ofertas o 
                 JOIN empresas e ON o.Empresa_id = e.ID";
        $stmt = $this->db->query($query);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}