DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS films;
DROP TABLE IF EXISTS film_reviews;
DROP TABLE IF EXISTS watch_lists;
-- Create 'users' table
CREATE TABLE IF NOT EXISTS users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL UNIQUE,
    email VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create 'films' table
CREATE TABLE IF NOT EXISTS films (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    release_year INT(11) NOT NULL,
    description TEXT,
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
INSERT INTO users (username, email, password_hash)
VALUES
    ('user1', 'user1@example.com', 'hashed_password_1'),
    ('user2', 'user2@example.com', 'hashed_password_2'),
    ('user3', 'user3@example.com', 'hashed_password_3');

-- Insert sample data for 'films' table
INSERT INTO films (title, release_year, description)
VALUES
    ('Film 1', 2023, 'Description for Film 1'),
    ('Film 2', 2022, 'Description for Film 2'),
    ('Film 3', 2021, 'Description for Film 3');

-- Insert sample data for 'film_reviews' table
INSERT INTO film_reviews (film_id, user_id, rating, review)
VALUES
    (1, 1, 4, 'Review for Film 1 by User 1'),
    (2, 2, 5, 'Review for Film 2 by User 2'),
    (3, 3, 3, 'Review for Film 3 by User 3');

-- Insert sample data for 'watch_lists' table
INSERT INTO watch_lists (user_id, film_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 3);
