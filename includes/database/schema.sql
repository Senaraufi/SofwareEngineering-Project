-- Create Users table
CREATE TABLE IF NOT EXISTS Users (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    contact_info VARCHAR(100) NOT NULL, -- Can store either email or phone number
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Artists table
CREATE TABLE IF NOT EXISTS Artists (
    artist_id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_name VARCHAR(100) NOT NULL,
    genre VARCHAR(50),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Create Albums table
CREATE TABLE IF NOT EXISTS Albums (
    album_id INTEGER PRIMARY KEY AUTOINCREMENT,
    artist_id INTEGER,
    album_name VARCHAR(100) NOT NULL,
    release_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (artist_id) REFERENCES Artists(artist_id)
);

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
