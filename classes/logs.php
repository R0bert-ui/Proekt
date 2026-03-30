<?php
class Log {
    private $conn;
    private $table = 'logs';
    public $id;
    public $user_id;
    public $action;
    public $details;
    public $created_at;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $sql = 'INSERT INTO ' . $this->table . ' (user_id, action, details) VALUES (:user_id, :action, :details)';
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':action', $this->action);
        $stmt->bindParam(':details', $this->details);
        return $stmt->execute();
    }
}