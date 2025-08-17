-- Create database
CREATE DATABASE IF NOT EXISTS youtube_clone;
USE youtube_clone;

-- Users table
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_image VARCHAR(255) DEFAULT 'https://media.istockphoto.com/id/1300845620/vector/user-icon-flat-isolated-on-white-background-user-symbol-vector-illustration.jpg',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Categories table
CREATE TABLE IF NOT EXISTS categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) NOT NULL,
    icon VARCHAR(50),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Videos table
CREATE TABLE IF NOT EXISTS videos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    video_url VARCHAR(500) NOT NULL,
    thumbnail_url VARCHAR(500),
    user_id INT NOT NULL,
    category_id INT NOT NULL,
    views INT DEFAULT 0,
    likes INT DEFAULT 0,
    dislikes INT DEFAULT 0,
    duration VARCHAR(20),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
);

-- Comments table
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    video_id INT NOT NULL,
    user_id INT NOT NULL,
    comment TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

-- Subscriptions table
CREATE TABLE IF NOT EXISTS subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subscriber_id INT NOT NULL,
    channel_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subscriber_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (channel_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY unique_subscription (subscriber_id, channel_id)
);

-- Watch history table
CREATE TABLE IF NOT EXISTS watch_history (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    video_id INT NOT NULL,
    watched_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (video_id) REFERENCES videos(id) ON DELETE CASCADE
);

-- Insert default categories
INSERT INTO categories (name, icon) VALUES
('All', 'fa-solid fa-home'),
('Music', 'fa-solid fa-music'),
('JavaScript', 'fa-brands fa-js'),
('Gaming', 'fa-solid fa-gamepad'),
('Stories', 'fa-solid fa-book'),
('Blogs', 'fa-solid fa-blog'),
('Podcast', 'fa-solid fa-podcast'),
('English Learning', 'fa-solid fa-graduation-cap'),
('Web Series', 'fa-solid fa-tv'),
('Live', 'fa-solid fa-signal'),
('Recently Uploaded', 'fa-solid fa-clock'),
('New To You', 'fa-solid fa-star');

-- Insert sample user
INSERT INTO users (username, email, password) VALUES
('admin', 'admin@youtube.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Insert sample videos
INSERT INTO videos (title, description, video_url, thumbnail_url, user_id, category_id, views) VALUES
('SKIT College Review', 'What are students saying about SKIT College', 'https://www.youtube.com/embed/u_7zrb6nGBQ', 'https://img.youtube.com/vi/u_7zrb6nGBQ/maxresdefault.jpg', 1, 1, 18000),
('CSS Tutorial for Beginners', 'Complete CSS with Project, Notes', 'https://www.youtube.com/embed/ESnrn1kAD4E', 'https://img.youtube.com/vi/ESnrn1kAD4E/maxresdefault.jpg', 1, 3, 13000000),
('Saiyaara Female Song', 'Ahaan Aneet | Tanishk,Faheem,Arslan', 'https://www.youtube.com/embed/-lVzdxgVNeg', 'https://img.youtube.com/vi/-lVzdxgVNeg/maxresdefault.jpg', 1, 2, 19000),
('1st Stand Up Comedy', 'Comedy Mastii by Sambhav Jain', 'https://www.youtube.com/embed/OGwlJXxUKvY', 'https://img.youtube.com/vi/OGwlJXxUKvY/maxresdefault.jpg', 1, 5, 772),
('Bhool Bhulaiyaa 4 Trailer', 'First Look Trailer', 'https://www.youtube.com/embed/Qb1Oq8LD-44', 'https://img.youtube.com/vi/Qb1Oq8LD-44/maxresdefault.jpg', 1, 9, 91000),
('TCS CodeVita 2025', 'Complete Process- Eligibility Criteria', 'https://www.youtube.com/embed/AjLqxZ9x1V4', 'https://img.youtube.com/vi/AjLqxZ9x1V4/maxresdefault.jpg', 1, 8, 26000);