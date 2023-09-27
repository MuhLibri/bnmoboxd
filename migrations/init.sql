DROP TABLE IF EXISTS watch_lists;
DROP TABLE IF EXISTS film_reviews;
DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS films;
-- Create 'users' table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50),
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    role ENUM('admin', 'user') NOT NULL DEFAULT 'user',
    profile_picture_path VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create 'films' table
CREATE TABLE IF NOT EXISTS films (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    release_year INT(11) NOT NULL,
    description TEXT,
    image_path VARCHAR(50),
    genre ENUM('Action', 'Comedy', 'Drama', 'Sci-Fi', 'Horror', 'Fantasy', 'Other') NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create 'film_reviews' table
CREATE TABLE IF NOT EXISTS film_reviews (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    film_id INT(11) NOT NULL,
    user_id INT(11) NOT NULL,
    rating INT(11) NOT NULL,
    review TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (film_id) REFERENCES films(id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);

-- Create 'watch_lists' table
CREATE TABLE IF NOT EXISTS watch_lists (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    film_id INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (film_id) REFERENCES films(id)
);

-- Insert sample data for 'users' table
INSERT INTO users (username, first_name, email, password_hash, profile_picture_path)
VALUES
    ('user1', 'Taylor Swift', 'user1@example.com', '$2y$10$Rj8KgMT1OnRPz.pMH3A/U.3CDqwqgNamF8yFCkYi91FVy7pmXLyZq', 'dummy.jpg'),
    ('user2', 'Ahn Hyo Seop', 'user2@example.com', '$2y$10$Rj8KgMT1OnRPz.pMH3A/U.3CDqwqgNamF8yFCkYi91FVy7pmXLyZq', 'ahn-hyo-seop.jpeg'),
    ('user3', 'user3', 'user3@example.com', '$2y$10$Rj8KgMT1OnRPz.pMH3A/U.3CDqwqgNamF8yFCkYi91FVy7pmXLyZq', 'dummy.jpg');

-- Insert sample data for 'films' table
INSERT INTO films (title, release_year, description, image_path)
VALUES
    ('Barbie', 2023, 'Barbie suffers a crisis that leads her to question her world and her existence.', 'barbie.jpg'),
    ('Oppenheimer', 2022, 'The story of American scientist, J. Robert Oppenheimer, and his role in the development of the atomic bomb.', 'oppenheimer.jpg'),
    ('Spiderman: Into The Spiderverse', 2021, 'Teen Miles Morales becomes the Spider-Man of his universe and must join with five spider-powered individuals from other dimensions to stop a threat for all realities.', 'spiderverse.jpg');

-- Insert sample data for 'film_reviews' table
INSERT INTO film_reviews (film_id, user_id, rating, review)
VALUES
    (1, 1, 4, 'Barbie is an absolute delight! The colorful world and heartwarming story make it a must-watch for all ages. I couldn''t stop smiling throughout the entire film.'),
    (2, 2, 5, '"Oppenheimer is a brilliant portrayal of the scientific genius behind the atomic bomb. The film''s attention to detail and historical accuracy are commendable. A must-see for history buffs.'),
    (3, 3, 3, 'Spiderman swings back into action with a thrilling and action-packed adventure! The web-swinging scenes are breathtaking, and Tom Holland''s portrayal of Peter Parker is spot-on.');

-- Insert sample data for 'watch_lists' table
INSERT INTO watch_lists (user_id, film_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 3);
