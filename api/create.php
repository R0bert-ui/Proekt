<?php
// Говорим браузеру и Postman что вернём JSON
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Подключаем базу данных
require_once '../config/database.php';

// Разрешаем только POST-запросы
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

// Читаем тело запроса и декодируем JSON
$input = file_get_contents('php://input');
$data  = json_decode($input, true);

// Проверяем что данные вообще пришли
if (!$data) {
    http_response_code(400);
    echo json_encode(['error' => 'Empty body or invalid JSON'], JSON_UNESCAPED_UNICODE);
    exit;
}

// Проверяем обязательные поля для таблицы cars
$required_fields = ['brand', 'model', 'year', 'price', 'mileage'];
$errors = [];

foreach ($required_fields as $field) {
    if (empty($data[$field])) {
        $errors[] = "Field '$field' is required";
    }
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['error' => 'Validation failed', 'details' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    // Вставляем новый автомобиль в таблицу cars
    $stmt = $pdo->prepare(
        'INSERT INTO cars (brand, model, year, price, mileage, gearbox, fuel, popularity, photo_url) 
         VALUES (:brand, :model, :year, :price, :mileage, :gearbox, :fuel, :popularity, :photo_url)'
    );
    
    $stmt->execute([
        ':brand'      => $data['brand'],
        ':model'      => $data['model'],
        ':year'       => (int)$data['year'],
        ':price'      => (float)$data['price'],
        ':mileage'    => (int)$data['mileage'],
        ':gearbox'    => $data['gearbox'] ?? null,
        ':fuel'       => $data['fuel'] ?? null,
        ':popularity' => (int)($data['popularity'] ?? 0),
        ':photo_url'  => $data['photo_url'] ?? null,
    ]);

    // lastInsertId() возвращает ID только что созданного автомобиля
    $newId = $pdo->lastInsertId();

    http_response_code(201); // 201 = Created
    echo json_encode([
        'success' => true,
        'id'      => $newId,
        'message' => 'Car created successfully',
        'data'    => array_merge(['id' => $newId], $data)
    ], JSON_UNESCAPED_UNICODE);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => 'Database error: ' . $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
