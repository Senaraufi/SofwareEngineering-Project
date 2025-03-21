-- Users table is for every users profile: Both admins and Users of the site will be stored here
CREATE TABLE IF NOT EXISTS Users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    phone_number VARCHAR(20),
    bio TEXT,
    profile_image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_admin BOOLEAN DEFAULT 0
);

-- Genres table
CREATE TABLE IF NOT EXISTS Genres (
    genre_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Artists table
CREATE TABLE IF NOT EXISTS Artists (
    artist_id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT,
    FOREIGN KEY (updated_by) REFERENCES Users(user_id)
);

-- Artist Genres (many-to-many relationship)
CREATE TABLE IF NOT EXISTS ArtistGenres (
    artist_id INT,
    genre_id INT,
    PRIMARY KEY (artist_id, genre_id),
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id),
    FOREIGN KEY (genre_id) REFERENCES Genres(genre_id)
);

-- Albums table
CREATE TABLE IF NOT EXISTS Albums (
    album_id INT AUTO_INCREMENT PRIMARY KEY,
    artist_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    release_date DATE,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT,
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id),
    FOREIGN KEY (updated_by) REFERENCES Users(user_id)
);

-- Album Genres (many-to-many relationship)
CREATE TABLE IF NOT EXISTS AlbumGenres (
    album_id INT,
    genre_id INT,
    PRIMARY KEY (album_id, genre_id),
    FOREIGN KEY (album_id) REFERENCES Albums(album_id),
    FOREIGN KEY (genre_id) REFERENCES Genres(genre_id)
);

-- Concerts table (ALSO could use it to redirect to ticketmaster with upcoming gig)
CREATE TABLE IF NOT EXISTS Concerts (
    concert_id INT AUTO_INCREMENT PRIMARY KEY,
    artist_id INT NOT NULL,
    name VARCHAR(100) NOT NULL,
    venue_name VARCHAR(100) NOT NULL,
    venue_location VARCHAR(255),
    concert_date DATE NOT NULL,
    concert_time TIME NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    updated_by INT,
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id),
    FOREIGN KEY (updated_by) REFERENCES Users(user_id)
);

-- Reviews table
CREATE TABLE IF NOT EXISTS Reviews (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    album_id INT,
    concert_id INT,
    rating DECIMAL(2,1) CHECK (rating >= 0 AND rating <= 5),
    title VARCHAR(100),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (album_id) REFERENCES Albums(album_id),
    FOREIGN KEY (concert_id) REFERENCES Concerts(concert_id),
    CHECK ((album_id IS NULL AND concert_id IS NOT NULL) OR (album_id IS NOT NULL AND concert_id IS NULL))
);

-- Comments on reviews
CREATE TABLE IF NOT EXISTS Comments (
    comment_id INT AUTO_INCREMENT PRIMARY KEY,
    review_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (review_id) REFERENCES Reviews(review_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- User Lists (like Letterboxd lists)
CREATE TABLE IF NOT EXISTS Lists (
    list_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    is_public BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- List Items
CREATE TABLE IF NOT EXISTS ListItems (
    list_id INT,
    album_id INT,
    position INT NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (list_id, album_id),
    FOREIGN KEY (list_id) REFERENCES Lists(list_id),
    FOREIGN KEY (album_id) REFERENCES Albums(album_id)
);

-- User Following
CREATE TABLE IF NOT EXISTS UserFollows (
    follower_id INT,
    following_id INT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (follower_id, following_id),
    FOREIGN KEY (follower_id) REFERENCES Users(user_id),
    FOREIGN KEY (following_id) REFERENCES Users(user_id)
);

-- Insert some basic genres
INSERT INTO Genres (name) VALUES 
('Rock'), ('Pop'), ('Hip Hop'), ('Jazz'), ('Classical'), 
('Electronic'), ('R&B'), ('Country'), ('Metal'), ('Folk'),
('Indie'), ('Blues'), ('Reggae'), ('Ska'), ('Funk'), ('Beatbox'),
('Latin'), ('Disco'), ('Soul'), ('Gospel'), ('Punk'), ('Grunge'), 
('Metalcore'), ('Punk Rock'), ('Gothic Metal'), ('Trad Ceoil'), ('EDM'),
('Alternative'), ('Rockabilly'), ('Dance'), ('Techno'), ('House'), ('Trance'),
('Anime'), ('Game'), ('TV'), ('Other');

-- Insert sample users
INSERT INTO Users (username, password, email, phone_number, bio, profile_image_url, is_admin) VALUES 
('PixieStix', 'root1234SQL', 'pixiestix@talktempo.com', '+1234567890', 'My names Pixie and Im one of the founders of TalkTempo!', 'https://example.com/admin.jpg', 1),
('SenaRaufi', 'superCool1234HTML', 'senaraufi@talktempo.com', '+1234567890', 'My names Sena and Im one of the founders of TalkTempo!', 'https://example.com/admin.jpg', 1),
('OjalRakwal', 'woahdude1234PHP', 'ojalrakwal@talktempo.com', '+1234567890', 'My names Ojal and Im one of the founders of TalkTempo!', 'https://example.com/admin.jpg', 1),
---Normal User Accounts from here---
('UltimateSOADFan45', 'soadBestBandEver', 'serjtankian@yahoo.com', '+5556667778', 'I love System Of A Down theyre the best band in the world!', 'https://example.com/user1.jpg', 0),
('FionnaAppleStan78', 'bonnie2984', 'marieyunova@gmail.com', '+5556667778', 'I love music and love to listen to it', 'https://example.com/user2.jpg', 0);



--INFO FOR: Albums and Artists (Only Admins can add/edit these)
-- Insert System of a Down artist profile
INSERT INTO Artists (name, description, image_url, updated_by) VALUES 
('System of a Down', 'System of a Down is an Armenian-American heavy metal band formed in Glendale, California, in 1994. Known for their unique style combining alternative metal, hard rock, and Armenian folk music.', 'https://example.com/soad.jpg', (SELECT user_id FROM Users WHERE username = 'PixieStix'));

-- Connect System of a Down to their genres
INSERT INTO ArtistGenres (artist_id, genre_id) VALUES 
((SELECT artist_id FROM Artists WHERE name = 'System of a Down'), (SELECT genre_id FROM Genres WHERE name = 'Metal')),
((SELECT artist_id FROM Artists WHERE name = 'System of a Down'), (SELECT genre_id FROM Genres WHERE name = 'Alternative')),
((SELECT artist_id FROM Artists WHERE name = 'System of a Down'), (SELECT genre_id FROM Genres WHERE name = 'Rock'));

-- Insert Mezmerize album (added by admin)
INSERT INTO Albums (artist_id, title, release_date, description, image_url, updated_by) VALUES 
((SELECT artist_id FROM Artists WHERE name = 'System of a Down'), 
'Mezmerize', 
'2005-05-17', 
'Mezmerize is the fourth studio album by System of a Down. It was released on May 17, 2005, six months before the release of its companion album Hypnotize.',
'https://example.com/mezmerize.jpg',
(SELECT user_id FROM Users WHERE username = 'PixieStix'));

-- Connect Mezmerize to its genres
INSERT INTO AlbumGenres (album_id, genre_id) VALUES 
((SELECT album_id FROM Albums WHERE title = 'Mezmerize'), (SELECT genre_id FROM Genres WHERE name = 'Metal')),
((SELECT album_id FROM Albums WHERE title = 'Mezmerize'), (SELECT genre_id FROM Genres WHERE name = 'Alternative'));