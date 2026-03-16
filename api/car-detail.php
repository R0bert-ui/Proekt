<?php
session_start();
require_once '../config/database.php';
require_once '../classes/cars.php';

// Проверяем авторизацию
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Не авторизован']);
    exit;
}

header('Content-Type: application/json');

$carId = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$carId) {
    http_response_code(400);
    echo json_encode(['error' => 'ID автомобиля не указан']);
    exit;
}

try {
    $car = new Car($pdo);
    
    // Получаем данные автомобиля
    if (!$car->getById($carId)) {
        http_response_code(404);
        echo json_encode(['error' => 'Автомобиль не найден']);
        exit;
    }
    
    $carData = [
        'id' => $car->id,
        'brand' => $car->brand,
        'model' => $car->model,
        'year' => $car->year,
        'price' => $car->price,
        'mileage' => $car->mileage,
        'gearbox' => $car->gearbox,
        'fuel' => $car->fuel,
        'popularity' => $car->popularity,
        'photo_url' => $car->photo_url,
        'created_at' => $car->created_at
    ];
    
    // Получаем историю автомобиля
    $stmt = $pdo->prepare("SELECT * FROM car_history WHERE car_id = ? ORDER BY date DESC");
    $stmt->execute([$carId]);
    $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Получаем техническое обслуживание
    $stmt = $pdo->prepare("SELECT * FROM car_service WHERE car_id = ? ORDER BY date DESC");
    $stmt->execute([$carId]);
    $service = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Получаем отзывы
    $stmt = $pdo->prepare("SELECT id, author, rating, comment, created_at FROM car_reviews WHERE car_id = ? ORDER BY created_at DESC LIMIT 10");
    $stmt->execute([$carId]);
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Получаем похожие автомобили той же марки
    $stmt = $pdo->prepare("SELECT id, brand, model, year, price, photo_url FROM cars WHERE brand = ? AND id != ? LIMIT 4");
    $stmt->execute([$car->brand, $carId]);
    $similarCars = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'data' => [
            'car' => $carData,
            'history' => $history,
            'service' => $service,
            'reviews' => $reviews,
            'similar_cars' => $similarCars
        ]
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
