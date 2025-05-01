-- Users table is for every users profile: Both admins and Users of the site will be stored here
-- Images stored in /backend/database/images/ 

--USE THIS FORMAT FOR THE PHOTOS IN THE FUTURE!!!!: 'Image source: [Photographer Name] - [Website/Platform] - [License if applicable]'

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
('PixieStix', 'root1234SQL', 'pixiestix@talktempo.com', '+1234567890', 'My names Pixie and Im one of the founders of TalkTempo!', '/database/images/profile-default.jpg', 1),
('SenaRaufi', 'superCool1234HTML', 'senaraufi@talktempo.com', '+1234567890', 'My names Sena and Im one of the founders of TalkTempo!', '/database/images/profile-default.jpg', 1),
('OjalRakwal', 'woahdude1234PHP', 'ojalrakwal@talktempo.com', '+1234567890', 'My names Ojal and Im one of the founders of TalkTempo!', '/database/images/profile-default.jpg', 1),
-- Normal User Accounts from here
('UltimateSOADFan45', 'soadBestBandEver', 'serjtankian@yahoo.com', '+5556667778', 'I love System Of A Down theyre the best band in the world!', '/database/images/profile-default.jpg', 0),
('FionnaAppleStan78', 'bonnie2984', 'marieyunova@gmail.com', '+5556667778', 'I love music and love to listen to it', '/database/images/profile-default.jpg', 0);

-- INFO FOR: Albums and Artists (Only Admins can add/edit these)
-- Insert System of a Down artist profile
--GET PHOTOS OF ARTISTS TOO PLSSSSS DONT FORGET
INSERT INTO Artists (name, description, image_url, updated_by) VALUES 
('System of a Down', 'System of a Down is an Armenian-American heavy metal band formed in Glendale, California, in 1994. Known for their unique style combining alternative metal, hard rock, and Armenian folk music.', '/database/images/system-album.jpg', (SELECT user_id FROM Users WHERE username = 'PixieStix')),
('BTS', 'BTS is a South Korean boy band formed in 2013. Known for their unique style combining K-pop, hip-hop, and R&B.', '/database/images/BTS-album.jpg', (SELECT user_id FROM Users WHERE username = 'PixieStix')),
('Kendrick Lamar', 'Kendrick Lamar is an American rapper, singer, songwriter, and actor known for his socially conscious lyrics and innovative style.', '/database/images/kendrick-lamar.jpg', (SELECT user_id FROM Users WHERE username = 'PixieStix')),
('Fleetwood Mac', 'Fleetwood Mac is an English/American rock band formed in 1967. Known for their unique style combining rock, folk, and blues.', '/database/images/fleetwood-mac.jpg', (SELECT user_id FROM Users WHERE username = 'PixieStix'));

-- Connect System of a Down to their genres
INSERT INTO ArtistGenres (artist_id, genre_id) VALUES 
((SELECT artist_id FROM Artists WHERE name = 'System of a Down'), (SELECT genre_id FROM Genres WHERE name = 'Metal')),
((SELECT artist_id FROM Artists WHERE name = 'System of a Down'), (SELECT genre_id FROM Genres WHERE name = 'Alternative')),
((SELECT artist_id FROM Artists WHERE name = 'System of a Down'), (SELECT genre_id FROM Genres WHERE name = 'Rock'));
((SELECT artist_id FROM Artists WHERE name = 'BTS'), (SELECT genre_id FROM Genres WHERE name = 'K-pop')),
((SELECT artist_id FROM Artists WHERE name = 'BTS'), (SELECT genre_id FROM Genres WHERE name = 'Hip Hop')),
((SELECT artist_id FROM Artists WHERE name = 'BTS'), (SELECT genre_id FROM Genres WHERE name = 'R&B'));
((SELECT artist_id FROM Artists WHERE name = 'Kendrick Lamar'), (SELECT genre_id FROM Genres WHERE name = 'Hip Hop')),
((SELECT artist_id FROM Artists WHERE name = 'Kendrick Lamar'), (SELECT genre_id FROM Genres WHERE name = 'R&B'));
((SELECT artist_id FROM Artists WHERE name = 'Fleetwood Mac'), (SELECT genre_id FROM Genres WHERE name = 'Rock')),
((SELECT artist_id FROM Artists WHERE name = 'Fleetwood Mac'), (SELECT genre_id FROM Genres WHERE name = 'Folk'));

((SELECT artist_id FROM Artists WHERE name = 'Pixies'), (SELECT genre_id FROM Genres WHERE name = 'Alternative')),
((SELECT artist_id FROM Artists WHERE name = 'Pixies'), (SELECT genre_id FROM Genres WHERE name = 'Rock'));



-- Insert System of a Down (self titled) album 
INSERT INTO Albums (artist_id, title, release_date, description, image_url, updated_by) VALUES 
((SELECT artist_id FROM Artists WHERE name = 'System of a Down'), 
'System of A Down (self titled)', 
'1998-06-30', 
'System of a Down is the eponymous debut album by System of a Down, first released in 1998. The album was certified gold by the RIAA on February 2, 2000. Two years later, after the success of Toxicity, it was certified platinum.',--Source: Fandom.com
'/database/images/system-album.jpg', -- Image source: Designer = John Heartfield, found on Wikipedia
(SELECT user_id FROM Users WHERE username = 'PixieStix'));

--Insert Love Yourself: Answer 
INSERT INTO Albums (artist_id, title, release_date, description, image_url, updated_by) VALUES 
((SELECT artist_id FROM Artists WHERE name = 'BTS'), 
'Love Yourself: Answer', 
'2018-01-25', 
'Love Yourself: Answer is the second studio album by South Korean boy band BTS. It was released on January 25, 2018, as a follow-up to their debut album Love Yourself: Her.',--Source: Fandom.com
'/database/images/bts-album.jpg', -- Image source: Designer = HuskyFox, found on Wikipedia
(SELECT user_id FROM Users WHERE username = 'PixieStix'));


-- Insert Pimp a Butterfly album
INSERT INTO Albums (artist_id, title, release_date, description, image_url, updated_by) VALUES 
((SELECT artist_id FROM Artists WHERE name = 'Kendrick Lamar')),
('Pimp a Butterfly', 
'2015-06-02', 
'Pimp a Butterfly is the third studio album by American rapper Kendrick Lamar, released on June 2, 2015.', --Source: Fandom.com
'/database/images/kendrick-lamar.jpg', --Image source: Denis Rourve, found on Wikipedia
(SELECT user_id FROM Users WHERE username = 'PixieStix'));

-- Insert Rumours album
INSERT INTO Albums (artist_id, title, release_date, description, image_url, updated_by) VALUES 
((SELECT artist_id FROM Artists WHERE name = 'Fleetwood Mac')),
('Rumours', 
'1977-11-01', 
'Rumours is the eighth studio album by Fleetwood Mac, released on November 1, 1977.', --Source: Fandom.com
'/database/images/fleetwood-mac.jpg', --Image source: Designer = John Heartfield, found on Wikipedia
(SELECT user_id FROM Users WHERE username = 'PixieStix'));

-- Insert Pixies album
INSERT INTO Albums (artist_id, title, release_date, description, image_url, updated_by) VALUES 
((SELECT artist_id FROM Artists WHERE name = 'Pixies')),
('Trompe Le Monde', 
'September 23, 1991', 
'Trompe le Monde is the fourth studio album by the American alternative rock band Pixies, released on September 23, 1991[1] on 4AD in the United Kingdom and on September 24, 1991, on Elektra Records in the United States.', --Source: Wikipedia.com
'/database/images/pixies.jpg', --Image source: Designer = Vaughan Oliver, found on Wikipedia
(SELECT user_id FROM Users WHERE username = 'PixieStix'));

-- Connect System of A Down to its genres
INSERT INTO AlbumGenres (album_id, genre_id) VALUES 
((SELECT album_id FROM Albums WHERE title = 'System of A Down (self titled)'), (SELECT genre_id FROM Genres WHERE name = 'Metal')),
((SELECT album_id FROM Albums WHERE title = 'System of A Down (self titled)'), (SELECT genre_id FROM Genres WHERE name = 'Alternative'));

-- Connect Love Yourself: Answer to its genres
INSERT INTO AlbumGenres (album_id, genre_id) VALUES 
((SELECT album_id FROM Albums WHERE title = 'Love Yourself: Answer'), (SELECT genre_id FROM Genres WHERE name = 'K-pop')),
((SELECT album_id FROM Albums WHERE title = 'Love Yourself: Answer'), (SELECT genre_id FROM Genres WHERE name = 'Hip Hop')),
((SELECT album_id FROM Albums WHERE title = 'Love Yourself: Answer'), (SELECT genre_id FROM Genres WHERE name = 'R&B'));

-- Connect Pimp a Butterfly to its genres
INSERT INTO AlbumGenres (album_id, genre_id) VALUES 
((SELECT album_id FROM Albums WHERE title = 'Pimp a Butterfly'), (SELECT genre_id FROM Genres WHERE name = 'Hip Hop')),
((SELECT album_id FROM Albums WHERE title = 'Pimp a Butterfly'), (SELECT genre_id FROM Genres WHERE name = 'R&B'));

-- Connect Rumours to its genres
INSERT INTO AlbumGenres (album_id, genre_id) VALUES 
((SELECT album_id FROM Albums WHERE title = 'Rumours'), (SELECT genre_id FROM Genres WHERE name = 'Rock')),
((SELECT album_id FROM Albums WHERE title = 'Rumours'), (SELECT genre_id FROM Genres WHERE name = 'Folk'));

--Connect Trompe Le Monde to its genres
INSERT INTO AlbumGenres (album_id, genre_id) VALUES 
((SELECT album_id FROM Albums WHERE title = 'Trompe Le Monde'), (SELECT genre_id FROM Genres WHERE name = 'Alternative')),
((SELECT album_id FROM Albums WHERE title = 'Trompe Le Monde'), (SELECT genre_id FROM Genres WHERE name = 'Rock'));