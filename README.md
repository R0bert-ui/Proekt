Система управления автодилером

Описание
Веб-приложение для управления автоcалоном, позволяющее просматривать каталог автомобилей, управлять объявлениями об автомобилях и отслеживать историю обслуживания.
Технологии
PHP 7.4+
MySQL / MariaDB
HTML, CSS, Bootstrap
Apache (OpenServer)
Composer
PDO
Dotenv (vlucas/phpdotenv)

Установка и запуск
Требования
OpenServer (или XAMPP / Денвер)
PHP 7.4+
MySQL 5.7+

Шаги установки
Клонируйте репозиторий:
git clone https://github.com/R0bert-ui/Proekt.git
Скопируйте папку проекта в OpenServer/domains/
Запустите OpenServer
Создайте базу данных в phpMyAdmin:
CREATE DATABASE `car_dealership` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
Импортируйте структуру БД из файла db/car_dealership (4).sql
Создайте файл .env в корне проекта:
DB_HOST=localhostDB_NAME=car_dealershipDB_USER=rootDB_PASS=
Установите зависимости (опционально):
composer install
Откройте браузер: http://localhost/Proekt/
Роли пользователей
Роль	Возможности
admin	Полный доступ: управление автомобилями, заявками, пользователями, просмотр логов
user	Ограниченный доступ: просмотр каталога, подача заявок, управление своим профилем

API
Документация REST API находится в файле API_DOCUMENTATION.md в корне проекта.
Основные endpoints:
GET /api/read.php — получение списка автомобилей
POST /api/create.php — создание автомобиля (требует admin)
PUT /api/update.php — обновление автомобиля (требует admin)
DELETE /api/delete.php — удаление автомобиля (требует admin)

Структура проекта
project/
├── config/                 # Конфигурация БД
├── classes/                # Классы (Car, User, Application, Log)
├── auth/                   # Аутентификация и авторизация
├── api/                    # REST API endpoints
├── public/                 # Публичные страницы
├── db/                     # Структура и данные БД
├── uploads/                # Загруженные файлы
├── vendor/                 # Зависимости Composer
├── index.php               # Главная страница (вход/регистрация)
├── composer.json           # Зависимости проекта
└── .env                    # Переменные окружения
