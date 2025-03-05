-- Users table
CREATE TABLE Users (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
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
CREATE TABLE Genres (
    genre_id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(50) NOT NULL UNIQUE,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Artists table
CREATE TABLE Artists (
    artist_id INTEGER PRIMARY KEY AUTOINCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INTEGER,
    FOREIGN KEY (updated_by) REFERENCES Users(user_id)
);

-- Artist Genres (many-to-many relationship)
CREATE TABLE ArtistGenres (
    artist_id INTEGER,
    genre_id INTEGER,
    PRIMARY KEY (artist_id, genre_id),
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id),
    FOREIGN KEY (genre_id) REFERENCES Genres(genre_id)
);

-- Albums table
CREATE TABLE Albums (
    album_id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_id INTEGER NOT NULL,
    title VARCHAR(100) NOT NULL,
    release_date DATE,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INTEGER,
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id),
    FOREIGN KEY (updated_by) REFERENCES Users(user_id)
);

-- Album Genres (many-to-many relationship)
CREATE TABLE AlbumGenres (
    album_id INTEGER,
    genre_id INTEGER,
    PRIMARY KEY (album_id, genre_id),
    FOREIGN KEY (album_id) REFERENCES Albums(album_id),
    FOREIGN KEY (genre_id) REFERENCES Genres(genre_id)
);

-- Concerts table
CREATE TABLE Concerts (
    concert_id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_id INTEGER NOT NULL,
    name VARCHAR(100) NOT NULL,
    venue_name VARCHAR(100) NOT NULL,
    venue_location VARCHAR(255),
    concert_date DATE NOT NULL,
    concert_time TIME NOT NULL,
    description TEXT,
    image_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_by INTEGER,
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id),
    FOREIGN KEY (updated_by) REFERENCES Users(user_id)
);

-- Reviews table
CREATE TABLE Reviews (
    review_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    album_id INTEGER,
    concert_id INTEGER,
    rating DECIMAL(2,1) CHECK (rating >= 0 AND rating <= 5),
    title VARCHAR(100),
    content TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id),
    FOREIGN KEY (album_id) REFERENCES Albums(album_id),
    FOREIGN KEY (concert_id) REFERENCES Concerts(concert_id),
    CHECK ((album_id IS NULL AND concert_id IS NOT NULL) OR (album_id IS NOT NULL AND concert_id IS NULL))
);

-- Comments on reviews
CREATE TABLE Comments (
    comment_id INTEGER PRIMARY KEY AUTOINCREMENT,
    review_id INTEGER NOT NULL,
    user_id INTEGER NOT NULL,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (review_id) REFERENCES Reviews(review_id),
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- User Lists (like Letterboxd lists)
CREATE TABLE Lists (
    list_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    is_public BOOLEAN DEFAULT 1,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- List Items
CREATE TABLE ListItems (
    list_id INTEGER,
    album_id INTEGER,
    position INTEGER NOT NULL,
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (list_id, album_id),
    FOREIGN KEY (list_id) REFERENCES Lists(list_id),
    FOREIGN KEY (album_id) REFERENCES Albums(album_id)
);

-- User Following
CREATE TABLE UserFollows (
    follower_id INTEGER,
    following_id INTEGER,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (follower_id, following_id),
    FOREIGN KEY (follower_id) REFERENCES Users(user_id),
    FOREIGN KEY (following_id) REFERENCES Users(user_id)
);

-- Insert some basic genres
INSERT INTO Genres (name) VALUES 
('Rock'), ('Pop'), ('Hip Hop'), ('Jazz'), ('Classical'), 
('Electronic'), ('R&B'), ('Country'), ('Metal'), ('Folk'),
('Indie'), ('Blues'), ('Reggae'), ('Ska'), ('Funk'), ('Beatbox')
('Latin'), ('Disco'), ('Soul'), ('Gospel'), ('Punk'), ('Grunge'), 
('Metalcore'), ('Punk Rock'), ('Gothic Metal'), ('Trad Ceoil'), ('EDM'),
('Alternative'), ('Rockabilly'), ('Dance'), ('Techno'), ('House'), ('Trance'),
('Anime'), ('Game'), ('TV'), ('Other');

INSERT INTO Users (username, password, email, phone_number, bio, profile_image_url, is_admin) VALUES 
('PixieStix', 'root1234SQL', 'pixiestix@talktempo.com', '+1234567890', 'My names Pixie and Im one of the founders of TalkTempo!', 'https://example.com/admin.jpg', 1);
('SenaRaufi', 'superCool1234HTML', 'senaraufi@talktempo.com', '+1234567890', 'My names Sena and Im one of the founders of TalkTempo!', 'https://example.com/admin.jpg', 1);
('OjalRakwal', 'woahdude1234PHP', 'ojalrakwal@talktempo.com', '+1234567890', 'My names Ojal and Im one of the founders of TalkTempo!', 'https://example.com/admin.jpg', 1);

