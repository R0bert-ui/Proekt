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

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 9;
$offset = ($page - 1) * $limit;

try {
    $car = new Car($pdo);
    
    // Получаем все машины
    $result = $car->getAll();
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
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
