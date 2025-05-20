<?php
class ResponseHandler {
    public static function sendResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        echo json_encode([
            'success' => true,
            'data' => $data,
            'timestamp' => date('c')
        ]);
        exit;
    }
    
    public static function sendError($statusCode, $message, $details = null) {
        http_response_code($statusCode);
        echo json_encode([
            'success' => false,
            'error' => [
                'code' => $statusCode,
                'message' => $message,
                'details' => $details
            ],
            'timestamp' => date('c')
        ]);
        exit;
    }
}