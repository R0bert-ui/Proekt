<?php
session_start();
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$email || !$password) {
        die("Введите email и пароль.");
    }
    // Получаем пользователя по email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        die("Пользователь не найден.");
    }
    // Проверяем пароль
    if (!password_verify($password, $user['password'])) {
        die("Неверный пароль.");
    }
    // Сохраняем данные в сессии
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    $_SESSION['user_role'] = $user['role'];

    echo "Вход успешен! Добро пожаловать, " . htmlspecialchars($user['name']) . ".";
}
?>