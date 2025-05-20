<?php
require_once __DIR__ . '/../utils/DatabaseHelper.php';

class Empresa {
    private $db;

    public function __construct() {
        $this->db = DatabaseHelper::getConnection();
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM empresas");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}