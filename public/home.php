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

        /* Слайдер */
        .slider-section {
            position: relative;
            width: 100%;
            height: 560px;
            border-radius: 0;
            overflow: hidden;
            margin-bottom: 40px;
        }

        .slider-container {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .slider-item {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-start;
            opacity: 0;
            transition: opacity 0.5s ease;
        }

        .slider-item.active {
            opacity: 1;
        }

        .slider-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.25) 0%, rgba(0, 0, 0, 0.12) 50%, rgba(0, 0, 0, 0) 100%);
            z-index: 1;
        }

        .slider-item img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .slider-click-zones {
            position: absolute;
            width: 100%;
            height: 100%;
            display: flex;
            z-index: 1;
        }

        .slider-zone {
            flex: 1;
            cursor: pointer;
            transition: background-color 0.2s ease;
        }

        .slider-zone-left {
            background: transparent;
        }

        .slider-zone-right {
            background: transparent;
        }

        .slider-content {
            position: relative;
            z-index: 2;
            width: auto;
            color: white;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            height: 100%;
            margin-right: 40px;
            margin-left: 60px;
        }

        .slider-info {
            background: rgba(0, 0, 0, 0.35);
            backdrop-filter: blur(15px);
            padding: 28px 32px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.15);
            width: 320px;
            height: 340px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
            display: flex;
            flex-direction: column;
        }

        .slider-content h2 {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 6px;
            opacity: 1;
            text-shadow: none;
            align-self: auto;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .slider-content .slider-model {
            font-size: 20px;
            opacity: 0.9;
            margin-bottom: 28px;
            font-weight: 300;
            text-shadow: none;
            align-self: auto;
            color: rgba(255, 255, 255, 0.9);
        }

        .slider-content .slider-specs {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
            align-self: auto;
            flex-grow: 1;
        }

        .slider-spec {
            background: transparent;
            padding: 0;
            border-radius: 0;
            backdrop-filter: none;
            border: none;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding-bottom: 10px;
        }

        .slider-spec-label {
            font-size: 12px;
            text-transform: uppercase;
            opacity: 0.7;
            margin-bottom: 6px;
            letter-spacing: 0.8px;
            font-weight: 600;
        }

        .slider-spec-value {
            font-size: 17px;
            font-weight: 600;
            opacity: 1;
        }

        .slider-price {
            font-size: 36px;
            font-weight: 700;
            margin-bottom: 20px;
            opacity: 1;
            text-shadow: none;
            align-self: auto;
        }

        .slider-btn {
            background: linear-gradient(135deg, #ffffff 0%, #f5f5f5 100%);
            color: #2c2c2c;
            border: none;
            padding: 14px 40px;
            border-radius: 6px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            box-shadow: 0 6px 20px rgba(255, 255, 255, 0.15);
            align-self: auto;
            width: fit-content;
        }

        .slider-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            background: #f5f5f5;
        }

        .slider-controls {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 10;
        }

        .slider-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.4);
            cursor: pointer;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .slider-dot:hover {
            background: rgba(255, 255, 255, 0.6);
        }

        .slider-dot.active {
            background: white;
            width: 24px;
            border-radius: 5px;
        }

        .slider-nav {
            display: none;
        }

        .slider-prev {
            display: none;
        }

        .slider-next {
            display: none;
        }

        /* Адаптивность слайдера */
        @media (max-width: 768px) {
            .slider-section {
                height: 360px;
                margin-bottom: 30px;
            }

            .slider-content {
                margin-right: 0;
                margin-left: 20px;
            }

            .slider-info {
                padding: 24px 20px;
                width: 280px;
                height: 320px;
                background: rgba(0, 0, 0, 0.35);
            }

            .slider-content h2 {
                font-size: 27px;
                margin-bottom: 4px;
            }

            .slider-content .slider-model {
                font-size: 15px;
                margin-bottom: 20px;
            }

            .slider-content .slider-specs {
                grid-template-columns: 1fr 1fr;
                gap: 14px;
                margin-bottom: 12px;
                flex-grow: 1;
            }

            .slider-spec {
                padding-bottom: 8px;
            }

            .slider-spec-label {
                font-size: 11px;
                margin-bottom: 5px;
            }

            .slider-spec-value {
                font-size: 15px;
            }

            .slider-price {
                font-size: 28px;
                margin-bottom: 20px;
            }

            .slider-btn {
                padding: 11px 24px;
                font-size: 13px;
            }

            .slider-controls {
                left: 50%;
                transform: translateX(-50%);
                bottom: 20px;
                z-index: 10;
            }

            .slider-nav {
                width: 40px;
                height: 40px;
                font-size: 16px;
                z-index: 11;
            }

            .slider-prev {
                left: 16px;
            }

            .slider-next {
                right: 16px;
            }
        }

        @media (max-width: 480px) {
            .slider-section {
                height: 380px;
                margin-bottom: 24px;
            }

            .slider-content {
                margin-right: 0;
                margin-left: 16px;
            }

            .slider-info {
                padding: 20px 16px;
                background: rgba(0, 0, 0, 0.35);
                width: 240px;
                height: 300px;
            }

            .slider-content h2 {
                font-size: 22px;
                margin-bottom: 3px;
            }

            .slider-content .slider-model {
                font-size: 13px;
                margin-bottom: 14px;
            }

            .slider-content .slider-specs {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
                margin-bottom: 10px;
                flex-grow: 1;
            }

            .slider-spec {
                padding-bottom: 8px;
            }

            .slider-spec-label {
                font-size: 10px;
                margin-bottom: 4px;
            }

            .slider-spec-value {
                font-size: 13px;
            }

            .slider-price {
                font-size: 22px;
                margin-bottom: 12px;
            }

            .slider-btn {
                padding: 11px 24px;
                font-size: 13px;
            }

            .slider-nav {
                display: none;
            }

            .slider-prev {
                display: none;
            }

            .slider-next {
                display: none;
            }

            .slider-controls {
                left: 50%;
                transform: translateX(-50%);
                bottom: 20px;
                gap: 8px;
                z-index: 10;
            }
        }

        @media (max-width: 360px) {
            .slider-section {
                height: 320px;
            }

            .slider-content {
                margin-right: 0;
                margin-left: 12px;
            }

            .slider-info {
                padding: 16px 12px;
                background: rgba(0, 0, 0, 0.35);
                width: 200px;
                height: 280px;
            }

            .slider-content h2 {
                font-size: 18px;
                margin-bottom: 3px;
            }

            .slider-content .slider-model {
                font-size: 11px;
                margin-bottom: 12px;
            }

            .slider-content .slider-specs {
                gap: 10px;
                margin-bottom: 10px;
                flex-grow: 1;
            }
            }

            .slider-spec {
                padding-bottom: 6px;
            }

            .slider-spec-label {
                font-size: 8px;
                margin-bottom: 3px;
            }

            .slider-spec-value {
                font-size: 11px;
            }

            .slider-price {
                font-size: 18px;
                margin-bottom: 10px;
            }

            .slider-btn {
                padding: 10px 20px;
                font-size: 12px;
            }
        }

        /* Адаптивность каталога */
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
        <!-- Слайдер -->
        <div class="slider-section">
            <div class="slider-container" id="sliderContainer">
                <!-- Слайды будут добавлены через JavaScript -->
            </div>
            <button class="slider-nav slider-prev" onclick="prevSlide()">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="slider-nav slider-next" onclick="nextSlide()">
                <i class="fas fa-chevron-right"></i>
            </button>
            <div class="slider-controls" id="sliderDots"></div>
        </div>

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
                <a href="car-detail.php?id=${car.id}" style="text-decoration: none; color: inherit;">
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
                </a>
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

        // Слайдер управление
        let sliderData = [];
        let currentSlideIndex = 0;

        // Функция для выбора случайных элементов из массива
        function getRandomItems(arr, count) {
            const shuffled = [...arr].sort(() => Math.random() - 0.5);
            return shuffled.slice(0, Math.min(count, arr.length));
        }

        async function initSlider() {
            try {
                const response = await fetch(`../api/cars.php?page=1&limit=100`);
                const result = await response.json();
                
                if (result.success && result.data.length > 0) {
                    sliderData = getRandomItems(result.data, 5);
                    renderSlider();
                    autoSlide();
                }
            } catch (error) {
                console.error('Ошибка загрузки слайдера:', error);
            }
        }

        function renderSlider() {
            const container = document.getElementById('sliderContainer');
            const dotsContainer = document.getElementById('sliderDots');
            
            container.innerHTML = sliderData.map((car, idx) => `
                <div class="slider-item ${idx === 0 ? 'active' : ''}">
                    <img src="${car.photo_url}" alt="${car.brand} ${car.model}">
                    <div class="slider-click-zones">
                        <div class="slider-zone slider-zone-left" onclick="prevSlide()"></div>
                        <div class="slider-zone slider-zone-right" onclick="nextSlide()"></div>
                    </div>
                    <div class="slider-content">
                        <div class="slider-info">
                            <h2>${car.brand}</h2>
                            <div class="slider-model">${car.model}</div>
                            <div class="slider-specs">
                                <div class="slider-spec">
                                    <div class="slider-spec-label">Год</div>
                                    <div class="slider-spec-value">${car.year}</div>
                                </div>
                                <div class="slider-spec">
                                    <div class="slider-spec-label">Пробег</div>
                                    <div class="slider-spec-value">${(car.mileage / 1000).toFixed(0)}к км</div>
                                </div>
                                <div class="slider-spec">
                                    <div class="slider-spec-label">Топливо</div>
                                    <div class="slider-spec-value">${car.fuel}</div>
                                </div>
                                <div class="slider-spec">
                                    <div class="slider-spec-label">КПП</div>
                                    <div class="slider-spec-value">${car.gearbox}</div>
                                </div>
                            </div>
                            <div class="slider-price">${Math.floor(car.price).toLocaleString('ru-RU')} ₸</div>
                            <a href="car-detail.php?id=${car.id}" class="slider-btn">Подробнее</a>
                        </div>
                    </div>
                </div>
            `).join('');

            dotsContainer.innerHTML = sliderData.map((_, idx) => `
                <div class="slider-dot ${idx === 0 ? 'active' : ''}" onclick="goToSlide(${idx})"></div>
            `).join('');
        }

        function nextSlide() {
            currentSlideIndex = (currentSlideIndex + 1) % sliderData.length;
            updateSlider();
        }

        function prevSlide() {
            currentSlideIndex = (currentSlideIndex - 1 + sliderData.length) % sliderData.length;
            updateSlider();
        }

        function goToSlide(idx) {
            currentSlideIndex = idx;
            updateSlider();
        }

        function updateSlider() {
            const items = document.querySelectorAll('.slider-item');
            const dots = document.querySelectorAll('.slider-dot');

            items.forEach((item, idx) => {
                item.classList.remove('active');
                if (idx === currentSlideIndex) {
                    item.classList.add('active');
                }
            });

            dots.forEach((dot, idx) => {
                dot.classList.remove('active');
                if (idx === currentSlideIndex) {
                    dot.classList.add('active');
                }
            });
        }

        let autoSlideTimer;
        function autoSlide() {
            clearInterval(autoSlideTimer);
            autoSlideTimer = setInterval(() => {
                nextSlide();
            }, 5000);
        }

        // Функционал свайпа/перетягивания мышкой
        let touchStartX = 0;
        let touchEndX = 0;

        function handleSwipe() {
            if (touchEndX < touchStartX - 50) {
                nextSlide();
                autoSlide();
            }
            if (touchEndX > touchStartX + 50) {
                prevSlide();
                autoSlide();
            }
        }

        // Инициализиируем слайдер при загрузке страницы
        document.addEventListener('DOMContentLoaded', () => {
            initSlider();
            
            const sliderContainer = document.getElementById('sliderContainer');
            
            // Свайп для мобильных (touch)
            sliderContainer.addEventListener('touchstart', (e) => {
                touchStartX = e.changedTouches[0].screenX;
            }, false);
            
            sliderContainer.addEventListener('touchend', (e) => {
                touchEndX = e.changedTouches[0].screenX;
                handleSwipe();
            }, false);
            
            // Перетягивание мышкой для десктопа
            let isMouseDown = false;
            sliderContainer.addEventListener('mousedown', (e) => {
                isMouseDown = true;
                touchStartX = e.clientX;
            });
            
            sliderContainer.addEventListener('mouseup', (e) => {
                if (isMouseDown) {
                    touchEndX = e.clientX;
                    handleSwipe();
                    isMouseDown = false;
                }
            });
            
            sliderContainer.addEventListener('mouseleave', () => {
                isMouseDown = false;
            });
        });

        // Перезагружаем таймер при взаимодействии с крошками
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('slider-dot')) {
                autoSlide();
            }
        });
    </script>
</body>
</html>