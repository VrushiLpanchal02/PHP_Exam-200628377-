CREATE DATABASE IF NOT EXISTS your_db_name;
USE your_db_name;

CREATE TABLE reviews (
    id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    author VARCHAR(255) NOT NULL,
    rating INT NOT NULL CHECK (rating >=1 AND rating <=5),
    review_text TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
