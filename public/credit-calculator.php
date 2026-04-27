<?php
session_start();
require_once '../auth/auth_check.php';
require_once '../config/database.php';

// Если пользователь не авторизован, редирект на index.php
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}

// Если роль admin, перенаправить на manager.php
if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin') {
    header('Location: manager.php');
    exit;
}

// API для получения автомобилей
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'getCars') {
    header('Content-Type: application/json');
    try {
        $stmt = $pdo->query("SELECT id, brand, model, year, price FROM cars WHERE status = 'available' ORDER BY brand, model");
        $cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $cars]);
    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
    exit;
}

// API для экспорта в Excel
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'exportExcel') {
    header('Content-Type: application/vnd.ms-excel; charset=utf-8');
    header('Content-Disposition: attachment; filename="credit_calculation.xls"');
    
    $carName = htmlspecialchars($_POST['carName']);
    $price = floatval($_POST['price']);
    $downPayment = floatval($_POST['downPayment']);
    $term = intval($_POST['term']);
    $rate = floatval($_POST['rate']);
    
    $monthlyRate = $rate / 100 / 12;
    $loanAmount = $price - $downPayment;
    $monthlyPayment = $loanAmount * ($monthlyRate * pow(1 + $monthlyRate, $term)) / (pow(1 + $monthlyRate, $term) - 1);
    
    echo "Калькулятор кредита - Автосалон\r\n";
    echo "===========================================\r\n\r\n";
    echo "Параметры кредита:\r\n";
    echo "Автомобиль: " . $carName . "\r\n";
    echo "Стоимость авто: " . number_format($price, 2, '.', ' ') . " KZT\r\n";
    echo "Первый взнос: " . number_format($downPayment, 2, '.', ' ') . " KZT\r\n";
    echo "Процент первого взноса: " . number_format(($downPayment / $price) * 100, 2) . "%\r\n";
    echo "Сумма кредита: " . number_format($loanAmount, 2, '.', ' ') . " KZT\r\n";
    echo "Срок кредита: " . $term . " месяцев\r\n";
    echo "Процентная ставка: " . number_format($rate, 2) . "%\r\n";
    echo "Ежемесячный платёж: " . number_format($monthlyPayment, 2, '.', ' ') . " KZT\r\n";
    echo "Общая сумма платежей: " . number_format($monthlyPayment * $term, 2, '.', ' ') . " KZT\r\n";
    echo "Переплата: " . number_format($monthlyPayment * $term - $loanAmount, 2, '.', ' ') . " KZT\r\n\r\n";
    
    echo "Таблица амортизации:\r\n";
    echo "Месяц\tОстаток\tПроцент\tОсновная сумма\tПлатёж\r\n";
    
    $balance = $loanAmount;
    for ($i = 1; $i <= $term; $i++) {
        $interest = $balance * $monthlyRate;
        $principal = $monthlyPayment - $interest;
        $balance -= $principal;
        
        echo $i . "\t" . number_format(max(0, $balance), 2, '.', ' ') . "\t" . 
             number_format($interest, 2, '.', ' ') . "\t" . 
             number_format($principal, 2, '.', ' ') . "\t" . 
             number_format($monthlyPayment, 2, '.', ' ') . "\r\n";
    }
    
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Калькулятор кредита</title>
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

        .calculator-wrapper {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-bottom: 48px;
        }

        /* Форма */
        .calculator-form {
            background: #fff;
            padding: 32px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .calculator-form h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 24px;
            color: #2c2c2c;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            font-size: 14px;
            color: #2c2c2c;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 1px solid #d0d0d0;
            border-radius: 4px;
            font-size: 14px;
            font-family: inherit;
            transition: border 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #0066cc;
            box-shadow: 0 0 0 3px rgba(0, 102, 204, 0.1);
        }

        .slider-group {
            margin-bottom: 20px;
        }

        .slider-group label {
            display: block;
            margin-bottom: 12px;
            font-weight: 600;
            font-size: 14px;
            color: #2c2c2c;
        }

        .slider-container {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .slider-container input[type="range"] {
            flex: 1;
            height: 6px;
            border-radius: 3px;
            background: #e5e5e5;
            outline: none;
            -webkit-appearance: none;
        }

        .slider-container input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #0066cc;
            cursor: pointer;
            transition: background 0.2s;
        }

        .slider-container input[type="range"]::-moz-range-thumb {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            background: #0066cc;
            cursor: pointer;
            border: none;
            transition: background 0.2s;
        }

        .slider-container input[type="range"]:hover::-webkit-slider-thumb {
            background: #0052a3;
        }

        .slider-value {
            min-width: 60px;
            text-align: right;
            font-weight: 600;
            color: #0066cc;
        }

        .button-group {
            display: flex;
            gap: 12px;
            margin-top: 24px;
        }

        .btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary {
            background: #0066cc;
            color: white;
        }

        .btn-primary:hover {
            background: #0052a3;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0, 102, 204, 0.3);
        }

        .btn-secondary {
            background: #f5f5f5;
            color: #2c2c2c;
            border: 1px solid #d0d0d0;
        }

        .btn-secondary:hover {
            background: #e8e8e8;
            border-color: #b0b0b0;
        }

        /* Результаты */
        .calculator-results {
            background: #fff;
            padding: 32px;
            border-radius: 8px;
            border: 1px solid #e5e5e5;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            max-height: 600px;
            overflow-y: auto;
        }

        .calculator-results h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 24px;
            color: #2c2c2c;
        }

        .results-hidden {
            display: none;
        }

        .result-summary {
            background: #f9f9f9;
            padding: 20px;
            border-radius: 4px;
            margin-bottom: 24px;
            border-left: 4px solid #0066cc;
        }

        .result-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e5e5e5;
            font-size: 14px;
        }

        .result-row:last-child {
            border-bottom: none;
        }

        .result-label {
            color: #666;
            font-weight: 500;
        }

        .result-value {
            font-weight: 600;
            color: #2c2c2c;
        }

        .result-value.highlight {
            color: #0066cc;
            font-size: 18px;
        }

        .comparison-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .comparison-card {
            background: #f9f9f9;
            padding: 16px;
            border-radius: 4px;
            border: 2px solid #e5e5e5;
            text-align: center;
            transition: all 0.2s;
        }

        .comparison-card.active {
            background: #e8f4ff;
            border-color: #0066cc;
        }

        .comparison-card h4 {
            font-size: 13px;
            color: #666;
            margin-bottom: 8px;
            font-weight: 600;
        }

        .comparison-card .payment {
            font-size: 18px;
            font-weight: 700;
            color: #2c2c2c;
            margin-bottom: 4px;
        }

        .comparison-card .overpayment {
            font-size: 12px;
            color: #999;
        }

        .amortization-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
            margin-top: 20px;
        }

        .amortization-table thead {
            background: #f5f5f5;
            border-bottom: 2px solid #e5e5e5;
        }

        .amortization-table th {
            padding: 10px 8px;
            text-align: left;
            font-weight: 600;
            color: #2c2c2c;
        }

        .amortization-table td {
            padding: 8px;
            border-bottom: 1px solid #e5e5e5;
        }

        .amortization-table tbody tr:hover {
            background: #f9f9f9;
        }

        .export-btn {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        /* Адаптивность */
        @media (max-width: 1024px) {
            .calculator-wrapper {
                grid-template-columns: 1fr;
            }

            .comparison-cards {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .main-container {
                margin: 20px auto;
            }

            .calculator-form,
            .calculator-results {
                padding: 24px;
            }

            .calculator-form h2,
            .calculator-results h2 {
                font-size: 20px;
            }

            .header-container {
                flex-wrap: wrap;
                gap: 12px;
            }

            .header-right {
                flex: 1;
                justify-content: center;
            }
        }

        .validation-error {
            color: #d32f2f;
            font-size: 12px;
            margin-top: 4px;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <!-- Шапка -->
    <header>
        <div class="header-container">
            <div class="header-left">
                <button class="back-btn" onclick="window.location.href='home.php'">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <h1>Калькулятор кредита</h1>
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
        <div class="calculator-wrapper">
            <!-- Форма калькулятора -->
            <div class="calculator-form">
                <h2>Параметры кредита</h2>

                <div class="form-group">
                    <label for="carSelect">Выберите автомобиль</label>
                    <select id="carSelect" onchange="updateCarPrice()">
                        <option value="">-- Загрузка --</option>
                    </select>
                    <div class="validation-error hidden" id="carError">Пожалуйста, выберите автомобиль</div>
                </div>

                <div class="form-group">
                    <label>Стоимость авто: <span id="priceDisplay">0</span> KZT</label>
                    <input type="number" id="price" readonly value="0" min="0">
                </div>

                <div class="form-group">
                    <label for="downPayment">Первый взнос (KZT)</label>
                    <input type="number" id="downPayment" placeholder="0" min="0" max="100000000" onchange="validateDownPayment(); calculate()">
                    <div class="validation-error hidden" id="downPaymentError">Первый взнос должен быть от 10% до 99% от стоимости</div>
                </div>

                <div class="slider-group">
                    <label for="downPaymentPercent">Процент первого взноса (%)</label>
                    <div class="slider-container">
                        <input type="range" id="downPaymentPercent" min="10" max="99" value="20" oninput="updateDownPaymentFromPercent()">
                        <span class="slider-value"><span id="downPaymentPercentValue">20</span>%</span>
                    </div>
                </div>

                <div class="slider-group">
                    <label for="term">Срок кредита (<span id="termValue">36</span> месяцев)</label>
                    <div class="slider-container">
                        <input type="range" id="term" min="12" max="60" value="36" step="1" oninput="updateTermValue(); calculate()">
                        <span class="slider-value"><span id="termDisplay">36</span> мес.</span>
                    </div>
                </div>

                <div class="slider-group">
                    <label for="rate">Процентная ставка (<span id="rateValue">12.5</span>% в год)</label>
                    <div class="slider-container">
                        <input type="range" id="rate" min="5" max="25" value="12.5" step="0.1" oninput="updateRateValue(); calculate()">
                        <span class="slider-value"><span id="rateDisplay">12.5</span>%</span>
                    </div>
                </div>

                <div class="button-group">
                    <button class="btn btn-primary" onclick="calculate()">
                        <i class="fas fa-calculator"></i>
                        Рассчитать
                    </button>
                    <button class="btn btn-secondary" onclick="resetCalculator()">
                        <i class="fas fa-redo"></i>
                        Сбросить
                    </button>
                </div>
            </div>

            <!-- Результаты -->
            <div class="calculator-results results-hidden" id="resultsSection">
                <h2>Результаты</h2>

                <div class="result-summary">
                    <div class="result-row">
                        <span class="result-label">Автомобиль:</span>
                        <span class="result-value" id="resultCar">-</span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">Сумма кредита:</span>
                        <span class="result-value" id="resultLoanAmount">-</span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">Ежемесячный платёж:</span>
                        <span class="result-value highlight" id="resultMonthlyPayment">-</span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">Общая сумма платежей:</span>
                        <span class="result-value" id="resultTotalPayment">-</span>
                    </div>
                    <div class="result-row">
                        <span class="result-label">Переплата (проценты):</span>
                        <span class="result-value" id="resultOverpayment">-</span>
                    </div>
                </div>

                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px; margin-top: 24px;">Сравнение вариантов</h3>
                <div class="comparison-cards">
                    <div class="comparison-card" data-term="24">
                        <h4>24 месяца</h4>
                        <div class="payment" id="payment24">-</div>
                        <div class="overpayment" id="overpay24">-</div>
                    </div>
                    <div class="comparison-card" data-term="36">
                        <h4>36 месяцев</h4>
                        <div class="payment" id="payment36">-</div>
                        <div class="overpayment" id="overpay36">-</div>
                    </div>
                    <div class="comparison-card" data-term="48">
                        <h4>48 месяцев</h4>
                        <div class="payment" id="payment48">-</div>
                        <div class="overpayment" id="overpay48">-</div>
                    </div>
                </div>

                <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 16px; margin-top: 24px;">График платежей</h3>
                <table class="amortization-table">
                    <thead>
                        <tr>
                            <th>Месяц</th>
                            <th>Остаток</th>
                            <th>Проценты</th>
                            <th>Основная сумма</th>
                        </tr>
                    </thead>
                    <tbody id="amortizationTable">
                        <tr><td colspan="4" style="text-align: center; color: #999;">-</td></tr>
                    </tbody>
                </table>

                <button class="btn btn-primary" style="width: 100%; margin-top: 20px;" onclick="exportToExcel()">
                    <i class="fas fa-file-excel"></i>
                    <span class="export-btn">Экспортировать в Excel</span>
                </button>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        let currentCars = [];

        // Загрузка списка автомобилей
        function loadCars() {
            fetch('credit-calculator.php?action=getCars')
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        currentCars = data.data;
                        const select = document.getElementById('carSelect');
                        select.innerHTML = '<option value="">-- Выберите автомобиль --</option>';
                        
                        data.data.forEach(car => {
                            const option = document.createElement('option');
                            option.value = car.id;
                            option.textContent = `${car.brand} ${car.model} (${car.year}) - ${Number(car.price).toLocaleString()} KZT`;
                            option.dataset.price = car.price;
                            select.appendChild(option);
                        });
                    }
                })
                .catch(err => console.error('Ошибка загрузки:', err));
        }

        // Обновление цены автомобиля
        function updateCarPrice() {
            const select = document.getElementById('carSelect');
            const option = select.options[select.selectedIndex];
            const price = option.dataset.price || 0;
            
            document.getElementById('price').value = price;
            document.getElementById('priceDisplay').textContent = Number(price).toLocaleString();
            
            updateDownPaymentFromPercent();
            document.getElementById('carError').classList.add('hidden');
        }

        // Обновление первого взноса из процента
        function updateDownPaymentFromPercent() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const percent = parseFloat(document.getElementById('downPaymentPercent').value) || 0;
            const downPayment = Math.round(price * percent / 100);
            
            document.getElementById('downPayment').value = downPayment;
            document.getElementById('downPaymentPercentValue').textContent = percent;
            
            calculate();
        }

        // Валидация первого взноса
        function validateDownPayment() {
            const price = parseFloat(document.getElementById('price').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const percent = (downPayment / price) * 100;
            
            if (percent >= 10 && percent <= 99) {
                document.getElementById('downPaymentPercent').value = Math.round(percent);
                document.getElementById('downPaymentPercentValue').textContent = Math.round(percent);
                document.getElementById('downPaymentError').classList.add('hidden');
                return true;
            } else {
                document.getElementById('downPaymentError').classList.remove('hidden');
                return false;
            }
        }

        // Обновление значения срока
        function updateTermValue() {
            const term = document.getElementById('term').value;
            document.getElementById('termValue').textContent = term;
            document.getElementById('termDisplay').textContent = term;
        }

        // Обновление значения ставки
        function updateRateValue() {
            const rate = document.getElementById('rate').value;
            document.getElementById('rateValue').textContent = rate;
            document.getElementById('rateDisplay').textContent = rate;
        }

        // Функция расчёта
        function calculate() {
            // Валидация
            if (!document.getElementById('carSelect').value) {
                document.getElementById('carError').classList.remove('hidden');
                return;
            }

            if (!validateDownPayment()) {
                return;
            }

            const price = parseFloat(document.getElementById('price').value) || 0;
            const downPayment = parseFloat(document.getElementById('downPayment').value) || 0;
            const term = parseInt(document.getElementById('term').value) || 36;
            const rate = parseFloat(document.getElementById('rate').value) || 12.5;
            const carSelect = document.getElementById('carSelect');
            const carName = carSelect.options[carSelect.selectedIndex].text;

            if (price <= 0 || downPayment <= 0) {
                alert('Заполните все параметры');
                return;
            }

            // Расчёты
            const loanAmount = price - downPayment;
            const monthlyRate = rate / 100 / 12;
            const monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, term)) / 
                                  (Math.pow(1 + monthlyRate, term) - 1);
            const totalPayment = monthlyPayment * term;
            const overpayment = totalPayment - loanAmount;

            // Отображение результатов
            document.getElementById('resultCar').textContent = carName;
            document.getElementById('resultLoanAmount').textContent = Number(loanAmount.toFixed(2)).toLocaleString() + ' KZT';
            document.getElementById('resultMonthlyPayment').textContent = Number(monthlyPayment.toFixed(2)).toLocaleString() + ' KZT';
            document.getElementById('resultTotalPayment').textContent = Number(totalPayment.toFixed(2)).toLocaleString() + ' KZT';
            document.getElementById('resultOverpayment').textContent = Number(overpayment.toFixed(2)).toLocaleString() + ' KZT';

            // Сравнение вариантов
            compareTerms(loanAmount, rate, downPayment);

            // График амортизации
            generateAmortizationTable(loanAmount, monthlyRate, monthlyPayment, term);

            // Показываем результаты
            document.getElementById('resultsSection').classList.remove('results-hidden');
        }

        // Сравнение вариантов
        function compareTerms(loanAmount, rate, downPayment) {
            const terms = [24, 36, 48];
            const monthlyRate = rate / 100 / 12;

            terms.forEach(term => {
                const monthlyPayment = loanAmount * (monthlyRate * Math.pow(1 + monthlyRate, term)) / 
                                      (Math.pow(1 + monthlyRate, term) - 1);
                const overpayment = (monthlyPayment * term) - loanAmount;

                document.getElementById(`payment${term}`).textContent = 
                    Number(monthlyPayment.toFixed(2)).toLocaleString() + ' KZT';
                document.getElementById(`overpay${term}`).textContent = 
                    'Переплата: ' + Number(overpayment.toFixed(2)).toLocaleString() + ' KZT';

                // Выделяем текущий срок
                const card = document.querySelector(`[data-term="${term}"]`);
                const currentTerm = parseInt(document.getElementById('term').value);
                if (term === currentTerm) {
                    card.classList.add('active');
                } else {
                    card.classList.remove('active');
                }
            });
        }

        // Таблица амортизации
        function generateAmortizationTable(loanAmount, monthlyRate, monthlyPayment, term) {
            const tbody = document.getElementById('amortizationTable');
            tbody.innerHTML = '';

            let balance = loanAmount;
            for (let i = 1; i <= term; i++) {
                const interest = balance * monthlyRate;
                const principal = monthlyPayment - interest;
                balance = Math.max(0, balance - principal);

                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${i}</td>
                    <td>${Number(balance.toFixed(2)).toLocaleString()}</td>
                    <td>${Number(interest.toFixed(2)).toLocaleString()}</td>
                    <td>${Number(principal.toFixed(2)).toLocaleString()}</td>
                `;
                tbody.appendChild(row);
            }
        }

        // Экспорт в Excel
        function exportToExcel() {
            const formData = new FormData();
            const carSelect = document.getElementById('carSelect');
            const carName = carSelect.options[carSelect.selectedIndex].text;

            formData.append('action', 'exportExcel');
            formData.append('carName', carName);
            formData.append('price', document.getElementById('price').value);
            formData.append('downPayment', document.getElementById('downPayment').value);
            formData.append('term', document.getElementById('term').value);
            formData.append('rate', document.getElementById('rate').value);

            fetch('credit-calculator.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.blob())
            .then(blob => {
                const url = window.URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'credit_calculation.xls';
                document.body.appendChild(a);
                a.click();
                window.URL.revokeObjectURL(url);
                document.body.removeChild(a);
            });
        }

        // Сброс калькулятора
        function resetCalculator() {
            document.getElementById('carSelect').value = '';
            document.getElementById('price').value = '0';
            document.getElementById('priceDisplay').textContent = '0';
            document.getElementById('downPayment').value = '';
            document.getElementById('downPaymentPercent').value = '20';
            document.getElementById('downPaymentPercentValue').textContent = '20';
            document.getElementById('term').value = '36';
            document.getElementById('termValue').textContent = '36';
            document.getElementById('termDisplay').textContent = '36';
            document.getElementById('rate').value = '12.5';
            document.getElementById('rateValue').textContent = '12.5';
            document.getElementById('rateDisplay').textContent = '12.5';
            document.getElementById('resultsSection').classList.add('results-hidden');
            document.getElementById('carError').classList.add('hidden');
            document.getElementById('downPaymentError').classList.add('hidden');
        }

        // Инициализация при загрузке страницы
        document.addEventListener('DOMContentLoaded', loadCars);
    </script>
</body>
</html>
