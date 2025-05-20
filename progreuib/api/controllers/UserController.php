<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/AuthMiddleware.php';
require_once __DIR__ . '/../utils/ResponseHandler.php';

class UserController {
    private $userModel;
    
    public function __construct() {
        $this->userModel = new User();
    }
    
    public function getAll() {
        $users = $this->userModel->getAll();
        ResponseHandler::sendResponse($users);
    }
    
    public function getById($id) {
        $user = $this->userModel->getById($id);
        
        if (!$user) {
            ResponseHandler::sendError(404, 'Usuario no encontrado');
        }
        
        ResponseHandler::sendResponse($user);
    }
    
    public function create() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $required = ['name', 'email', 'password', 'role'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                ResponseHandler::sendError(400, "El campo $field es requerido");
            }
        }
        
        if ($this->userModel->getByEmail($data['email'])) {
            ResponseHandler::sendError(400, 'El email ya está registrado');
        }
        
        $userId = $this->userModel->create([
            'Nombre' => $data['name'],
            'Correo' => $data['email'],
            'Contraseña' => password_hash($data['password'], PASSWORD_BCRYPT),
            'Rol' => $data['role'],
            'Area' => $data['area'] ?? null,
            'Especialidad' => $data['specialty'] ?? null
        ]);
        
        ResponseHandler::sendResponse(['id' => $userId], 201);
    }
}