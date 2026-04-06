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
        // Get all cars with filters and pagination
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 9;
        $offset = ($page - 1) * $limit;

        // Collect filters
        $filters = [];
        if (!empty($_GET['search'])) {
            $filters['search'] = $_GET['search'];
        }
        if (!empty($_GET['brand'])) {
            $filters['brand'] = $_GET['brand'];
        }
        if (!empty($_GET['model'])) {
            $filters['model'] = $_GET['model'];
        }
        if (!empty($_GET['price_min'])) {
            $filters['price_min'] = $_GET['price_min'];
        }
        if (!empty($_GET['price_max'])) {
            $filters['price_max'] = $_GET['price_max'];
        }
        if (!empty($_GET['year_min'])) {
            $filters['year_min'] = $_GET['year_min'];
        }
        if (!empty($_GET['year_max'])) {
            $filters['year_max'] = $_GET['year_max'];
        }
        if (!empty($_GET['mileage_max'])) {
            $filters['mileage_max'] = $_GET['mileage_max'];
        }
        if (!empty($_GET['gearbox'])) {
            $filters['gearbox'] = $_GET['gearbox'];
        }
        if (!empty($_GET['fuel'])) {
            $filters['fuel'] = $_GET['fuel'];
        }
        if (!empty($_GET['sort'])) {
            $filters['sort'] = $_GET['sort'];
        }

        // Get filtered cars
        $result = $car->searchWithFilters($filters);
        $allCars = $result->fetchAll(PDO::FETCH_ASSOC);
        $totalCars = count($allCars);
        
        // Paginate
        $cars = array_slice($allCars, $offset, $limit);
        $totalPages = ceil($totalCars / $limit);
        
        // Get filter options for frontend
        $brands = $car->getBrands();
        $gearboxes = $car->getGearboxes();
        $fuels = $car->getFuels();
        
        echo json_encode([
            'success' => true,
            'data' => $cars,
            'pagination' => [
                'current_page' => $page,
                'per_page' => $limit,
                'total' => $totalCars,
                'total_pages' => $totalPages
            ],
            'filters' => [
                'brands' => $brands,
                'gearboxes' => $gearboxes,
                'fuels' => $fuels
            ]
        ]);
    }
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
