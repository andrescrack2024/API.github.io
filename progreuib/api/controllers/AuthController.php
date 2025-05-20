<?php
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../utils/ResponseHandler.php';

class AuthController {
    public function login() {
        $data = json_decode(file_get_contents('php://input'), true);
        
        if (!isset($data['email']) || !isset($data['password'])) {
            ResponseHandler::sendError(400, 'Email y contraseña requeridos');
        }
        
        $userModel = new User();
        $user = $userModel->getByEmail($data['email']);
        
        if (!$user || !password_verify($data['password'], $user['Contraseña'])) {
            ResponseHandler::sendError(401, 'Credenciales inválidas');
        }
        
        $token = AuthMiddleware::generateToken([
            'id' => $user['ID'],
            'email' => $user['Correo'],
            'role' => $user['Rol']
        ]);
        
        ResponseHandler::sendResponse([
            'token' => $token,
            'user' => [
                'id' => $user['ID'],
                'name' => $user['Nombre'],
                'email' => $user['Correo'],
                'role' => $user['Rol']
            ]
        ]);
    }
}