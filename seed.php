<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/database.php';
$faker = Faker\Factory::create('ru_RU');
echo "🚀 Запуск сидера...\n";
echo "👤 Создаем пользователей...\n";
$userIds = [];
for ($i = 0; $i < 10; $i++) {

    $name  = $faker->name;
    $email = $faker->unique()->safeEmail;
    $password = password_hash('123456', PASSWORD_BCRYPT);

    $stmt = $pdo->prepare(
        "INSERT INTO users (name, email, password, created_at)
         VALUES (?, ?, ?, NOW())"
    );

    $stmt->execute([$name, $email, $password]);

    $userIds[] = $pdo->lastInsertId();
}
// Add admin
$stmt = $pdo->prepare(
    "INSERT INTO users (name, email, password, role, created_at)
     VALUES (?, ?, ?, 'admin', NOW())"
);
$stmt->execute(['Admin', 'admin@example.com', password_hash('admin123', PASSWORD_BCRYPT)]);
echo "✔ Пользователи созданы\n";
echo "🚗 Создаем автомобили...\n";
$brands = ['Toyota', 'BMW', 'Mercedes-Benz', 'Audi', 'Kia', 'Hyundai', 'Lexus', 'Volkswagen', 'Ford', 'Honda', 
           'Mazda', 'Nissan', 'Volvo', 'Subaru', 'Porsche', 'Tesla', 'Chevrolet', 'Jeep', 'Range Rover', 'Jaguar'];

$models = ['Camry', 'X5', 'E-Class', 'A6', 'Sportage', 'Elantra', 'RX', 'Passat', 'Focus', 'Civic',
           'CX-5', 'Qashqai', 'XC60', 'Outback', '911', 'Model 3', 'Cruze', 'Wrangler', 'Discovery', 'XF'];

$carIds = [];
for ($i = 0; $i < 120; $i++) {

    $brand = $brands[array_rand($brands)];
    $model = $models[array_rand($models)];
    $year  = rand(2015, 2026);
    $price = rand(2000000, 80000000);
    $mileage = rand(5000, 250000);
    $gearbox = ['Автомат', 'Механика'][rand(0,1)];
    $fuel = ['Бензин', 'Дизель', 'Гибрид'][rand(0,2)];
    $popularity = rand(10, 100);
    $photo = "https://picsum.photos/seed/" . rand(1,5000) . "/600/400";

    $stmt = $pdo->prepare(
        "INSERT INTO cars
        (brand, model, year, price, mileage, gearbox, fuel, popularity, photo_url, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'available', NOW())"
    );

    $stmt->execute([
        $brand,
        $model,
        $year,
        $price,
        $mileage,
        $gearbox,
        $fuel,
        $popularity,
        $photo
    ]);

    $carIds[] = $pdo->lastInsertId();
}

echo "✔ Автомобили созданы\n";
echo "📦 Создаем заявки...\n";

for ($i = 0; $i < 50; $i++) {

    $carId = $carIds[array_rand($carIds)];
    $userId = $userIds[array_rand($userIds)];

    $fullName = $faker->name;
    $phone    = $faker->phoneNumber;
    $email    = $faker->safeEmail;
    $comment  = $faker->sentence(8);
    $status   = 'new';

    $stmt = $pdo->prepare(
        "INSERT INTO applications
        (car_id, user_id, full_name, phone, email, comment, status, created_at)
        VALUES (?, ?, ?, ?, ?, ?, ?, NOW())"
    );

    $stmt->execute([
        $carId,
        $userId,
        $fullName,
        $phone,
        $email,
        $comment,
        $status
    ]);
}

echo "✔ Заявки созданы\n";
echo "⭐ Создаем отзывы...\n";

for ($i = 0; $i < 50; $i++) {

    $carId  = $carIds[array_rand($carIds)];
    $author = $faker->name;
    $rating = rand(3, 5);
    $comment = $faker->paragraph;

    $stmt = $pdo->prepare(
        "INSERT INTO car_reviews
        (car_id, author, rating, comment, created_at)
        VALUES (?, ?, ?, ?, NOW())"
    );

    $stmt->execute([
        $carId,
        $author,
        $rating,
        $comment
    ]);
}
echo "✔ Отзывы созданы\n";
echo "📜 Создаем историю авто...\n";
$events = ['Registered', 'Changed owner', 'Accident repair', 'Inspection passed'];
foreach ($carIds as $carId) {

    for ($i = 0; $i < 3; $i++) {

        $event = $events[array_rand($events)];
        $date = $faker->date();

        $stmt = $pdo->prepare(
            "INSERT INTO car_history (car_id, event, date)
             VALUES (?, ?, ?)"
        );

        $stmt->execute([$carId, $event, $date]);
    }
}
echo "✔ История создана\n";
echo "🔧 Создаем сервисные записи...\n";
$services = ['Oil change', 'Brake replacement', 'Engine diagnostics', 'Tire change'];
foreach ($carIds as $carId) {

    for ($i = 0; $i < 2; $i++) {

        $service = $services[array_rand($services)];
        $date = $faker->date();

        $stmt = $pdo->prepare(
            "INSERT INTO car_service (car_id, service, date)
             VALUES (?, ?, ?)"
        );

        $stmt->execute([$carId, $service, $date]);
    }
}

echo "✔ Сервисные записи созданы\n";

echo "\n🎉 Сидирование завершено успешно!\n";