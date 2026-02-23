<?php
require_once 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$name || !$email || !$password) {
        die("Все поля обязательны для заполнения.");
    }
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->fetch()) {
        die("Пользователь с таким email уже существует.");
    }
    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $email, $passwordHash])) {
        echo "Регистрация успешна! <a href='index.php'>Войти</a>";
    } else {
        echo "Ошибка при регистрации.";
    }
}
?>