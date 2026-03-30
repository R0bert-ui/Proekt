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

try {
    $car = new Car($pdo);
    
    if (isset($_GET['id'])) {
        // Get single car
        $car->getById($_GET['id']);
        if ($car->id) {
            echo json_encode([
                'success' => true,
                'data' => [
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
                    'status' => $car->status
                ]
            ]);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Car not found']);
        }
    } else {
        // Get all cars with pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 9;
        $offset = ($page - 1) * $limit;

        $result = $car->getAvailable();
        $allCars = $result->fetchAll(PDO::FETCH_ASSOC);
        $totalCars = count($allCars);
        
        // Пагинируем
        $cars = array_slice($allCars, $offset, $limit);
        $totalPages = ceil($totalCars / $limit);
        
        echo json_encode([
            'success' => true,
            'data' => $cars,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $totalCars,
                'total_pages' => $totalPages
            ]
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
