<?php
session_start();
require_once '../auth/auth_check.php';

// Если пользователь не авторизован, редирект на index.php
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

$carId = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$carId) {
    header('Location: home.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Детали автомобиля</title>
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

        .header-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .back-btn {
            background: none;
            border: none;
            color: #2c2c2c;
            font-size: 20px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .back-btn:hover {
            color: #0066cc;
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
            background: #e8e8e8;
        }

        /* Основной контент */
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 30px 20px;
        }

        /* Галерея и основная информация */
        .car-detail-hero {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            background: white;
            padding: 25px;
            border-radius: 8px;
            margin-bottom: 30px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .car-image-section {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .main-image {
            width: 100%;
            aspect-ratio: 16/9;
            object-fit: cover;
            border-radius: 6px;
            background: #e8e8e8;
        }

        .info-section h2 {
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 10px;
            color: #2c2c2c;
        }

        .car-title {
            font-size: 28px;
            margin-bottom: 5px;
        }

        .car-year {
            font-size: 14px;
            color: #666;
            margin-bottom: 20px;
        }

        .price-section {
            background: #f0f0f0;
            padding: 20px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .price-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .price-value {
            font-size: 32px;
            font-weight: 700;
            color: #0066cc;
        }

        .specs-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 20px;
        }

        .spec-item {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 6px;
            border-left: 3px solid #0066cc;
        }

        .spec-label {
            font-size: 12px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .spec-value {
            font-size: 16px;
            font-weight: 600;
            color: #2c2c2c;
        }

        .action-buttons {
            display: flex;
            gap: 12px;
            margin-top: 20px;
        }

        .btn-primary {
            flex: 1;
            background: #0066cc;
            color: white;
            border: none;
            padding: 14px 20px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: #0052a3;
        }

        .btn-secondary {
            flex: 1;
            background: #f5f5f5;
            color: #2c2c2c;
            border: 1px solid #d0d0d0;
            padding: 14px 20px;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background: #e8e8e8;
        }

        /* История и сервис */
        .detail-sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 30px;
        }

        .detail-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .detail-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #2c2c2c;
        }

        .detail-section h3 i {
            color: #0066cc;
            font-size: 20px;
        }

        .history-item {
            display: flex;
            gap: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e5e5e5;
        }

        .history-item:last-child {
            border-bottom: none;
            padding-bottom: 0;
        }

        .history-icon {
            flex-shrink: 0;
            width: 36px;
            height: 36px;
            background: #e8f0ff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0066cc;
            font-size: 16px;
        }

        .history-content {
            flex: 1;
        }

        .history-event {
            font-size: 14px;
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 3px;
        }

        .history-date {
            font-size: 12px;
            color: #999;
        }

        .empty-message {
            text-align: center;
            padding: 30px 20px;
            color: #999;
            font-size: 14px;
        }

        /* Отзывы */
        .reviews-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            margin-bottom: 30px;
        }

        .reviews-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #2c2c2c;
        }

        .reviews-section h3 i {
            color: #0066cc;
        }

        .review-item {
            padding: 15px;
            background: #f9f9f9;
            border-radius: 6px;
            margin-bottom: 15px;
        }

        .review-item:last-child {
            margin-bottom: 0;
        }

        .review-header {
            display: flex;
            justify-content: space-between;
            align-items: start;
            margin-bottom: 10px;
        }

        .review-author {
            font-weight: 600;
            color: #2c2c2c;
        }

        .review-date {
            font-size: 12px;
            color: #999;
        }

        .review-text {
            font-size: 13px;
            color: #666;
            line-height: 1.5;
        }

        /* Похожие авто */
        .similar-cars-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
        }

        .similar-cars-section h3 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c2c2c;
        }

        .similar-cars-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .car-card {
            background: #f9f9f9;
            border-radius: 6px;
            overflow: hidden;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;
            border: 1px solid #e5e5e5;
        }

        .car-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .car-card-image {
            width: 100%;
            aspect-ratio: 1/1;
            object-fit: cover;
            background: #e8e8e8;
        }

        .car-card-info {
            padding: 15px;
        }

        .car-card-brand {
            font-weight: 600;
            color: #2c2c2c;
            margin-bottom: 3px;
            font-size: 14px;
        }

        .car-card-model {
            font-size: 12px;
            color: #666;
            margin-bottom: 8px;
        }

        .car-card-price {
            font-size: 14px;
            font-weight: 600;
            color: #0066cc;
        }

        /* Loading state */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
            font-size: 16px;
            color: #666;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 3px solid #e8e8e8;
            border-top: 3px solid #0066cc;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 768px) {
            .car-detail-hero {
                grid-template-columns: 1fr;
                gap: 25px;
                padding: 20px;
            }

            .detail-sections {
                grid-template-columns: 1fr;
                gap: 25px;
            }

            .specs-grid {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 10px;
            }

            .btn-primary,
            .btn-secondary {
                padding: 16px 20px;
                font-size: 15px;
            }

            .header-container {
                flex-wrap: wrap;
                gap: 12px;
            }

            .header-right {
                flex-wrap: wrap;
                gap: 10px;
                width: 100%;
                justify-content: flex-end;
            }

            .info-section h2 {
                font-size: 24px;
                margin-bottom: 12px;
            }

            .price-value {
                font-size: 28px;
            }

            .detail-section {
                padding: 20px;
            }

            .detail-section h3 {
                font-size: 16px;
                margin-bottom: 15px;
            }

            .similar-cars-grid {
                grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
                gap: 15px;
            }

            .review-item {
                padding: 12px;
            }

            .reviews-section {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 12px;
            }

            .car-detail-hero,
            .detail-section,
            .reviews-section,
            .similar-cars-section {
                padding: 16px;
                margin-bottom: 20px;
            }

            .header-left h1 {
                font-size: 18px;
                font-weight: 600;
            }

            .user-name {
                display: none;
            }

            .logout-btn {
                padding: 8px 14px;
                font-size: 12px;
            }

            .back-btn {
                font-size: 16px;
                padding: 10px 12px;
            }

            .info-section h2 {
                font-size: 22px;
                margin-bottom: 8px;
            }

            .car-year {
                margin-bottom: 16px;
                font-size: 13px;
            }

            .price-section {
                padding: 16px;
                margin-bottom: 16px;
            }

            .price-label {
                font-size: 11px;
                margin-bottom: 4px;
            }

            .price-value {
                font-size: 24px;
            }

            .specs-grid {
                grid-template-columns: 1fr;
                gap: 10px;
                margin-bottom: 16px;
            }

            .spec-item {
                padding: 12px;
            }

            .spec-label {
                font-size: 11px;
                margin-bottom: 4px;
            }

            .spec-value {
                font-size: 15px;
            }

            .action-buttons {
                flex-direction: column;
                gap: 10px;
                margin-top: 16px;
            }

            .btn-primary,
            .btn-secondary {
                width: 100%;
                padding: 14px 16px;
                font-size: 14px;
                border-radius: 6px;
            }

            .detail-section h3 {
                font-size: 15px;
                margin-bottom: 12px;
            }

            .history-item {
                gap: 12px;
                padding-bottom: 12px;
            }

            .history-icon {
                width: 32px;
                height: 32px;
                font-size: 14px;
            }

            .history-event {
                font-size: 13px;
            }

            .history-date {
                font-size: 11px;
            }

            .empty-message {
                padding: 20px 15px;
                font-size: 13px;
            }

            .review-item {
                padding: 12px;
                margin-bottom: 12px;
            }

            .review-author {
                font-size: 13px;
            }

            .review-date {
                font-size: 11px;
            }

            .review-text {
                font-size: 12px;
            }

            .reviews-section h3 {
                font-size: 15px;
                margin-bottom: 12px;
            }

            .similar-cars-section h3 {
                font-size: 15px;
                margin-bottom: 12px;
            }

            .similar-cars-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 12px;
            }

            .car-card-brand {
                font-size: 13px;
            }

            .car-card-model {
                font-size: 11px;
            }

            .car-card-price {
                font-size: 13px;
            }
        }

        @media (max-width: 360px) {
            .container {
                padding: 10px;
            }

            .car-detail-hero,
            .detail-section,
            .reviews-section,
            .similar-cars-section {
                padding: 14px;
            }

            .info-section h2 {
                font-size: 20px;
            }

            .price-value {
                font-size: 22px;
            }

            .specs-grid {
                grid-template-columns: 1fr;
            }

            .btn-primary,
            .btn-secondary {
                padding: 12px 14px;
                font-size: 13px;
            }

            .similar-cars-grid {
                grid-template-columns: 1fr;
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
                    <span class="user-name"><?php echo htmlspecialchars($_SESSION['user_name'] ?? 'User'); ?></span>
                </div>
                <a href="home.php?action=logout" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i>
                    Выйти
                </a>
            </div>
        </div>
    </header>

    <!-- Кнопка назад -->
    <div style="background: #f9f9f9; padding: 15px 0;">
        <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
            <button class="back-btn" onclick="window.location.href='home.php'">
                <i class="fas fa-arrow-left"></i> Назад к каталогу
            </button>
        </div>
    </div>

    <!-- Основной контент -->
    <div class="container">
        <div id="loading" class="loading">
            <div class="spinner"></div>
        </div>

        <div id="content" style="display: none;">
            <!-- Секция с фото и основной информацией -->
            <div class="car-detail-hero">
                <div class="car-image-section">
                    <img id="mainImage" class="main-image" alt="Автомобиль">
                </div>

                <div class="info-section">
                    <h2><span id="carBrand"></span> <span id="carModel"></span></h2>
                    <div class="car-year" id="carYear"></div>

                    <div class="price-section">
                        <div class="price-label">Цена</div>
                        <div class="price-value" id="carPrice"></div>
                    </div>

                    <div class="specs-grid">
                        <div class="spec-item">
                            <div class="spec-label">🛢️ Топливо</div>
                            <div class="spec-value" id="carFuel"></div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">⚙️ КПП</div>
                            <div class="spec-value" id="carGearbox"></div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">📊 Пробег</div>
                            <div class="spec-value" id="carMileage"></div>
                        </div>
                        <div class="spec-item">
                            <div class="spec-label">👍 Популярность</div>
                            <div class="spec-value" id="carPopularity"></div>
                        </div>
                    </div>

                    <div class="action-buttons">
                        <button class="btn-primary" onclick="createApplication()">
                            <i class="fas fa-share-alt"></i> Подать заявку
                        </button>
                    </div>
                </div>
            </div>

            <!-- История и технический сервис -->
            <div class="detail-sections">
                <div class="detail-section">
                    <h3><i class="fas fa-history"></i> История автомобиля</h3>
                    <div id="historyContainer"></div>
                </div>

                <div class="detail-section">
                    <h3><i class="fas fa-wrench"></i> Техническое обслуживание</h3>
                    <div id="serviceContainer"></div>
                </div>
            </div>

            <!-- Отзывы -->
            <div class="reviews-section">
                <h3>
                    <i class="fas fa-comments"></i>
                    Заявки интересующихся (<span id="reviewCount">0</span>)
                </h3>
                <div id="reviewsContainer"></div>
            </div>

            <!-- Похожие автомобили -->
            <div class="similar-cars-section">
                <h3>Похожие автомобили</h3>
                <div class="similar-cars-grid" id="similarCarsContainer"></div>
            </div>
        </div>

        <div id="error" style="display: none; background: #fee; border: 1px solid #f99; padding: 20px; border-radius: 6px; color: #c33;">
            Не удалось загрузить данные автомобиля
        </div>
    </div>

    <script>
        const carId = <?php echo $carId; ?>;

        // Форматирование цены
        function formatPrice(price) {
            return new Intl.NumberFormat('ru-RU').format(price) + ' ₸';
        }

        // Форматирование пробега
        function formatMileage(mileage) {
            return new Intl.NumberFormat('ru-RU').format(mileage) + ' км';
        }

        // Дата
        function formatDate(dateString) {
            const options = { year: 'numeric', month: 'long', day: 'numeric' };
            return new Date(dateString).toLocaleDateString('ru-RU', options);
        }

        // Загрузка данных
        async function loadCarDetails() {
            try {
                const response = await fetch(`../api/car-detail.php?id=${carId}`);
                const result = await response.json();

                if (!response.ok || !result.success) {
                    showError();
                    return;
                }

                const { car, history, service, reviews, similar_cars } = result.data;

                // Заполняем основную информацию
                document.getElementById('mainImage').src = car.photo_url;
                document.getElementById('carBrand').textContent = car.brand;
                document.getElementById('carModel').textContent = car.model;
                document.getElementById('carYear').textContent = `${car.year} год выпуска`;
                document.getElementById('carPrice').textContent = formatPrice(car.price);
                document.getElementById('carFuel').textContent = car.fuel || 'Не указано';
                document.getElementById('carGearbox').textContent = car.gearbox || 'Не указано';
                document.getElementById('carMileage').textContent = formatMileage(car.mileage);
                document.getElementById('carPopularity').textContent = car.popularity + ' чел.';

                // История
                if (history.length > 0) {
                    document.getElementById('historyContainer').innerHTML = history
                        .map(item => `
                            <div class="history-item">
                                <div class="history-icon"><i class="fas fa-check-circle"></i></div>
                                <div class="history-content">
                                    <div class="history-event">${item.event}</div>
                                    <div class="history-date">${formatDate(item.date)}</div>
                                </div>
                            </div>
                        `).join('');
                } else {
                    document.getElementById('historyContainer').innerHTML = 
                        '<div class="empty-message">История не доступна</div>';
                }

                // Техническое обслуживание
                if (service.length > 0) {
                    document.getElementById('serviceContainer').innerHTML = service
                        .map(item => `
                            <div class="history-item">
                                <div class="history-icon"><i class="fas fa-tools"></i></div>
                                <div class="history-content">
                                    <div class="history-event">${item.service}</div>
                                    <div class="history-date">${formatDate(item.date)}</div>
                                </div>
                            </div>
                        `).join('');
                } else {
                    document.getElementById('serviceContainer').innerHTML = 
                        '<div class="empty-message">История обслуживания отсутствует</div>';
                }

                // Отзывы
                document.getElementById('reviewCount').textContent = reviews.length;
                if (reviews.length > 0) {
                    document.getElementById('reviewsContainer').innerHTML = reviews
                        .map(review => {
                            let stars = '';
                            if (review.rating) {
                                for (let i = 0; i < review.rating; i++) {
                                    stars += '⭐ ';
                                }
                            }
                            return `
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="review-author">${review.author}</div>
                                        <div class="review-date">${formatDate(review.created_at)}</div>
                                    </div>
                                    ${stars ? `<div style="font-size: 13px; margin-bottom: 8px; color: #f5a623;">${stars}</div>` : ''}
                                    <div class="review-text">${review.comment || 'Нет комментария'}</div>
                                </div>
                            `;
                        }).join('');
                } else {
                    document.getElementById('reviewsContainer').innerHTML = 
                        '<div class="empty-message">Нет отзывов</div>';
                }

                // Похожие машины
                if (similar_cars.length > 0) {
                    document.getElementById('similarCarsContainer').innerHTML = similar_cars
                        .map(similarCar => `
                            <div class="car-card" onclick="goToCar(${similarCar.id})">
                                <img src="${similarCar.photo_url}" class="car-card-image" alt="${similarCar.brand} ${similarCar.model}">
                                <div class="car-card-info">
                                    <div class="car-card-brand">${similarCar.brand}</div>
                                    <div class="car-card-model">${similarCar.model} ${similarCar.year}</div>
                                    <div class="car-card-price">${formatPrice(similarCar.price)}</div>
                                </div>
                            </div>
                        `).join('');
                } else {
                    document.getElementById('similarCarsContainer').innerHTML = 
                        '<div class="empty-message" style="grid-column: 1/-1;">Похожих автомобилей не найдено</div>';
                }

                // Скрываем загрузку, показываем контент
                document.getElementById('loading').style.display = 'none';
                document.getElementById('content').style.display = 'block';
            } catch (error) {
                console.error('Error:', error);
                showError();
            }
        }

        function showError() {
            document.getElementById('loading').style.display = 'none';
            document.getElementById('error').style.display = 'block';
        }

        function goToCar(id) {
            window.location.href = `car-detail.php?id=${id}`;
        }

        function createApplication() {
            alert('Функция подачи заявки будет реализована скоро');
        }

        // Загрузка при загрузке страницы
        document.addEventListener('DOMContentLoaded', loadCarDetails);
    </script>
    <?php include 'footer.php'; ?>
</body>
</html>
