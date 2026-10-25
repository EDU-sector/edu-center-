CREATE DATABASE IF NOT EXISTS edutricity CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE edutricity;

CREATE TABLE IF NOT EXISTS locations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS institutions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    city_id INT NOT NULL,
    category_id INT NOT NULL,
    ownership ENUM('Private', 'Government', 'Public', 'Semi-Government') NOT NULL,
    description TEXT,
    fee_range VARCHAR(100),
    website VARCHAR(255) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (city_id) REFERENCES locations(id),
    FOREIGN KEY (category_id) REFERENCES categories(id)
);

CREATE TABLE IF NOT EXISTS suggestions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    institution_name VARCHAR(255) NOT NULL,
    location VARCHAR(150) NOT NULL,
    details TEXT,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO locations (city, state) VALUES
('Chandigarh', 'Punjab'),
('Mohali', 'Punjab'),
('Panchkula', 'Haryana');

INSERT INTO categories (name) VALUES
('School'),
('College'),
('University'),
('Coaching'),
('Skill Development');

INSERT INTO institutions (name, city_id, category_id, ownership, description, fee_range, website) VALUES
('Chandigarh University', 1, 3, 'Private', 'Strong engineering, management, and innovation-focused academic offerings.', '₹1.2L - ₹2.5L / year', 'https://www.cuchd.in'),
('Government College for Girls', 1, 2, 'Government', 'Affordable higher education with strong academic support and public-sector access.', '₹10K - ₹35K / year', 'https://example.edu'),
('Apeejay School', 2, 1, 'Private', 'Academic focus with co-curricular learning and leadership development.', '₹70K - ₹1.5L / year', 'https://example.edu'),
('Target Coaching Centre', 3, 4, 'Private', 'Entrance-focused coaching and mentoring for JEE and NEET aspirants.', '₹30K - ₹80K / year', 'https://example.edu'),
('New Era Skills Academy', 2, 5, 'Private', 'Career-oriented digital and analytical training programmes.', '₹25K - ₹90K / course', 'https://example.edu');
