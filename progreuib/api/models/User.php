<?php
require_once __DIR__ . '/../utils/DatabaseHelper.php';

class User {
    private $db;
    
    public function __construct() {
        $this->db = DatabaseHelper::getConnection();
    }
    
    public function getByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE Correo = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM usuarios WHERE ID = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT ID, Nombre, Correo, Rol, Area, Especialidad FROM usuarios");
        return $stmt->fetchAll();
    }
    
    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO usuarios 
            (Nombre, Correo, Contraseña, Rol, Area, Especialidad) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmt->execute([
            $data['Nombre'],
            $data['Correo'],
            $data['Contraseña'],
            $data['Rol'],
            $data['Area'],
            $data['Especialidad']
        ]);
        return $this->db->lastInsertId();
    }
}