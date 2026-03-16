<?php
session_start();
require_once '../auth/auth_check.php';
// Если пользователь не авторизован, редирект на index.php
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

// Обработка выхода
if (isset($_GET['action']) && $_GET['action'] === 'logout') {
    session_unset();
    session_destroy();
    header('Location: ../index.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Каталог автомобилей </title>
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
            font-weight: 500;
        }

        .logout-btn:hover {
            background: #e8e8e8;
            border-color: #b0b0b0;
        }

        /* Основной контейнер */
        .main-container {
            max-width: 1200px;
            margin: 32px auto;
            padding: 0 20px;
        }

        .catalog-title {
            text-align: center;
            margin-bottom: 36px;
        }

        .catalog-title h2 {
            font-size: 28px;
            color: #2c2c2c;
            margin-bottom: 8px;
            font-weight: 600;
            letter-spacing: -0.5px;
        }

        .catalog-title p {
            font-size: 14px;
            color: #666;
            font-weight: 400;
        }

        /* Сетка карточек */
        .cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 24px;
            margin-bottom: 48px;
            min-height: 400px;
        }

        .loading {
            grid-column: 1 / -1;
            text-align: center;
            padding: 60px 20px;
            font-size: 16px;
            color: #666;
        }

        .loader {
            border: 3px solid #e5e5e5;
            border-top: 3px solid #2c2c2c;
            border-radius: 50%;
            width: 36px;
            height: 36px;
            animation: spin 1s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Карточка автомобиля */
        .car-card {
            background: #fff;
            border-radius: 0;
            overflow: hidden;
            border: 1px solid #e5e5e5;
            transition: all 0.2s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        .car-card:hover {
            border-color: #b0b0b0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }

        .car-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
            background: #e8e8e8;
            display: block;
        }

        .car-body {
            padding: 18px;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .car-title {
            font-size: 16px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 6px;
            letter-spacing: -0.3px;
        }

        .car-title span {
            color: #2c2c2c;
            font-weight: 700;
        }

        .car-year {
            font-size: 12px;
            color: #999;
            margin-bottom: 14px;
            font-weight: 400;
        }

        .car-specs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            margin-bottom: 16px;
            flex-grow: 1;
        }

        .spec {
            font-size: 12px;
            padding: 10px;
            background: #fafafa;
            border-radius: 0;
            border: 1px solid #e5e5e5;
        }

        .spec-label {
            color: #999;
            font-weight: 600;
            font-size: 10px;
            text-transform: uppercase;
            margin-bottom: 4px;
            letter-spacing: 0.3px;
        }

        .spec-value {
            color: #2c2c2c;
            font-weight: 500;
            font-size: 13px;
        }

        .car-price {
            font-size: 20px;
            font-weight: 600;
            color: #2c2c2c;
            padding-top: 12px;
            border-top: 1px solid #e5e5e5;
        }

        .car-price span {
            font-size: 12px;
            font-weight: 400;
            color: #666;
        }

        /* Пагинация */
        .pagination {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 6px;
            margin-top: 48px;
            flex-wrap: wrap;
        }

        .pagination button,
        .pagination a {
            padding: 8px 12px;
            border: 1px solid #d0d0d0;
            background: #fff;
            color: #2c2c2c;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 13px;
            font-weight: 500;
            min-width: 36px;
            text-align: center;
        }

        .pagination button:hover,
        .pagination a:hover {
            background: #f5f5f5;
            border-color: #999;
        }

        .pagination .active {
            background: #2c2c2c;
            color: #fff;
            border-color: #2c2c2c;
        }

        .pagination button:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .error-message {
            text-align: center;
            padding: 40px 20px;
            color: #d32f2f;
            font-size: 14px;
            grid-column: 1 / -1;
        }

        /* Адаптивность */
        @media (max-width: 768px) {
            .cars-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 18px;
            }

            .header-container {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }

            .header-right {
                width: 100%;
                justify-content: center;
            }

            .catalog-title h2 {
                font-size: 22px;
            }
        }
    </style>
</head>
<body>
    <!-- Шапка -->
    <header>
        <div class="header-container">
            <div class="header-left">
                <h1>Auto Dealership</h1>
            </div>
            <div class="header-right">
                <div class="user-info">
                    <i class="fas fa-user-circle"></i>
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name']); ?></span>
                </div>
                <a href="?action=logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Выйти
                </a>
            </div>
        </div>
    </header>

    <!-- Основной контент -->
    <div class="main-container">
        <div class="catalog-title">
            <h2>Каталог автомобилей</h2>
            <p>Выберите интересующий вас автомобиль</p>
        </div>

        <!-- Сетка машин -->
        <div class="cars-grid" id="carsGrid">
            <div class="loading">
                <div class="loader"></div>
                <p>Загрузка каталога...</p>
            </div>
        </div>

        <!-- Пагинация -->
        <div class="pagination" id="pagination"></div>
    </div>

    <script>
        let currentPage = 1;
        const itemsPerPage = 9;

        async function loadCars(page = 1) {
            try {
                const response = await fetch(`../api/cars.php?page=${page}&limit=${itemsPerPage}`);
                const result = await response.json();

                if (!result.success) {
                    throw new Error(result.error || 'Ошибка при загрузке данных');
                }

                displayCars(result.data);
                displayPagination(result.pagination);
                currentPage = page;
                window.scrollTo({ top: 0, behavior: 'smooth' });
            } catch (error) {
                console.error('Ошибка:', error);
                document.getElementById('carsGrid').innerHTML = 
                    `<div class="error-message">Ошибка загрузки каталога: ${error.message}</div>`;
            }
        }

        function displayCars(cars) {
            const grid = document.getElementById('carsGrid');
            
            if (cars.length === 0) {
                grid.innerHTML = '<div class="error-message">Автомобили не найдены</div>';
                return;
            }

            grid.innerHTML = cars.map(car => `
                <div class="car-card">
                    <img src="${car.photo_url || 'https://via.placeholder.com/280x200?text=No+Photo'}" 
                         alt="${car.brand} ${car.model}" class="car-image" onerror="this.src='https://via.placeholder.com/280x200?text=No+Photo'">
                    <div class="car-body">
                        <div class="car-title">
                            <span>${car.brand}</span> ${car.model}
                        </div>
                        <div class="car-year">${car.year} год</div>
                        
                        <div class="car-specs">
                            <div class="spec">
                                <div class="spec-label">Пробег</div>
                                <div class="spec-value">${car.mileage.toLocaleString('ru-RU')} км</div>
                            </div>
                            <div class="spec">
                                <div class="spec-label">КПП</div>
                                <div class="spec-value">${car.gearbox}</div>
                            </div>
                            <div class="spec">
                                <div class="spec-label">Топливо</div>
                                <div class="spec-value">${car.fuel}</div>
                            </div>
                            <div class="spec">
                                <div class="spec-label">Популярность</div>
                                <div class="spec-value">${car.popularity}</div>
                            </div>
                        </div>

                        <div class="car-price">
                            <span>От</span> ${Math.floor(car.price).toLocaleString('ru-RU')} ₸
                        </div>
                    </div>
                </div>
            `).join('');
        }

        function displayPagination(pagination) {
            const paginationDiv = document.getElementById('pagination');
            const { current_page, total_pages } = pagination;

            let html = '';

            // Кнопка "Предыдущая"
            if (current_page > 1) {
                html += `<button onclick="loadCars(${current_page - 1})">← Предыдущая</button>`;
            }

            // Номера страниц
            for (let i = 1; i <= total_pages; i++) {
                if (i === current_page) {
                    html += `<a class="active">${i}</a>`;
                } else if (i === 1 || i === total_pages || 
                           (i >= current_page - 1 && i <= current_page + 1)) {
                    html += `<a onclick="loadCars(${i})">${i}</a>`;
                } else if (i === current_page - 2 || i === current_page + 2) {
                    html += `<span>...</span>`;
                }
            }

            // Кнопка "Следующая"
            if (current_page < total_pages) {
                html += `<button onclick="loadCars(${current_page + 1})">Следующая →</button>`;
            }

            paginationDiv.innerHTML = html;
        }

        // Загружаем машины при загрузке страницы
        loadCars(1);
    </script>
</body>
</html>