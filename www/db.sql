CREATE DATABASE IF NOT EXISTS owasp_demo;
USE owasp_demo;

-- Users table (Vulnerable: No password hashing)
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user'
);

-- Products table
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    owner_id INT NOT NULL
);

-- Add missing 'image' column
ALTER TABLE products ADD COLUMN image VARCHAR(255) DEFAULT NULL;

-- Orders table (Vulnerable: No authentication checks)
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    total_price DECIMAL(10,2) NOT NULL
);

-- Insert sample users
INSERT INTO users (username, email, password, role) VALUES
('admin', 'admin@example.com', 'admin123', 'admin'),
('user1', 'user1@example.com', 'password1', 'user'),
('user2', 'user2@example.com', '123456', 'user'),
('user3', 'user3@example.com', 'qwerty', 'user'),
('user4', 'user4@example.com', 'letmein', 'user');

-- Insert sample products
-- Modify the products table to add quantity
ALTER TABLE products ADD COLUMN quantity INT NOT NULL DEFAULT 0;

-- Update sample products with quantity
INSERT INTO products (name, price, owner_id, image, quantity) VALUES
('Laptop', 1200.00, 1, 'assets/images/laptop.jpg', 10),
('Smartphone', 699.99, 2, 'assets/images/smartphone.jpg', 15),
('Gaming Console', 499.99, 3, 'assets/images/console.jpg', 5),
('Tablet', 299.99, 4, 'assets/images/tablet.jpg', 20),
('Smartwatch', 199.99, 5, 'assets/images/smartwatch.jpg', 30),
('Headphones', 89.99, 1, 'assets/images/headphones.jpg', 25),
('Mechanical Keyboard', 129.99, 2, 'assets/images/keyboard.jpg', 12),
('Mouse', 59.99, 3, 'assets/images/mouse.jpg', 18),
('Monitor', 179.99, 4, 'assets/images/monitor.jpg', 8),
('Printer', 149.99, 5, 'assets/images/printer.jpg', 5);

-- Insert sample orders
INSERT INTO orders (user_id, product_id, quantity, total_price) VALUES
(1, 2, 1, 699.99),
(2, 3, 2, 999.98),
(3, 1, 1, 1200.00),
(4, 5, 3, 599.97),
(5, 7, 1, 129.99),
(1, 9, 2, 359.98),
(2, 4, 1, 299.99),
(3, 6, 4, 359.96),
(4, 8, 1, 59.99),
(5, 10, 1, 149.99);