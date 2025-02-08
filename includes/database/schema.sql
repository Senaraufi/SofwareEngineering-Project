-- Users table
CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255),
    bio TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Artists table
CREATE TABLE artists (
    artist_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    bio TEXT,
    image_url VARCHAR(255)
);

-- Albums table
CREATE TABLE albums (
    album_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    artist_id INT,
    release_date DATE,
    cover_art VARCHAR(255),
    FOREIGN KEY (artist_id) REFERENCES artists(artist_id)
);

-- Reviews table
CREATE TABLE reviews (
    review_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    album_id INT,
    rating DECIMAL(2,1),
    review_text TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id),
    FOREIGN KEY (album_id) REFERENCES albums(album_id)
);

-- Lists table
CREATE TABLE lists (
    list_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);

-- List_Albums (junction table for lists and albums)
CREATE TABLE list_albums (
    list_id INT,
    album_id INT,
    position INT,
    PRIMARY KEY (list_id, album_id),
    FOREIGN KEY (list_id) REFERENCES lists(list_id),
    FOREIGN KEY (album_id) REFERENCES albums(album_id)
);

-- Merchandise table
CREATE TABLE merchandise (
    merch_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image_url VARCHAR(255),
    stock_quantity INT NOT NULL
);

-- Events (concerts) table
CREATE TABLE events (
    event_id INT PRIMARY KEY AUTO_INCREMENT,
    artist_id INT,
    venue VARCHAR(100) NOT NULL,
    event_date DATETIME NOT NULL,
    description TEXT,
    ticket_price DECIMAL(10,2) NOT NULL,
    available_tickets INT NOT NULL,
    FOREIGN KEY (artist_id) REFERENCES artists(artist_id)
);

-- Tickets table
CREATE TABLE tickets (
    ticket_id INT PRIMARY KEY AUTO_INCREMENT,
    event_id INT,
    user_id INT,
    purchase_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (event_id) REFERENCES events(event_id),
    FOREIGN KEY (user_id) REFERENCES users(user_id)
);
