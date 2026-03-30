-- Updates for manager functionality

-- Add status to cars
ALTER TABLE cars ADD COLUMN status VARCHAR(50) DEFAULT 'available';

-- Add role to users (assuming users table exists)
-- If not, create users table
CREATE TABLE IF NOT EXISTS users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150) NOT NULL,
  email VARCHAR(150) UNIQUE NOT NULL,
  password VARCHAR(255) NOT NULL,
  role VARCHAR(50) DEFAULT 'user',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create logs table for logging
CREATE TABLE IF NOT EXISTS logs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT,
  action VARCHAR(255) NOT NULL,
  details TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Update existing cars to have status
UPDATE cars SET status = 'available' WHERE status IS NULL;

-- Add indexes
ALTER TABLE cars ADD INDEX idx_status (status);
ALTER TABLE applications ADD INDEX idx_status (status);