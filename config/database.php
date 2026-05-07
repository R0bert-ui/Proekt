<?php
try {
    // Данные для подключения (InfinityFree)
    $host = 'sql206.infinityfree.com';   // Хост MySQL
    $db   = 'if0_41834563_car_dealership';       // Имя базы данных
    $user = 'if0_41834563';              // Пользователь БД
    $pass = 'j3MGB3Ai5H3SG2z';               // Пароль

    $dsn = "mysql:host=$host;dbname=$db;charset=utf8mb4";

    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $pdo = new PDO($dsn, $user, $pass, $opt);

} catch (\PDOException $e) {
    die("Ошибка подключения к БД: " . $e->getMessage());
}
?>