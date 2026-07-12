CREATE DATABASE IF NOT EXISTS CafeAnoTara;
USE CafeAnoTara;


CREATE TABLE Users (
    user_id INT AUTO_INCREMENT,
    firstname VARCHAR(30) NOT NULL,
    lastname VARCHAR(30) NOT NULL,
    username VARCHAR(30) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    mobilenumber VARCHAR(20),
    role ENUM('customer', 'owner', 'admin') NOT NULL,
    account_status ENUM('active', 'suspended', 'deleted') DEFAULT 'active',
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (user_id)
);

CREATE TABLE Cafes (
    cafe_id INT AUTO_INCREMENT,
    owner_id INT,
    cafe_name VARCHAR(45) NOT NULL,
    location VARCHAR(45) NOT NULL,
    description VARCHAR(255),
    wifi_speed VARCHAR(45),
    noise_level ENUM('quiet', 'moderate', 'loud'),
    outlet_num INT,
    opening_time TIME,
    closing_time TIME,
    price INT,
    is_verified BOOLEAN DEFAULT FALSE,
    google_maps_url VARCHAR(255),
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (cafe_id),
    FOREIGN KEY (owner_id) REFERENCES Users(user_id) ON DELETE SET NULL
);

CREATE TABLE CafeIMG (
    photo_id INT AUTO_INCREMENT,
    cafe_id INT NOT NULL,
    photo_url VARCHAR(255) NOT NULL,
    PRIMARY KEY (photo_id),
    FOREIGN KEY (cafe_id) REFERENCES Cafes(cafe_id) ON DELETE CASCADE
);


CREATE TABLE Bookmarks (
    bookmark_id INT AUTO_INCREMENT,
    customer_id INT NOT NULL,
    cafe_id INT NOT NULL,
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (bookmark_id),
    FOREIGN KEY (customer_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (cafe_id) REFERENCES Cafes(cafe_id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_cafe_bookmark (customer_id, cafe_id)
);

CREATE TABLE Reviews (
    review_id INT AUTO_INCREMENT,
    customer_id INT NOT NULL,
    cafe_id INT NOT NULL,
    rating INT NOT NULL,
    comment VARCHAR(255),
    owner_reply VARCHAR(255),
    is_inappropriate BOOLEAN DEFAULT FALSE,
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (review_id),
    FOREIGN KEY (customer_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (cafe_id) REFERENCES Cafes(cafe_id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_cafe_review (customer_id, cafe_id)
);

CREATE TABLE Reports (
    report_id INT AUTO_INCREMENT,
    reporter_id INT NOT NULL,
    reported_user_id INT,
    reported_cafe_id INT,
    reported_review_id INT,
    report_code INT NOT NULL,
    status ENUM('ongoing', 'resolved') DEFAULT 'ongoing',
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (report_id),
    FOREIGN KEY (reporter_id) REFERENCES Users(user_id) ON DELETE CASCADE,
    FOREIGN KEY (reported_user_id) REFERENCES Users(user_id) ON DELETE SET NULL,
    FOREIGN KEY (reported_cafe_id) REFERENCES Cafes(cafe_id) ON DELETE SET NULL,
    FOREIGN KEY (reported_review_id) REFERENCES Reviews(review_id) ON DELETE SET NULL,
    FOREIGN KEY (report_code) REFERENCES ReportCode(report_code)
);

CREATE TABLE ReportCode (
    report_code INT AUTO_INCREMENT,
    report VARCHAR(45) NOT NULL UNIQUE,
    PRIMARY KEY (report_code)
);

INSERT INTO ReportCode (report)
VALUES
('Harassment'),
('Hate Speech'),
('Inappropriate Language'),
('False Information'),
('Sharing Personal Information');

INSERT INTO Users (firstname, lastname, username, password, email, mobilenumber, role, account_status, created_on)
VALUES
('Albert', 'Wesker', 'admin', 'P@ss12345', 'admin@gmail.com', '09604700469', 'admin', 'active', '2026-06-01 09:00:00'),
('Claire', 'Redfield', 'cafe_owner', 'P@ss12345', 'owner@gmail.com', '09604700469', 'owner', 'active', '2026-06-05 10:15:00'),
('Jill', 'Valentine', 'pat_study_hard', 'P@ss12345', 'customer@gmail.com', '09604700469', 'customer', 'active', '2026-07-01 14:00:00');

INSERT INTO Cafes (owner_id, cafe_name, location, description, wifi_speed, noise_level, outlet_num, opening_time, closing_time, price, is_verified, google_maps_url, created_on)
VALUES
(2, 'Coffee Bun', 'Gen Ave., Cubao, Quezon City', 'A nice comfortable space for student alike', '150', 'quiet', 10, '07:00:00', '23:00:00', 100-300, TRUE, 'https://www.google.com/maps', '2026-06-06 11:30:00');

INSERT INTO CafeIMG (cafe_id, photo_url)
VALUES
(1, 'cafe.png'),
(1, 'cafe.png');

INSERT INTO Bookmarks (customer_id, cafe_id, created_on)
VALUES
(3, 1, '2026-07-10 16:45:00');

INSERT INTO Reviews (customer_id, cafe_id, rating, comment, created_on)
VALUES
(3, 1, 5, 'Fast WiFi with many outlets, would recommend.', '2026-07-10 18:20:00');

INSERT INTO Reports (reporter_id, reported_user_id, reported_cafe_id, reported_review_id, report_code, status, created_on)
VALUES
(2, 3, 1, 1, 3, 'ongoing', '2026-07-11 11:05:00');





