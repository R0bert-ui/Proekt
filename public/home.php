<?php
require_once '../auth/auth_check.php';
session_start();

// Если пользователь не авторизован, редирект на index.php
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
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
<title>Главная страница</title>
<style>
body {
    font-family: Arial, sans-serif;
    background: #f4f7f6;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100vh;
    margin: 0;
}

.container {
    background: #fff;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    text-align: center;
}

h1 {
    color: #2c3e50;
}

a.logout {
    display: inline-block;
    margin-top: 20px;
    padding: 10px 20px;
    background: #3498db;
    color: #fff;
    text-decoration: none;
    border-radius: 8px;
    transition: 0.3s;
}

a.logout:hover {
    background: #2980b9;
}
</style>
</head>
<body>

<div class="container">
    <h1>Добро пожаловать, <?php echo htmlspecialchars($_SESSION['user_name']); ?>!</h1>
    <p>Вы вошли в личный кабинет.</p>
    <a class="logout" href="?action=logout">Выйти</a>
</div>

</body>
</html>