<?php
session_start();
require_once '../auth/auth_check.php';
require_once '../config/database.php';
require_once '../classes/cars.php';
require_once '../classes/applications.php';
require_once '../classes/logs.php';

if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: home.php');
    exit;
}

$car = new Car($pdo);
$application = new Application($pdo);
$log = new Log($pdo);

// Обработка выхода
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_car'])) {
        // Check limit
        if ($car->getCount() >= 500) {
            $error = 'Достигнуто максимальное количество автомобилей (500).';
        } else {
            $car->brand = $_POST['brand'];
            $car->model = $_POST['model'];
            $car->year = $_POST['year'];
            $car->price = $_POST['price'];
            $car->mileage = $_POST['mileage'];
            $car->gearbox = $_POST['gearbox'];
            $car->fuel = $_POST['fuel'];
            $car->popularity = $_POST['popularity'];
            $car->status = 'available';

            // Валидация данных
            $validationErrors = $car->validateCarData();
            if (!empty($validationErrors)) {
                $error = 'Ошибки валидации: ' . implode('; ', $validationErrors);
            } else {
                // Photo validation
                if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                    if (in_array($_FILES['photo']['type'], $allowedTypes) && $_FILES['photo']['size'] <= 5 * 1024 * 1024) { // 5MB
                        $uploadDir = '../uploads/';
                        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                        $fileName = uniqid() . '_' . basename($_FILES['photo']['name']);
                        $filePath = $uploadDir . $fileName;
                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $filePath)) {
                            $car->photo_url = '/uploads/' . $fileName;
                        } else {
                            $error = 'Ошибка загрузки фото.';
                        }
                    } else {
                        $error = 'Неверный тип файла или размер превышает 5MB.';
                    }
                }

                if (!isset($error) && $car->create()) {
                    // Log
                    $log->user_id = $_SESSION['user_id'];
                    $log->action = 'add_car';
                    $log->details = "Added car: {$car->brand} {$car->model}";
                    $log->create();
                    $success = 'Автомобиль добавлен.';
                } else {
                    $error = $error ?? 'Ошибка добавления автомобиля.';
                }
            }
        }
    } elseif (isset($_POST['edit_car'])) {
        $car->id = $_POST['id'];
        $car->brand = $_POST['brand'];
        $car->model = $_POST['model'];
        $car->year = $_POST['year'];
        $car->price = $_POST['price'];
        $car->mileage = $_POST['mileage'];
        $car->gearbox = $_POST['gearbox'];
        $car->fuel = $_POST['fuel'];
        $car->popularity = $_POST['popularity'];
        $car->status = $_POST['status'];

        // Валидация данных
        $validationErrors = $car->validateCarData();
        if (!empty($validationErrors)) {
            $error = 'Ошибки валидации: ' . implode('; ', $validationErrors);
        } elseif ($car->update()) {
            $log->user_id = $_SESSION['user_id'];
            $log->action = 'edit_car';
            $log->details = "Edited car ID: {$car->id}";
            $log->create();
            $success = 'Автомобиль обновлен.';
        } else {
            $error = 'Ошибка обновления.';
        }
    } elseif (isset($_POST['delete_car'])) {
        if ($car->delete($_POST['id'])) {
            $log->user_id = $_SESSION['user_id'];
            $log->action = 'delete_car';
            $log->details = "Deleted car ID: {$_POST['id']}";
            $log->create();
            $success = 'Автомобиль удален.';
        } else {
            $error = 'Ошибка удаления.';
        }
    } elseif (isset($_POST['mark_sold'])) {
        if ($car->markSold($_POST['id'])) {
            $log->user_id = $_SESSION['user_id'];
            $log->action = 'mark_sold';
            $log->details = "Marked car ID: {$_POST['id']} as sold";
            $log->create();
            $success = 'Автомобиль отмечен как проданный.';
        } else {
            $error = 'Ошибка.';
        }
    } elseif (isset($_POST['update_application'])) {
        $application->id = $_POST['id'];
        $application->status = $_POST['status'];
        if ($application->update()) {
            $log->user_id = $_SESSION['user_id'];
            $log->action = 'update_application';
            $log->details = "Updated application ID: {$application->id} to {$application->status}";
            $log->create();
            $success = 'Статус заявки обновлен.';
        } else {
            $error = 'Ошибка обновления статуса.';
        }
    }
}

// Get data
$cars = $car->getAll();
$applications = $application->getAll();

// Statistics
$stats = [];
$stats['total_cars'] = $car->getCount();
$stats['available_cars'] = $pdo->query("SELECT COUNT(*) FROM cars WHERE status != 'sold'")->fetchColumn();
$stats['sold_cars'] = $pdo->query("SELECT COUNT(*) FROM cars WHERE status = 'sold'")->fetchColumn();
$stats['total_applications'] = $pdo->query("SELECT COUNT(*) FROM applications")->fetchColumn();
$stats['pending_applications'] = $pdo->query("SELECT COUNT(*) FROM applications WHERE status = 'new'")->fetchColumn();
$stats['approved_applications'] = $pdo->query("SELECT COUNT(*) FROM applications WHERE status = 'approved'")->fetchColumn();
$stats['rejected_applications'] = $pdo->query("SELECT COUNT(*) FROM applications WHERE status = 'rejected'")->fetchColumn();
$stats['monthly_sales'] = $car->getMonthlySoldCount();
$stats['monthly_revenue'] = $car->getMonthlyRevenue();

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Панель администратора</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: #f9f9f9;
            color: #2c2c2c;
        }

        /* Шапка */
        header {
            background: #ffffff;
            color: #2c2c2c;
            padding: 18px 0;
            border-bottom: 1px solid #e5e5e5;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .header-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .header-left h1 {
            font-size: 20px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .user-info i {
            font-size: 18px;
            color: #666;
        }

        .user-name {
            font-size: 14px;
            font-weight: 400;
            color: #2c2c2c;
        }

        .logout-btn {
            background: #f5f5f5;
            border: 1px solid #d0d0d0;
            color: #2c2c2c;
            padding: 9px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 13px;
            transition: all 0.2s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .logout-btn:hover {
            background: #e5e5e5;
        }

        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .section {
            background: #ffffff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .section h2 {
            margin-bottom: 15px;
            color: #2c2c2c;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }

        .stat-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            text-align: center;
        }

        .stat-value {
            font-size: 24px;
            font-weight: 600;
            color: #007bff;
        }

        .stat-label {
            font-size: 14px;
            color: #666;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }

        .form-group input, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .btn {
            background: #007bff;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            margin-right: 10px;
        }

        .btn:hover {
            background: #0056b3;
        }

        .btn-danger {
            background: #dc3545;
        }

        .btn-danger:hover {
            background: #c82333;
        }
        .btn1-danger {
            background: #298017;
        }

        .btn1-danger:hover {
            background: #0f7c1d;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #e5e5e5;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #f8f9fa;
            font-weight: 600;
        }

        .action-btns {
            display: flex;
            gap: 5px;
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.5);
        }

        .modal-content {
            background: white;
            margin: 10% auto;
            padding: 20px;
            border-radius: 8px;
            width: 90%;
            max-width: 500px;
        }

        .close {
            float: right;
            font-size: 28px;
            cursor: pointer;
        }

        .success {
            color: #28a745;
            background: #d4edda;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }

        .error {
            color: #dc3545;
            background: #f8d7da;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <div class="header-left">
                <h1>Панель администратора</h1>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <i class="fas fa-user-shield"></i>
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
                <a href="?action=logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Выйти
                </a>
            </div>
        </div>
    </header>

    <div class="main-container">
        <?php if (isset($success)) echo "<div class='success'>$success</div>"; ?>
        <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

        <div class="section">
            <h2>Статистика</h2>
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['total_cars']; ?></div>
                    <div class="stat-label">Всего авто</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['available_cars']; ?></div>
                    <div class="stat-label">Доступно</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['sold_cars']; ?></div>
                    <div class="stat-label">Продано</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['total_applications']; ?></div>
                    <div class="stat-label">Заявок</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo $stats['monthly_sales']; ?></div>
                    <div class="stat-label">Продаж в месяц</div>
                </div>
                <div class="stat-card">
                    <div class="stat-value"><?php echo number_format($stats['monthly_revenue'], 0, ',', ' '); ?> ₸</div>
                    <div class="stat-label">Выручка в месяц</div>
                </div>
            </div>
        </div>

        <div class="section">
            <h2>Добавить новый автомобиль</h2>
            <form method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Марка</label>
                    <input type="text" name="brand" required minlength="2" maxlength="100" placeholder="Например: Toyota">
                </div>
                <div class="form-group">
                    <label>Модель</label>
                    <input type="text" name="model" required minlength="2" maxlength="100" placeholder="Например: Camry">
                </div>
                <div class="form-group">
                    <label>Год</label>
                    <input type="number" name="year" required min="1900" max="2100" placeholder="2024">
                </div>
                <div class="form-group">
                    <label>Цена (₸)</label>
                    <input type="number" name="price" required min="1" step="0.01" placeholder="1000000">
                </div>
                <div class="form-group">
                    <label>Пробег</label>
                    <input type="number" name="mileage" required min="0" placeholder="0">
                </div>
                <div class="form-group">
                    <label>КПП</label>
                    <input type="text" name="gearbox" required placeholder="Например: АКПП">
                </div>
                <div class="form-group">
                    <label>Топливо</label>
                    <input type="text" name="fuel" required placeholder="Например: Бензин">
                </div>
                <div class="form-group">
                    <label>Популярность</label>
                    <input type="number" name="popularity" required min="0" value="0" placeholder="0">
                </div>
                <div class="form-group">
                    <label>Фото</label>
                    <input type="file" name="photo" accept="image/*">
                </div>
                <button type="submit" name="add_car" class="btn">Добавить</button>
            </form>
        </div>

        <div class="section">
            <h2>Список автомобилей</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Марка</th>
                    <th>Модель</th>
                    <th>Год</th>
                    <th>Цена</th>
                    <th>Пробег</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                <?php while ($row = $cars->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['brand']; ?></td>
                    <td><?php echo $row['model']; ?></td>
                    <td><?php echo $row['year']; ?></td>
                    <td><?php echo number_format($row['price'], 0, ',', ' '); ?> ₸</td>
                    <td><?php echo number_format($row['mileage'], 0, ',', ' '); ?> км</td>
                    <td><?php echo ($row['status'] == 'available' ? 'Доступен' : 'Продан'); ?></td>
                    <td class="action-btns">
                        <button class="btn" onclick="editCar(<?php echo $row['id']; ?>)">Редактировать</button>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="mark_sold" class="btn btn1-danger" onclick="return confirm('Отметить как продано?')">Продано</button>
                        </form>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_car" class="btn btn-danger" onclick="return confirm('Удалить?')">Удалить</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>

        <div class="section">
            <h2>Список заявок</h2>
            <table>
                <tr>
                    <th>ID</th>
                    <th>Авто</th>
                    <th>Пользователь</th>
                    <th>Телефон</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
                <?php while ($row = $applications->fetch(PDO::FETCH_ASSOC)): ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['car_id']; ?></td>
                    <td><?php echo $row['full_name']; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php 
                        $statusTexts = [
                            'new' => 'Новая',
                            'approved' => 'Одобрена',
                            'rejected' => 'Отклонена'
                        ];
                        echo $statusTexts[$row['status']] ?? $row['status'];
                    ?></td>
                    <td>
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                            <select name="status">
                                <option value="new" <?php if ($row['status'] == 'new') echo 'selected'; ?>>Новая</option>
                                <option value="approved" <?php if ($row['status'] == 'approved') echo 'selected'; ?>>Одобрена</option>
                                <option value="rejected" <?php if ($row['status'] == 'rejected') echo 'selected'; ?>>Отклонена</option>
                            </select>
                            <button type="submit" name="update_application" class="btn">Обновить</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        </div>
    </div>

    <!-- Modal for editing car -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Редактировать автомобиль</h2>
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="edit_id">
                <div class="form-group">
                    <label>Марка</label>
                    <input type="text" name="brand" id="edit_brand" required minlength="2" maxlength="100">
                </div>
                <div class="form-group">
                    <label>Модель</label>
                    <input type="text" name="model" id="edit_model" required minlength="2" maxlength="100">
                </div>
                <div class="form-group">
                    <label>Год</label>
                    <input type="number" name="year" id="edit_year" required min="1900" max="2100">
                </div>
                <div class="form-group">
                    <label>Цена (₸)</label>
                    <input type="number" name="price" id="edit_price" required min="1" step="0.01">
                </div>
                <div class="form-group">
                    <label>Пробег</label>
                    <input type="number" name="mileage" id="edit_mileage" required min="0">
                </div>
                <div class="form-group">
                    <label>КПП</label>
                    <input type="text" name="gearbox" id="edit_gearbox" required>
                </div>
                <div class="form-group">
                    <label>Топливо</label>
                    <input type="text" name="fuel" id="edit_fuel" required>
                </div>
                <div class="form-group">
                    <label>Популярность</label>
                    <input type="number" name="popularity" id="edit_popularity" required min="0">
                </div>
                <div class="form-group">
                    <label>Статус</label>
                    <select name="status" id="edit_status">
                        <option value="available">Доступен</option>
                        <option value="sold">Продан</option>
                    </select>
                </div>
                <button type="submit" name="edit_car" class="btn">Сохранить</button>
            </form>
        </div>
    </div>

    <script>
        // Валидация формы на клиенте
        function validateCarForm(formElement) {
            const errors = [];
            
            const brand = formElement.querySelector('[name="brand"]').value.trim();
            const model = formElement.querySelector('[name="model"]').value.trim();
            const year = parseInt(formElement.querySelector('[name="year"]').value);
            const price = parseFloat(formElement.querySelector('[name="price"]').value);
            const mileage = parseInt(formElement.querySelector('[name="mileage"]').value);
            const gearbox = formElement.querySelector('[name="gearbox"]').value.trim();
            const fuel = formElement.querySelector('[name="fuel"]').value.trim();
            const popularity = parseInt(formElement.querySelector('[name="popularity"]').value);

            if (!brand || brand.length < 2) {
                errors.push('Марка должна содержать минимум 2 символа');
            }

            if (!model || model.length < 2) {
                errors.push('Модель должна содержать минимум 2 символа');
            }

            if (!year || year < 1900 || year > new Date().getFullYear() + 1) {
                errors.push('Год должен быть от 1900 до ' + (new Date().getFullYear() + 1));
            }

            if (!price || price <= 0) {
                errors.push('Цена должна быть больше 0');
            }

            if (mileage < 0) {
                errors.push('Пробег не может быть отрицательным');
            }

            if (!gearbox) {
                errors.push('КПП обязательна');
            }

            if (!fuel) {
                errors.push('Тип топлива обязателен');
            }

            if (popularity < 0) {
                errors.push('Популярность не может быть отрицательной');
            }

            if (errors.length > 0) {
                alert(errors.join('\n'));
                return false;
            }

            return true;
        }

        function editCar(id) {
            fetch('../api/cars.php?id=' + id)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP error, status: ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log('API Response:', data);
                    if (data.success && data.data) {
                        const car = data.data;
                        console.log('Car data:', car);
                        document.getElementById('edit_id').value = car.id;
                        document.getElementById('edit_brand').value = car.brand;
                        document.getElementById('edit_model').value = car.model;
                        document.getElementById('edit_year').value = car.year;
                        document.getElementById('edit_price').value = car.price;
                        document.getElementById('edit_mileage').value = car.mileage;
                        document.getElementById('edit_gearbox').value = car.gearbox;
                        document.getElementById('edit_fuel').value = car.fuel;
                        document.getElementById('edit_popularity').value = car.popularity;
                        document.getElementById('edit_status').value = car.status;
                        document.getElementById('editModal').style.display = 'block';
                    } else {
                        console.error('Invalid response format:', data);
                        alert('Ошибка загрузки данных автомобиля. Проверьте консоль (F12)');
                    }
                })
                .catch(error => {
                    console.error('Fetch error:', error);
                    alert('Ошибка при загрузке данных: ' + error.message);
                });
        }

        function closeModal() {
            document.getElementById('editModal').style.display = 'none';
        }

        window.onclick = function(event) {
            if (event.target == document.getElementById('editModal')) {
                closeModal();
            }
        }

        // Добавляем валидацию на отправку форм
        document.addEventListener('DOMContentLoaded', function() {
            const addCarForm = document.querySelector('form [name="add_car"]');
            const editCarForm = document.querySelector('form [name="edit_car"]');
            
            if (addCarForm) {
                addCarForm.closest('form').addEventListener('submit', function(e) {
                    if (!validateCarForm(this)) {
                        e.preventDefault();
                    }
                });
            }
            
            if (editCarForm) {
                editCarForm.closest('form').addEventListener('submit', function(e) {
                    if (!validateCarForm(this)) {
                        e.preventDefault();
                    }
                });
            }
        });
    </script>
</body>
</html>