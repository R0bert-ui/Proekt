# Роли пользователей

## Описание системы ролей
Система управления автодилером использует двухуровневую модель управления доступом с двумя основными ролями: администратор и обычный пользователь. Каждый пользователь имеет одну из этих ролей, определяющую его права и возможности в системе.

---

## Таблица ролей

| Роль | Значение в БД | Описание | Доступные функции |
|------|---------------|---------|-------------------|
| **Администратор** | `admin` | Полный доступ к системе | Добавление/редактирование/удаление автомобилей, управление заявками, просмотр логов, управление пользователями |
| **Обычный пользователь** | `user` | Ограниченный доступ | Просмотр каталога автомобилей, подача заявок на машины, просмотр своего профиля |

---

## Хранение ролей

### В базе данных
Роли хранятся в таблице `users` в поле `role`:

```sql
CREATE TABLE `users` (
  ...
  `role` ENUM('admin','user') NOT NULL DEFAULT 'user',
  ...
)
```

### В сессии
При успешном входе роль загружается в сессию:

```php
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_role'] = $user['role'];  // 'admin' или 'user'
```

---

## Права доступа по ролям

### Администратор (`admin`)

✅ **Управление автомобилями:**
- Просмотр всех автомобилей
- Добавление новых автомобилей
- Редактирование информации об автомобилях
- Удаление автомобилей
- Изменение статуса (available, sold, reserved)

✅ **Управление заявками:**
- Просмотр всех заявок
- Изменение статуса заявки (new, pending, approved, rejected)
- Удаление заявок

✅ **Аналитика:**
- Просмотр логов всех действий
- Просмотр статистики по машинам и заявкам

✅ **Управление пользователями:**
- Просмотр списка пользователей
- Возможно: удаление пользователей, смена ролей

### Обычный пользователь (`user`)

✅ **Просмотр:**
- Просмотр каталога автомобилей
- Просмотр деталей конкретного автомобиля
- Просмотр отзывов

✅ **Взаимодействие:**
- Подача заявки на интересующий автомобиль
- Просмотр своих поданных заявок
- Оставление отзывов

❌ **Запрещено:**
- Добавление, редактирование, удаление автомобилей
- Просмотр чужих заявок
- Просмотр логов системы
- Управление пользователями

---

## Проверка роли в коде

### Базовые функции проверки

**Сохраните эти функции в файле `includes/auth.php`:**

```php
<?php
// includes/auth.php

/**
 * Проверяет, авторизован ли пользователь
 * Если нет — редирект на страницу входа
 */
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /index.php');
        exit("Пожалуйста, войдите в систему.");
    }
}

/**
 * Проверяет, имеет ли пользователь определённую роль
 * 
 * @param string $requiredRole Требуемая роль ('admin' или 'user')
 * @param bool $redirect Редирект ли на главную, если нет доступа (по умолчанию true)
 * @return bool true если роль совпадает, false если нет
 */
function requireRole($requiredRole, $redirect = true) {
    if (!isset($_SESSION['user_role'])) {
        if ($redirect) {
            header('Location: /index.php');
        }
        return false;
    }

    if ($_SESSION['user_role'] !== $requiredRole) {
        if ($redirect) {
            header('HTTP/1.0 403 Forbidden');
            exit("У вас нет доступа к этой странице.");
        }
        return false;
    }

    return true;
}

/**
 * Проверяет, может ли пользователь выполнить действие
 * Поддерживает проверку одной или нескольких ролей
 * 
 * @param mixed $allowedRoles Строка ('admin') или массив ['admin', 'user']
 * @param bool $redirect Редирект ли на главную, если нет доступа
 * @return bool true если роль есть в списке разрешённых
 */
function hasRole($allowedRoles, $redirect = true) {
    if (!isset($_SESSION['user_role'])) {
        return false;
    }

    // Преобразуем строку в массив для универсальности
    if (is_string($allowedRoles)) {
        $allowedRoles = [$allowedRoles];
    }

    if (!in_array($_SESSION['user_role'], $allowedRoles)) {
        if ($redirect) {
            http_response_code(403);
        }
        return false;
    }

    return true;
}

/**
 * Получает текущую роль пользователя
 * 
 * @return string|null Роль пользователя ('admin', 'user') или null если не авторизован
 */
function getCurrentRole() {
    return $_SESSION['user_role'] ?? null;
}

/**
 * Проверяет, является ли пользователь администратором
 * 
 * @return bool true если администратор
 */
function isAdmin() {
    return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
}

?>
```

---

## Примеры использования

### Пример 1: Сохранение роли при входе

**Из `index.php` (реальный код проекта):**

```php
<?php
// При успешной проверке пароля сохраняем роль в сессию
$_SESSION['user_id'] = $user['id'];
$_SESSION['user_name'] = $user['name'];
$_SESSION['user_role'] = $user['role'];

// При успешном входе делаем редирект
header('Location: public/home.php');
exit;
?>
```

### Пример 2: Защита администраторской панели

**Из `public/manager.php` (реальный код проекта):**

```php
<?php
session_start();
require_once '../auth/auth_check.php';
require_once '../config/database.php';
require_once '../classes/cars.php';

// Проверка: пользователь авторизован ИЗ файла auth_check.php
// Проверка: только администраторы имеют доступ
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: home.php');
    exit;
}

// Код ниже доступен только администраторам
$car = new Car($pdo);
?>Логирование действий администратора

**Из `public/manager.php` (реальный код проекта):**

```php
<?php
if (isset($_POST['add_car'])) {
    $car->brand = $_POST['brand'];
    $car->model = $_POST['model'];
    $car->year = $_POST['year'];
    $car->price = $_POST['price'];
    $car->mileage = $_POST['mileage'];
    
    if ($car->create()) {
        // Логируем действие администратора
        $log->user_id = $_SESSION['user_id'];
        $log->action = 'add_car';
        $log->details = "Added car: {$car->brand} {$car->model}";
        $log->create();
        
        $success = 'Автомобиль добавлен.';
    }
}
?>
```

**Результат в таблице `роли в `auth_check.php`

**Из `auth/auth_check.php` (реальный код проекта):**

```php
<?php
session_start();

// Проверяем, есть ли user_id в сессии (авторизован ли пользователь)
if (!isset($_SESSION['user_id'])) {
    header('Location: ../index.php');
    exit;
}
// Если пользователь авторизован, код продолжается
?>
```

**Использование в других файлах:**

```php
<?php
session_start();
require_once '../auth/auth_check.php';  // Защита от неавторизованных

// Здесь мы уже знаем что пользователь авторизован
// Дополнительная проверка роли (если нужна)
if ($_SESSION[Использование классов для логирования

**Из `classes/logs.php` (реальный код проекта):**

```php
<?php
// Пример логирования при редактировании автомобиля
$log->user_id = $_SESSION['user_id'];
$log->action = 'edit_car';
$log->details = "Edited car ID: {$car->id}";
$log->create();
?>
```

**Другие типы действий в проекте:**
- `'add_car'` — добавление автомобиля
- `'edit_car'` — редактирование автомобиля
- `'delete_car'` — удаление автомобиля
- `'mark_sold'` — отметить как проданный
- `'update_application'` — изменение статуса заявки exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method Not Allowed']);
    exit;
}

// Остальной код API...
$input = file_get_contents('php://input');
$data = json_decode($input, true);

// Добавляем автомобиль...
?>
```

### Пример 6: Условный вывод меню навигации

```php
<?php
session_start();
require_once 'includes/auth.php';

$isAdmin = isAdmin();
$currentRole = getCurrentRole();
?>

<nav>
    <a href="/">Главная</a>
    <a href="/cars">Каталог</a>
    
    <?php if ($isAdmin): ?>
        <a hreПроверка роли в `public/manager.php`

**Из реального кода проекта:**

```php
<?php
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: home.php');
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
```

**Использование в HTML/форме:**

```php
<?php if (isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin'): ?>
    <form method="POST">
        <input type="text" name="brand" placeholder="Марка" required>
        <input type="text" name="model" placeholder="Модель" required>
        <button type="submit" name="add_car">Добавить автомобиль</button>
    </form>
<?php endif; ?
// Ваш код...
?>
```

### Для администратора
```php
<?php
session_start();
require_once 'includes/auth.php';

requireLogin();      // Сначала проверяем авторизацию
requireRole('admin'); // Затем проверяем роль

// Ваш код...
?>
```

---

## Переменные сессии

После успешного входа доступны следующие переменные:

```php
$_SESSION['user_id']   // INT - ID пользователя в БД
$_SESSION['user_name'] // STRING - Полное имя пользователя
$_SESSION['user_role'] // STRING - Роль ('admin' или 'user')
```

---

## HTTP статусы при проверке доступа

| Статус | Причина | Пример |
|--------|---------|--------|
| 200 | OK — доступ разрешён | Все проверки пройдены |
| 401 | Unauthorized — не авторизован | Нет `user_id` в сессии |
| 403 | Forbidden — недостаточно прав | Роль не совпадает с требуемой |
| 405 | Method Not Allowed — неверный HTTP метод | POST вместо GET |

---

## Рекомендации по безопасности

1. **Всегда проверяйте роль на сервере** — никогда не полагайтесь на клиентские проверки
2. **Используйте requireRole()** вместо явной проверки `$_SESSION['user_role'] === 'admin'`
3. **Логируйте критические действия** — все действия администраторов должны попадать в таблицу `logs`
4. **Регулярно проверяйте логи** — ищите подозрительную активность
5. **Не изменяйте сессию с клиента** — всегда переводите на сервер

---

## Добавление новых ролей (для будущих версий)

Если потребуются новые роли (например, `moderator`), нужно:

1. **Обновить БД:**
```sql
ALTER TABLE users MODIFY role ENUM('admin','user','moderator') NOT NULL DEFAULT 'user';
```

2. **Обновить функции:**
```php
function isModerator() {
    return $_SESSION['user_role'] === 'moderator';
}
```

3. **Использовать в коде:**
```php
if (hasRole(['admin', 'moderator'])) {
    // Действие для администраторов и модераторов
}
```

---

## Тестирование ролей

### Способ 1: Прямая манипуляция сессией (только для разработки!)

```php
<?php
// Временно для тестирования
session_start();
$_SESSION['user_id'] = 1;
$_SESSION['user_name'] = 'Test User';
$_SESSION['user_role'] = 'admin'; // Или 'user'
header('Location: protected_page.php');
?>
```

### Способ 2: Создание тестовых пользователей

```bash
# SQL команда для создания тестовых пользователей
INSERT INTO users (name, email, password, role) VALUES
('Test Admin', 'admin@test.com', '$2y$10$...', 'admin'),
('Test User', 'user@test.com', '$2y$10$...', 'user');
```

---

## Логирование действий по ролям

При выполнении важных действий администратором, логируйте это:

```php
<?php
if (isAdmin()) {
    $stmt = $pdo->prepare(
        "INSERT INTO logs (user_id, action, details, created_at) 
         VALUES (?, ?, ?, NOW())"
    );
    $stmt->execute([
        $_SESSION['user_id'],
        'delete_car',
        "Deleted car ID: " . $car_id
    ]);
}
?>
```

Таблица `logs` будет содержать полную историю действий администраторов.
