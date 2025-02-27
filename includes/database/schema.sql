--ARTISTS/ALBUMS STUFF

-- Image path constants
PRAGMA FOREIGN_KEYS = ON;

-- Create Artists table
CREATE TABLE IF NOT EXISTS Artists (
    artist_id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_name VARCHAR(100) NOT NULL,
    genre VARCHAR(50),
    description TEXT,
    profile_image_path VARCHAR(255) DEFAULT 'imagesForMusic/artists/',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Albums table
CREATE TABLE IF NOT EXISTS Albums (
    album_id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_id INTEGER,
    album_name VARCHAR(100) NOT NULL,
    release_date DATE,
    cover_image_path VARCHAR(255) DEFAULT 'imagesForMusic/albums/',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id)
);

-- Create ArtistImages table for multiple artist images
CREATE TABLE IF NOT EXISTS ArtistImages (
    image_id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_id INTEGER,
    image_path VARCHAR(255) NOT NULL,
    image_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id)
);

-- Create AlbumImages table for multiple album images
CREATE TABLE IF NOT EXISTS AlbumImages (
    image_id INTEGER PRIMARY KEY AUTOINCREMENT,
    album_id INTEGER,
    image_path VARCHAR(255) NOT NULL,
    image_description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (album_id) REFERENCES Albums(album_id)
);

-- Note: Insert artists first since albums reference artist_ids
INSERT INTO Genres (genre_name, description) VALUES ('Pop');
INSERT INTO Genres (genre_name, description) VALUES ('R&B/Pop');
INSERT INTO Genres (genre_name, description) VALUES ('Pop/Rock');
INSERT INTO Genres (genre_name, description) VALUES ('Rock');
INSERT INTO Genres (genre_name, description) VALUES ('Hip Hop');
INSERT INTO Genres (genre_name, description) VALUES ('Alternative/Pop');
INSERT INTO Genres (genre_name, description) VALUES ('Electronic');
INSERT INTO Genres (genre_name, description) VALUES ('Folk');
INSERT INTO Genres (genre_name, description) VALUES ('Country');
INSERT INTO Genres (genre_name, description) VALUES ('Jazz');
INSERT INTO Genres (genre_name, description) VALUES ('Blues');
INSERT INTO Genres (genre_name, description) VALUES ('Classical');


-- Insert Artists
INSERT INTO Artists (artist_name, genre, description) VALUES 

--Pop
    ('Chappell Roan', 'Pop', 'American singer-songwriter'),
    ('Sabrina Carpenter', 'Pop', 'American singer-songwriter'),
    ('Lady Gaga', 'Pop', 'American singer-songwriter'),
    ('Billie Eilish', 'Pop', 'American singer-songwriter'),
   

--Pop/Rock
    ('Fiona Apple', 'Pop/Rock', 'American singer-songwriter'),

--Rock
    ('Fontaines DC', 'Rock', 'Irish rock band'),
    ('Linkin Park', 'Rock','American rock band'),
    ('Amyl and The Sniffers', 'Rock', 'Australian rock band')
    ('System of a Down', 'Rock', 'American rock band'),
    ('The Cranberries', 'Rock', 'Irish rock band'),

--Hip Hop
    ('Kendrick Lamar', 'Hip Hop', 'American rapper and songwriter'),
    ('Tyler, The Creator', 'Hip Hop', 'American rapper and songwriter'),
    ('Lola Young', 'Hip Hop', 'British rapper and songwriter'),


--Folk
    ('Joni Mitchell', 'Folk', 'American singer-songwriter'),


-- Insert Albums (using artist_ids from above inserts)
INSERT INTO Albums (artist_id, album_name, release_date) VALUES 
    (1, 'Midnights', '2022-10-21'),
    (1, '1989', '2014-10-27'),
    (2, 'After Hours', '2020-03-20'),
    (2, 'Dawn FM', '2022-01-07'),
    (3, 'AM', '2013-09-09'),
    (3, 'Favourite Worst Nightmare', '2007-04-23'),
    (4, 'good kid, m.A.A.d city', '2012-10-22'),
    (4, 'To Pimp a Butterfly', '2015-03-15'),
    (5, 'Born To Die', '2012-01-27'),
    (5, 'Norman Fucking Rockwell!', '2019-08-30');


-- For artists: INSERT INTO Artists (artist_name, genre, description) VALUES ('Name', 'Genre', 'Description');
-- For albums: INSERT INTO Albums (artist_id, album_name, release_date) VALUES (artist_id, 'Album Name', 'YYYY-MM-DD');

---USER TABLES


-- Create UserRatings table for storing user ratings of artists
CREATE TABLE IF NOT EXISTS UserRatings (
    rating_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    artist_id INTEGER,
    rating INTEGER CHECK (rating >= 1 AND rating <= 5),
    review_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id)
);

-- Create Users table
CREATE TABLE IF NOT EXISTS Users (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    contact_info VARCHAR(100) NOT NULL, -- Can store either email or phone number
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
