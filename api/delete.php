<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config/database.php';

// Только DELETE
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

// Читаем id из тела запроса
$input = file_get_contents('php://input');
$data  = json_decode($input, true);

if (!$data || empty($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Field id is required'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Проверяем что машина существует перед удалением
    $check = $pdo->prepare('SELECT id FROM cars WHERE id = :id');
    $check->execute([':id' => (int)$data['id']]);
    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['error' => 'Car not found'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Удаляем машину
    $stmt = $pdo->prepare('DELETE FROM cars WHERE id = :id');
    $stmt->execute([':id' => (int)$data['id']]);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Car deleted successfully',
        'id' => (int)$data['id']
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}

