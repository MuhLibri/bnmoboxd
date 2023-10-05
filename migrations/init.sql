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
    director VARCHAR(255) NOT NULL,
    description TEXT,
    image_path VARCHAR(50),
    video_path VARCHAR(50),
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
    FOREIGN KEY (film_id) REFERENCES films(id) ON DELETE cascade,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE cascade
);

-- Create 'watch_lists' table
CREATE TABLE IF NOT EXISTS watch_lists (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    user_id INT(11),
    film_id INT(11),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE cascade,
    FOREIGN KEY (film_id) REFERENCES films(id) ON DELETE cascade
);

-- Insert sample data for 'users' table
INSERT INTO users (username, first_name, email, password_hash, profile_picture_path)
VALUES
    ('user1', 'Taylor Swift', 'user1@example.com', '$2y$10$Rj8KgMT1OnRPz.pMH3A/U.3CDqwqgNamF8yFCkYi91FVy7pmXLyZq', 'dummy.jpg'),
    ('user2', 'Ahn Hyo Seop', 'user2@example.com', '$2y$10$Rj8KgMT1OnRPz.pMH3A/U.3CDqwqgNamF8yFCkYi91FVy7pmXLyZq', 'ahn-hyo-seop.jpeg'),
    ('user3', 'Messi', 'user3@example.com', '$2y$10$Rj8KgMT1OnRPz.pMH3A/U.3CDqwqgNamF8yFCkYi91FVy7pmXLyZq', 'messi.jpeg'),
    ('user4', 'Bocchi', 'user4@example.com', '$2y$10$Rj8KgMT1OnRPz.pMH3A/U.3CDqwqgNamF8yFCkYi91FVy7pmXLyZq', 'bocchi.jpg'),
    ('user5', 'Nam Joo Hyuk', 'user5@example.com', '$2y$10$Rj8KgMT1OnRPz.pMH3A/U.3CDqwqgNamF8yFCkYi91FVy7pmXLyZq', 'njh.jpeg');

INSERT INTO users (username, first_name, email, password_hash, profile_picture_path, role)
VALUES
    ('admin', 'Erling Haaland', 'haaland@example.com', '$2y$10$Rj8KgMT1OnRPz.pMH3A/U.3CDqwqgNamF8yFCkYi91FVy7pmXLyZq', 'dummy.jpg', 'admin');

INSERT INTO films (title, release_year, director, description, image_path, genre, video_path)
VALUES
    ('Barbie', 2023, 'Greta Gerwig', 'Barbie suffers a crisis that leads her to question her world and her existence.', 'barbie.jpg', 'Fantasy', 'barbie.mp4');


-- Insert sample data for 'films' table
INSERT INTO films (title, release_year, director, description, image_path, genre)
VALUES
    ('Oppenheimer', 2022, 'Christopher Nolan', 'The story of American scientist, J. Robert Oppenheimer, and his role in the development of the atomic bomb.', 'oppenheimer.jpg', 'Drama'),
    ('Spiderman: Into The Spiderverse', 2021, 'Rodney Rothman, Peter Ramsey, Bob Persichetti', 'Teen Miles Morales becomes the Spider-Man of his universe and must join with five spider-powered individuals from other dimensions to stop a threat for all realities.', 'spiderverse.jpg', 'Action'),
    ('Mission Impossible', 2023, 'Tom Cruise', 'Ethan Hunt and his IMF team must track down a dangerous weapon before it falls into the wrong hands.', 'mission-impossible.jpeg', 'Action'),
    ('Everything Everywhere All At Once', 2022, 'Michelle Yeoh', 'When an interdimensional rupture unravels reality, an unlikely hero must channel her newfound powers to fight bizarre and bewildering dangers from the multiverse as the fate of the world hangs in the balance.', 'Everything Everywhere.jpeg', 'Sci-Fi'),
    ('Infinity War', 2018, 'Russo Brothers', 'The Avengers must stop Thanos, an intergalactic warlord, from getting his hands on all the infinity stones. However, Thanos is prepared to go to any lengths to carry out his insane plan.', 'infinity-war.jpeg', 'Action'),
    ('The Matrix', 1999, 'The Wachowskis', 'A computer programmer discovers that reality as he knows it is a simulation created by machines to subjugate humanity, and he joins a group of rebels to fight back.', 'the-matrix.jpeg', 'Sci-Fi'),
    ('Inception', 2010, 'Christopher Nolan', 'A thief who enters the dreams of others to steal their secrets is hired for a final job: planting an idea in a person''s subconscious.', 'inception.jpeg', 'Sci-Fi'),
    ('Jurassic Park', 1993, 'Steven Spielberg', 'A wealthy entrepreneur creates a theme park with cloned dinosaurs, but things go awry when the dinosaurs escape and wreak havoc.', 'jurassic-park.jpeg', 'Sci-Fi'),
    ('The Shawshank Redemption', 1994, 'Frank Darabont', 'Two imprisoned men bond over a number of years, finding solace and eventual redemption through acts of common decency.', 'shawshank-redemption.jpeg', 'Drama'),
    ('Pulp Fiction', 1994, 'Quentin Tarantino', 'The lives of two mob hitmen, a boxer, a gangster''s wife, and a pair of diner bandits intertwine in four tales of violence and redemption.', 'pulp-function.jpeg', 'Drama'),
    ('The Godfather', 1972, 'Francis Ford Coppola', 'The aging patriarch of an organized crime dynasty transfers control of his clandestine empire to his reluctant son.', 'the-godfather.jpeg', 'Drama'),
    ('The Dark Knight', 2008, 'Christopher Nolan', 'When the Joker wreaks havoc on Gotham City, Batman must confront the chaos and make a painful choice.', 'dark-knight.jpeg', 'Action'),
    ('Forrest Gump', 1994, 'Robert Zemeckis', 'The life journey of a man with low intelligence who inadvertently influences historical events in the United States.', 'forrest-gump.jpeg', 'Drama'),
    ('The Lord of the Rings: The Fellowship of the Ring', 2001, 'Peter Jackson', 'A young hobbit, Frodo Baggins, embarks on a perilous journey to destroy a powerful ring and save Middle-earth from the Dark Lord Sauron.', 'lotr-fellowship.jpeg', 'Fantasy'),
    ('Schindler''s List', 1993, 'Steven Spielberg', 'In German-occupied Poland during World War II, Oskar Schindler gradually becomes concerned for his Jewish workforce after witnessing their persecution by the Nazis.', 'schindlers-list.jpg', 'Drama'),
    ('Star Wars: Episode IV - A New Hope', 1977, 'George Lucas', 'Luke Skywalker joins forces with a Jedi Knight, a cocky pilot, a Wookiee, and two droids to save the galaxy from the Empire''s world-destroying battle station.', 'star-wars-a-new-hope.jpeg', 'Sci-Fi'),
    ('The Great Gatsby', 2013, 'Baz Luhrmann', 'A writer and wall street trader, Nick, finds himself drawn to the past and lifestyle of his millionaire neighbor, Jay Gatsby.', 'great-gatsby.jpg', 'Drama'),
    ('Avatar', 2009, 'James Cameron', 'A paraplegic marine dispatched to the moon Pandora on a unique mission becomes torn between following his orders and protecting the world he feels is his home.', 'avatar.jpg', 'Sci-Fi'),
    ('The Social Network', 2010, 'David Fincher', 'Harvard student Mark Zuckerberg creates the social networking site that would become known as Facebook, but success brings legal and personal complications.', 'social-network.jpg', 'Drama'),
    ('Interstellar', 2014, 'Christopher Nolan', 'A team of explorers travels through a wormhole in space in an attempt to ensure humanity''s survival.', 'interstellar.jpg', 'Sci-Fi'),
    ('Blade Runner', 1982, 'Ridley Scott', 'In a dystopian future, a retired cop hunts down replicants—bioengineered beings virtually identical to humans. He uncovers a dark conspiracy.', 'blade-runner.jpeg', 'Sci-Fi'),
    ('The Shining', 1980, 'Stanley Kubrick', 'A family heads to an isolated hotel for the winter, where an evil and supernatural presence influences the father into violence.', 'the-shining.jpeg', 'Horror'),
    ('Alien', 1979, 'Ridley Scott', 'A commercial spaceship crew discovers a deadly alien creature and must fight for their lives as it hunts them down.', 'alien.jpeg', 'Sci-Fi'),
    ('Eternal Sunshine of the Spotless Mind', 2004, 'Michel Gondry', 'A man undergoes a procedure to erase the memories of his failed relationship but soon realizes he wants to preserve them.', 'eternal-sunshine.jpg', 'Drama'),
    ('Gladiator', 2000, 'Ridley Scott', 'A betrayed Roman general seeks revenge against the corrupt emperor who murdered his family and sent him into slavery.', 'gladiator.jpeg', 'Action'),
    ('The Sixth Sense', 1999, 'M. Night Shyamalan', 'A troubled boy who sees dead people seeks the help of a child psychologist, who is also dealing with personal issues.', 'sixth-sense.jpeg', 'Horror'),
    ('The Revenant', 2015, 'Alejandro González Iñárritu', 'A frontiersman on a fur trading expedition fights for survival after being mauled by a bear and left for dead by members of his own hunting team.', 'revenant.jpeg', 'Action'),
    ('A Beautiful Mind', 2001, 'Ron Howard', 'The life of mathematician John Nash, who overcame schizophrenia to win the Nobel Prize in Economics.', 'beautiful-mind.jpeg', 'Drama'),
    ('The Green Mile', 1999, 'Frank Darabont', 'The lives of guards on Death Row are affected by one of their charges: a black man accused of child murder and rape, yet who has a mysterious gift.', 'green-mile.jpg', 'Drama'),
    ('Barbie', 2023, 'Greta Gerwig', 'Barbie suffers a crisis that leads her to question her world and her existence.', 'barbie.jpg', 'Fantasy'),
    ('Oppenheimer', 2022, 'Christopher Nolan', 'The story of American scientist, J. Robert Oppenheimer, and his role in the development of the atomic bomb.', 'oppenheimer.jpg', 'Drama'),
    ('Spiderman: Into The Spiderverse', 2021, 'Rodney Rothman, Peter Ramsey, Bob Persichetti', 'Teen Miles Morales becomes the Spider-Man of his universe and must join with five spider-powered individuals from other dimensions to stop a threat for all realities.', 'spiderverse.jpg', 'Action'),
    ('Mission Impossible', 2023, 'Tom Cruise', 'Ethan Hunt and his IMF team must track down a dangerous weapon before it falls into the wrong hands.', 'mission-impossible.jpeg', 'Action'),
    ('Everything Everywhere All At Once', 2022, 'Michelle Yeoh', 'When an interdimensional rupture unravels reality, an unlikely hero must channel her newfound powers to fight bizarre and bewildering dangers from the multiverse as the fate of the world hangs in the balance.', 'Everything Everywhere.jpeg', 'Sci-Fi'),
    ('Infinity War', 2018, 'Russo Brothers', 'The Avengers must stop Thanos, an intergalactic warlord, from getting his hands on all the infinity stones. However, Thanos is prepared to go to any lengths to carry out his insane plan.', 'infinity-war.jpeg', 'Action');

-- Insert sample data for 'film_reviews' table
INSERT INTO film_reviews (film_id, user_id, rating, review)
VALUES
    (1, 1, 4, 'Barbie is an absolute delight! The colorful world and heartwarming story make it a must-watch for all ages. I couldn''t stop smiling throughout the entire film.'),
    (1, 2, 3, 'Barbie is a fun family movie. While it may not be groundbreaking, it offers a charming story and great visuals.'),

    -- Reviews for Movie ID 2 (Oppenheimer)
    (2, 1, 5, 'Oppenheimer is a brilliant portrayal of the scientific genius behind the atomic bomb. The film''s attention to detail and historical accuracy are commendable. A must-see for history buffs.'),
    (2, 2, 4, 'As a history enthusiast, I thoroughly enjoyed Oppenheimer. The performances were stellar, and it sheds light on a crucial part of history.'),

    -- Reviews for Movie ID 3 (Spiderman: Into The Spiderverse)
    (3, 3, 5, 'Spiderman: Into The Spiderverse is a masterpiece! The animation is groundbreaking, and the story is heartwarming. I can watch it over and over.'),
    (3, 4, 4, 'Spiderman: Into The Spiderverse is a visually stunning film that brings the multiverse to life. The character development is excellent, and it''s a must-see for Spidey fans.'),

    -- Reviews for Movie ID 4 (Mission Impossible)
    (4, 4, 4, 'Mission Impossible delivers adrenaline-pumping action from start to finish. Tom Cruise is at his best, and the stunts are jaw-dropping.'),
    (4, 5, 3, 'Mission Impossible is an action-packed thrill ride, but the plot can be a bit convoluted at times.'),

    -- Reviews for Movie ID 5 (Everything Everywhere All At Once)
    (5, 1, 5, 'Everything Everywhere All At Once is mind-bending and visually stunning. It''s a unique cinematic experience that will leave you thinking.'),
    (5, 2, 4, 'This movie takes you on a wild ride through multiple dimensions. Michelle Yeoh gives an outstanding performance.'),
    (6, 1, 4, 'Good movie'),
    (7, 2, 3, 'Good movie'),
    (8, 3, 5, 'Good movie'),
    (9, 4, 1, 'Good movie'),
    (10, 5, 4, 'Good movie'),
    (11, 4, 5, 'Good movie'),
    (12, 5, 4, 'Good movie'),
    (13, 1, 1, 'Good movie'),
    (14, 2, 2, 'Good movie'),
    (15, 3, 3, 'Good movie'),
    (16, 4, 4, 'Good movie'),
    (17, 5, 5, 'Good movie'),
    (18, 1, 1, 'Good movie'),
    (19, 2, 2, 'Good movie'),
    (20, 3, 3, 'Good movie');

-- Insert sample data for 'watch_lists' table
INSERT INTO watch_lists (user_id, film_id)
VALUES
    (1, 1),
    (2, 2),
    (3, 3);
