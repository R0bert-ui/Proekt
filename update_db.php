<?php
require_once 'config/database.php';

try {
    // Check if status column exists in cars
    $stmt = $pdo->query("SHOW COLUMNS FROM cars LIKE 'status'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("ALTER TABLE cars ADD COLUMN status VARCHAR(50) DEFAULT 'available'");
        echo "Added status column to cars.\n";
    } else {
        echo "Status column already exists in cars.\n";
    }

    // Check if logs table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'logs'");
    if ($stmt->rowCount() == 0) {
        $pdo->exec("CREATE TABLE logs (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT,
            action VARCHAR(255) NOT NULL,
            details TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )");
        echo "Created logs table.\n";
    } else {
        echo "Logs table already exists.\n";
    }

    // Update existing cars
    $pdo->exec("UPDATE cars SET status = 'available' WHERE status IS NULL OR status = ''");
    echo "Updated existing cars status.\n";

    echo "Database check/update completed!";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>