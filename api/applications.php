<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'error' => 'Method Not Allowed'], JSON_UNESCAPED_UNICODE);
    exit;
}

require_once '../config/database.php';
require_once '../classes/applications.php';

session_start();

$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!is_array($data)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Empty body or invalid JSON'], JSON_UNESCAPED_UNICODE);
    exit;
}

$requiredFields = ['car_id', 'full_name', 'phone', 'email'];
$errors = [];

foreach ($requiredFields as $field) {
    if (empty($data[$field]) || trim($data[$field]) === '') {
        $errors[] = "Field '$field' is required";
    }
}

if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Invalid email format';
}

if (!empty($data['car_id']) && (!is_numeric($data['car_id']) || (int)$data['car_id'] <= 0)) {
    $errors[] = 'Invalid car_id';
}

if (!empty($errors)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'Validation failed', 'details' => $errors], JSON_UNESCAPED_UNICODE);
    exit;
}

try {
    $carId = (int)$data['car_id'];
    $check = $pdo->prepare('SELECT id FROM cars WHERE id = :id');
    $check->execute([':id' => $carId]);

    if (!$check->fetch()) {
        http_response_code(404);
        echo json_encode(['success' => false, 'error' => 'Car not found'], JSON_UNESCAPED_UNICODE);
        exit;
    }

    $application = new Application($pdo);
    $application->car_id = $carId;
    $application->user_id = isset($_SESSION['user_id']) ? (int)$_SESSION['user_id'] : null;
    $application->full_name = trim($data['full_name']);
    $application->phone = trim($data['phone']);
    $application->email = trim($data['email']);
    $application->comment = trim($data['comment'] ?? '');
    $application->status = 'new';

    if ($application->create()) {
        http_response_code(201);
        echo json_encode([
            'success' => true,
            'message' => 'Application created successfully',
            'data' => [
                'id' => $application->id,
                'car_id' => $application->car_id,
                'full_name' => $application->full_name,
                'phone' => $application->phone,
                'email' => $application->email,
                'comment' => $application->comment,
                'status' => $application->status,
            ]
        ], JSON_UNESCAPED_UNICODE);
        exit;
    }

    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Unable to save application'], JSON_UNESCAPED_UNICODE);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()], JSON_UNESCAPED_UNICODE);
}
