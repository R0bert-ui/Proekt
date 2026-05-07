<?php
class Car {
    private $conn;
    private $table = 'cars';
    public $id;
    public $brand;
    public $model;
    public $year;
    public $price;
    public $mileage;
    public $gearbox;
    public $fuel;
    public $popularity;
    public $status;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        $sql = 'INSERT INTO ' . $this->table
            . ' (brand, model, year, price, mileage, gearbox, fuel, popularity, photo_url, status)'
            . ' VALUES (:brand, :model, :year, :price, :mileage, :gearbox, :fuel, :popularity, :photo_url, :status)';
        $stmt = $this->conn->prepare($sql);
        $this->brand = htmlspecialchars(strip_tags($this->brand));
        $this->model = htmlspecialchars(strip_tags($this->model));
        $stmt->bindParam(':brand', $this->brand);
        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':mileage', $this->mileage);
        $stmt->bindParam(':gearbox', $this->gearbox);
        $stmt->bindParam(':fuel', $this->fuel);
        $stmt->bindParam(':popularity', $this->popularity);
        $stmt->bindParam(':photo_url', $this->photo_url);
        $stmt->bindParam(':status', $this->status);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    public function getAll() {
        $sql = 'SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    public function getById($id) {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $this->id = $row['id'];
            $this->brand = $row['brand'];
            $this->model = $row['model'];
            $this->year = $row['year'];
            $this->price = $row['price'];
            $this->mileage = $row['mileage'];
            $this->gearbox = $row['gearbox'];
            $this->fuel = $row['fuel'];
            $this->popularity = $row['popularity'];
            $this->photo_url = $row['photo_url'];
            $this->status = $row['status'];
            $this->created_at = $row['created_at'];
            return true;
        }
        return false;
    }
    public function update() {
        $sql = 'UPDATE ' . $this->table . ' SET
            brand = :brand,
            model = :model,
            year = :year,
            price = :price,
            mileage = :mileage,
            gearbox = :gearbox,
            fuel = :fuel,
            popularity = :popularity,
            photo_url = :photo_url,
            status = :status
            WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':brand', $this->brand);
        $stmt->bindParam(':model', $this->model);
        $stmt->bindParam(':year', $this->year);
        $stmt->bindParam(':price', $this->price);
        $stmt->bindParam(':mileage', $this->mileage);
        $stmt->bindParam(':gearbox', $this->gearbox);
        $stmt->bindParam(':fuel', $this->fuel);
        $stmt->bindParam(':popularity', $this->popularity);
        $stmt->bindParam(':photo_url', $this->photo_url);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
    public function delete($id) {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function markSold($id) {
        if ($this->columnExists('sold_at')) {
            $sql = 'UPDATE ' . $this->table . ' SET status = \'sold\', sold_at = NOW() WHERE id = :id';
        } else {
            $sql = 'UPDATE ' . $this->table . ' SET status = \'sold\' WHERE id = :id';
        }
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function getAvailable() {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE status != \'sold\' ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt;
    }
    public function getCount() {
        $sql = 'SELECT COUNT(*) as count FROM ' . $this->table;
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'];
    }
    public function columnExists($column) {
        $stmt = $this->conn->prepare('SHOW COLUMNS FROM ' . $this->table . ' LIKE :column');
        $stmt->bindParam(':column', $column);
        $stmt->execute();
        return (bool) $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getMonthlySoldCount() {
        $dateField = $this->columnExists('sold_at') ? 'COALESCE(sold_at, created_at)' : 'created_at';
        $sql = 'SELECT COUNT(*) as count FROM ' . $this->table . ' WHERE status = \'sold\' AND MONTH(' . $dateField . ') = MONTH(CURRENT_DATE) AND YEAR(' . $dateField . ') = YEAR(CURRENT_DATE)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return (int) $row['count'];
    }
    public function getMonthlyRevenue() {
        $dateField = $this->columnExists('sold_at') ? 'COALESCE(sold_at, created_at)' : 'created_at';
        $sql = 'SELECT SUM(price) as revenue FROM ' . $this->table . ' WHERE status = \'sold\' AND MONTH(' . $dateField . ') = MONTH(CURRENT_DATE) AND YEAR(' . $dateField . ') = YEAR(CURRENT_DATE)';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['revenue'] !== null ? (float) $row['revenue'] : 0;
    }

    public function searchWithFilters($filters = []) {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE status != \'sold\'';
        $params = [];
        
        // Поиск по марке и модели
        if (!empty($filters['search'])) {
            $search = '%' . $filters['search'] . '%';
            $sql .= ' AND (brand LIKE :search OR model LIKE :search)';
            $params['search'] = $search;
        }
        
        // Фильтр по марке
        if (!empty($filters['brand'])) {
            $sql .= ' AND brand = :brand';
            $params['brand'] = $filters['brand'];
        }
        
        // Фильтр по модели
        if (!empty($filters['model'])) {
            $sql .= ' AND model = :model';
            $params['model'] = $filters['model'];
        }
        
        // Фильтр по цене
        if (!empty($filters['price_min'])) {
            $sql .= ' AND price >= :price_min';
            $params['price_min'] = (float)$filters['price_min'];
        }
        if (!empty($filters['price_max'])) {
            $sql .= ' AND price <= :price_max';
            $params['price_max'] = (float)$filters['price_max'];
        }
        
        // Фильтр по году
        if (!empty($filters['year_min'])) {
            $sql .= ' AND year >= :year_min';
            $params['year_min'] = (int)$filters['year_min'];
        }
        if (!empty($filters['year_max'])) {
            $sql .= ' AND year <= :year_max';
            $params['year_max'] = (int)$filters['year_max'];
        }
        
        // Фильтр по пробегу
        if (!empty($filters['mileage_max'])) {
            $sql .= ' AND mileage <= :mileage_max';
            $params['mileage_max'] = (int)$filters['mileage_max'];
        }
        
        // Фильтр по КПП
        if (!empty($filters['gearbox'])) {
            $sql .= ' AND gearbox = :gearbox';
            $params['gearbox'] = $filters['gearbox'];
        }
        
        // Фильтр по топливу
        if (!empty($filters['fuel'])) {
            $sql .= ' AND fuel = :fuel';
            $params['fuel'] = $filters['fuel'];
        }
        
        // Сортировка
        if (!empty($filters['sort'])) {
            switch($filters['sort']) {
                case 'price_asc':
                    $sql .= ' ORDER BY price ASC';
                    break;
                case 'price_desc':
                    $sql .= ' ORDER BY price DESC';
                    break;
                case 'year_asc':
                    $sql .= ' ORDER BY year ASC';
                    break;
                case 'year_desc':
                    $sql .= ' ORDER BY year DESC';
                    break;
                case 'mileage_asc':
                    $sql .= ' ORDER BY mileage ASC';
                    break;
                case 'popularity_desc':
                    $sql .= ' ORDER BY popularity DESC';
                    break;
                default:
                    $sql .= ' ORDER BY created_at DESC';
            }
        } else {
            $sql .= ' ORDER BY created_at DESC';
        }
        
        $stmt = $this->conn->prepare($sql);
        // Правильно передаем параметры - без : в ключах
        foreach ($params as $key => $value) {
            $stmt->bindValue(':' . $key, $value);
        }
        $stmt->execute();
        return $stmt;
    }

    public function getBrands() {
        $sql = 'SELECT DISTINCT brand FROM ' . $this->table . ' WHERE status != \'sold\' ORDER BY brand ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getGearboxes() {
        $sql = 'SELECT DISTINCT gearbox FROM ' . $this->table . ' WHERE status != \'sold\' ORDER BY gearbox ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getFuels() {
        $sql = 'SELECT DISTINCT fuel FROM ' . $this->table . ' WHERE status != \'sold\' ORDER BY fuel ASC';
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function validateCarData() {
        $errors = [];

        // Валидация марки
        if (empty($this->brand) || trim($this->brand) === '') {
            $errors[] = 'Марка обязательна';
        } elseif (strlen($this->brand) < 2 || strlen($this->brand) > 100) {
            $errors[] = 'Марка должна быть от 2 до 100 символов';
        }

        // Валидация модели
        if (empty($this->model) || trim($this->model) === '') {
            $errors[] = 'Модель обязательна';
        } elseif (strlen($this->model) < 2 || strlen($this->model) > 100) {
            $errors[] = 'Модель должна быть от 2 до 100 символов';
        }

        // Валидация года
        $year = (int)$this->year;
        if (!is_numeric($this->year) || $year < 1900 || $year > date('Y') + 1) {
            $errors[] = 'Год должен быть от 1900 до ' . (date('Y') + 1);
        }

        // Валидация цены
        $price = floatval($this->price);
        if (!is_numeric($this->price) || $price <= 0) {
            $errors[] = 'Цена должна быть больше 0';
        }

        // Валидация пробега
        $mileage = (int)$this->mileage;
        if (!is_numeric($this->mileage) || $mileage < 0) {
            $errors[] = 'Пробег не может быть отрицательным';
        }

        // Валидация КПП
        if (empty($this->gearbox) || trim($this->gearbox) === '') {
            $errors[] = 'КПП обязательна';
        }

        // Валидация топлива
        if (empty($this->fuel) || trim($this->fuel) === '') {
            $errors[] = 'Тип топлива обязателен';
        }

        // Валидация популярности
        $popularity = (int)$this->popularity;
        if (!is_numeric($this->popularity) || $popularity < 0) {
            $errors[] = 'Популярность не может быть отрицательной';
        }

        return $errors;
    }
}
