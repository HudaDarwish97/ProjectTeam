CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    profile_picture VARCHAR(255) DEFAULT 'default.png',
    password_hash VARCHAR(255) NOT NULL
    ALTER TABLE users ADD COLUMN password_hash VARCHAR(255) NOT NULL;
ALTER TABLE users ADD COLUMN profile_image VARCHAR(255) DEFAULT 'uploads/default.png';
);