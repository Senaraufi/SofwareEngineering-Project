-- Users table to store both regular users and admins
CREATE TABLE Users (
    user_id INTEGER PRIMARY KEY AUTOINCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    is_admin BOOLEAN DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Comments table to store user comments
CREATE TABLE Comments (
    comment_id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER,
    content TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(user_id)
);

-- Content table for managing website content
CREATE TABLE Content (
    content_id INTEGER PRIMARY KEY AUTOINCREMENT,
    title VARCHAR(100) NOT NULL,
    body TEXT NOT NULL,
    created_by INTEGER,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (created_by) REFERENCES Users(user_id)
);

-- Insert some sample data
INSERT INTO Users (username, password, email, is_admin) VALUES 
('admin', '$2y$10$example_hash', 'admin@example.com', 1),
('user1', '$2y$10$example_hash', 'user1@example.com', 0);

INSERT INTO Comments (user_id, content) VALUES 
(2, 'This is a great feature!'),
(2, 'Looking forward to more updates');

INSERT INTO Content (title, body, created_by) VALUES 
('Welcome Post', 'Welcome to our platform!', 1),
('Getting Started', 'Here are some tips to get started...', 1);
