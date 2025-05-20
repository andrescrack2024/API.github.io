<?php
require_once __DIR__ . '/ResponseHandler.php';
require_once __DIR__ . '/../config/constants.php';

class AuthMiddleware {
    public static function authenticate($allowedRoles = []) {
        $headers = getallheaders();
        $authHeader = $headers['Authorization'] ?? '';
        
        if (empty($authHeader) || !preg_match('/Bearer\s(\S+)/', $authHeader, $matches)) {
            ResponseHandler::sendError(401, 'Token no proporcionado');
        }
        
        $token = $matches[1];
        $payload = self::validateToken($token);
        
        if (!empty($allowedRoles) && !in_array($payload['role'], $allowedRoles)) {
            ResponseHandler::sendError(403, 'No autorizado para este recurso');
        }
        
        return $payload;
    }
    
    public static function generateToken($data) {
        $payload = [
            'iss' => 'progreuib-api',
            'iat' => time(),
            'exp' => time() + JWT_EXPIRE,
            'data' => $data
        ];
        
        return base64_encode(json_encode($payload));
    }
    
    private static function validateToken($token) {
        try {
            $payload = json_decode(base64_decode($token), true);
            
            if (!$payload || !isset($payload['data'], $payload['exp'])) {
                throw new Exception('Token inválido');
            }
            
            if ($payload['exp'] < time()) {
                throw new Exception('Token expirado');
            }
            
            return $payload['data'];
        } catch (Exception $e) {
            ResponseHandler::sendError(401, $e->getMessage());
        }
    }
}