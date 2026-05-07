<?php
class Application {
    private $conn;
    private $table = 'applications';
    public $id;
    public $car_id;
    public $user_id;
    public $full_name;
    public $phone;
    public $email;
    public $comment;
    public $status;
    public $created_at;
    public function __construct($db) {
        $this->conn = $db;
    }
    public function create() {
        $fields = ['car_id', 'full_name', 'phone', 'email', 'comment', 'status'];
        $params = [':car_id', ':full_name', ':phone', ':email', ':comment', ':status'];

        if (!empty($this->user_id)) {
            array_splice($fields, 1, 0, 'user_id');
            array_splice($params, 1, 0, ':user_id');
        }

        $sql = 'INSERT INTO ' . $this->table
            . ' (' . implode(', ', $fields) . ') VALUES (' . implode(', ', $params) . ')';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':car_id', $this->car_id);

        if (!empty($this->user_id)) {
            $stmt->bindParam(':user_id', $this->user_id);
        }

        $stmt->bindParam(':full_name', $this->full_name);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':comment', $this->comment);
        $stmt->bindParam(':status', $this->status);
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        }
        return false;
    }
    public function getAll() {
        $stmt = $this->conn->prepare('SELECT * FROM ' . $this->table . ' ORDER BY created_at DESC');
        $stmt->execute();
        return $stmt;
    }
    public function delete($id) {
        $stmt = $this->conn->prepare('DELETE FROM ' . $this->table . ' WHERE id = :id');
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function update() {
        $sql = 'UPDATE ' . $this->table . ' SET status = :status WHERE id = :id';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':status', $this->status);
        $stmt->bindParam(':id', $this->id);
        return $stmt->execute();
    }
}
