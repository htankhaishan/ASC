CREATE DATABASE IF NOT EXISTS ecommerce;
USE ecommerce;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    description TEXT
);

CREATE TABLE cart (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    product_id INT,
    quantity INT DEFAULT 1,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- 🚀 Insert a default user so cart can reference it
INSERT INTO users (id, username, password, email) VALUES
(1, 'testuser', 'password', 'test@example.com')
ON DUPLICATE KEY UPDATE id = id;

INSERT INTO products (name, price, description) VALUES
('Product A', 10.00, 'This is product A'),
('Product B', 20.00, 'This is product B'),
('Product C', 30.00, 'This is product C'),
('Product X', 1000.00, 'This is product X');