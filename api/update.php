<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once '../config/database.php';

// Разрешаем только PUT
if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

$input = file_get_contents('php://input');
$data  = json_decode($input, true);

// Для обновления обязательно нужен id — иначе не знаем что менять
if (!$data || empty($data['id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Field id is required'], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Сначала проверяем — вдруг такой машины нет
    $check = $pdo->prepare('SELECT id FROM cars WHERE id = :id');
    $check->execute([':id' => (int)$data['id']]);
    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['error' => 'Car not found'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Обновляем только переданные поля (опционально, иначе ошибка)
    $updates = [];
    $bindings = [':id' => (int)$data['id']];
    
    $updatable_fields = ['brand', 'model', 'year', 'price', 'mileage', 'gearbox', 'fuel', 'popularity', 'photo_url'];
    
    foreach ($updatable_fields as $field) {
        if (isset($data[$field]) && $data[$field] !== '') {
            $updates[] = "$field = :$field";
            
            // Типизируем данные
            if (in_array($field, ['year', 'mileage', 'popularity'])) {
                $bindings[":$field"] = (int)$data[$field];
            } elseif (in_array($field, ['price'])) {
                $bindings[":$field"] = (float)$data[$field];
            } else {
                $bindings[":$field"] = $data[$field];
            }
        }
    }
    
    // Если ничего не передали для обновления
    if (empty($updates)) {
        http_response_code(400);
        echo json_encode(['error' => 'No fields to update'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    // Сформируем и выполним запрос UPDATE
    $query = 'UPDATE cars SET ' . implode(', ', $updates) . ' WHERE id = :id';
    $stmt = $pdo->prepare($query);
    $stmt->execute($bindings);

    http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Car updated successfully',
        'id' => (int)$data['id']
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
