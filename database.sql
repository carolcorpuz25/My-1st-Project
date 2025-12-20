-- 1. Gumawa ng database
CREATE DATABASE IF NOT EXISTS bakebite_db;

-- 2. Pumili ng database na gagamitan
USE bakebite_db;

-- 3. Gumawa ng table na 'name'
CREATE TABLE IF NOT EXISTS name (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 4. Gumawa ng table na 'email'
CREATE TABLE IF NOT EXISTS email (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email_address VARCHAR(150) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 5. Gumawa ng table na 'message'
CREATE TABLE IF NOT EXISTS message (
    id INT AUTO_INCREMENT PRIMARY KEY,
    message_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
