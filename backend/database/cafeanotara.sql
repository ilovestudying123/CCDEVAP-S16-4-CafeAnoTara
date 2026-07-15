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
    location VARCHAR(255) NOT NULL,
    description VARCHAR(255),
    wifi_speed VARCHAR(45),
    noise_level ENUM('quiet', 'moderate', 'loud'),
    outlet_num INT,
    opening_time TIME,
    closing_time TIME,
    price VARCHAR(45),
    is_verified BOOLEAN DEFAULT FALSE,
    google_maps_url VARCHAR(255),
    created_on DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (cafe_id),
    FOREIGN KEY (owner_id) REFERENCES Users(user_id) ON DELETE SET NULL
);

CREATE TABLE CafeIMG (
    photo_id INT AUTO_INCREMENT,
    cafe_id INT NOT NULL,
    photo_url VARCHAR(500) NOT NULL,
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

CREATE TABLE ReportCode (
    report_code INT AUTO_INCREMENT,
    report VARCHAR(45) NOT NULL UNIQUE,
    PRIMARY KEY (report_code)
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

-- Report Codes
INSERT INTO ReportCode (report)
VALUES
('Harassment'),
('Hate Speech'),
('Inappropriate Language'),
('False Information'),
('Sharing Personal Information');

-- Users
INSERT INTO Users
(firstname, lastname, username, password, email, mobilenumber, role, account_status, created_on)
VALUES
('Albert', 'Wesker', 'admin1', 'P@ss12345', 'admin@gmail.com', '09604700469', 'admin', 'active', '2026-06-01 09:00:00'),
('Claire', 'Redfield', 'owner1', 'P@ss12345', 'owner1@gmail.com', '09171234567', 'owner', 'active', '2026-06-05 10:15:00'),
('Leon', 'Kennedy', 'owner2', 'P@ss12345', 'owner2@gmail.com', '09181234567', 'owner', 'active', '2026-06-06 10:30:00'),
('Jill', 'Valentine', 'customer1', 'P@ss12345', 'customer1@gmail.com', '09221234567', 'customer', 'active', '2026-07-01 14:00:00'),
('Ada', 'Wong', 'customer2', 'P@ss12345', 'customer2@gmail.com', '09231234567', 'customer', 'active', '2026-07-01 15:00:00'),
('Chris', 'Redfield', 'customer3', 'P@ss12345', 'customer3@gmail.com', '09241234567', 'customer', 'active', '2026-07-02 10:00:00');

-- Cafes
INSERT INTO Cafes
(owner_id, cafe_name, location, description, wifi_speed, noise_level,
outlet_num, opening_time, closing_time, price, is_verified, google_maps_url, created_on)
VALUES
(2, 'Coffee Bun', 'Cubao, Quezon City', 'Great study cafe with strong WiFi.', '150 Mbps', 'quiet', 12, '07:00:00', '23:00:00', '100-300', TRUE, 'https://maps.google.com', '2026-06-06 11:30:00'),

(3, 'Daily Brew', 'Taft, Manila', 'Perfect for students near universities.', '200 Mbps', 'moderate', 20, '08:00:00', '22:00:00', '150-350', TRUE, 'https://maps.google.com', '2026-06-10 10:00:00'),

(3, 'Cafe Horizon', 'Makati City', 'Modern café with relaxing ambiance.', '300 Mbps', 'quiet', 18, '08:00:00', '00:00:00', '200-400', TRUE, 'https://maps.google.com', '2026-06-12 09:30:00'),

(3, 'Bean Avenue', 'BGC, Taguig', 'Minimalist coffee shop with plenty of sockets.', '250 Mbps', 'moderate', 25, '07:30:00', '23:30:00', '180-350', TRUE, 'https://maps.google.com', '2026-06-15 11:00:00'),

(3, 'Midnight Coffee', 'España, Manila', 'Open late for students finishing requirements.', '180 Mbps', 'loud', 10, '16:00:00', '03:00:00', '120-280', FALSE, 'https://maps.google.com', '2026-06-20 15:00:00');

-- Cafe Images
INSERT INTO CafeIMG (cafe_id, photo_url)
VALUES
(1,'https://images.tastet.ca/_/rs:fit:1080:720:false:0/plain/local:///2015/12/parvis-3.jpg@jpg'),
(1,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQmsJGvnhm3QR1zREMOQ6CWANE_sFazKGj8qqBPI78HcikxxvQf_bmMD8Zk&s=10'),
(2,'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRy7ophiBp_kZHS_aanVnZojTQzVQm4VjF4srzK8vr8Mw&s=10'),
(3,'https://www.dubaiparksandresorts.com/sites/default/files/2024-11/DSC09435%201.JPG'),
(4,'https://mb.com.ph/uploads/imported_images/jpeg_optimizer_The_cozy_ambiance_of_the_second_floor_of_Cafe_Malvar_ac73aada24.jpg'),
(5,'https://www.dubaiparksandresorts.com/sites/default/files/2024-11/DSC09450-Enhanced-NR.JPG');

-- Bookmarks
INSERT INTO Bookmarks (customer_id, cafe_id, created_on)
VALUES
(4,1,'2026-07-10 16:45:00'),
(4,3,'2026-07-10 17:00:00'),
(5,1,'2026-07-11 10:30:00'),
(5,2,'2026-07-11 11:00:00'),
(6,4,'2026-07-12 09:00:00'),
(6,5,'2026-07-12 09:15:00');

-- Reviews
INSERT INTO Reviews
(customer_id, cafe_id, rating, comment, owner_reply, created_on)
VALUES
(4,1,5,'Fast WiFi with many outlets. Highly recommended!','Thank you for visiting!','2026-07-10 18:20:00'),

(5,1,3,'It is louder than I expected during peak hours.','We appreciate the feedback.','2026-07-11 18:20:00'),

(6,2,4,'Coffee tastes great and the staff are friendly.','Glad you enjoyed!','2026-07-12 14:10:00'),

(4,3,5,'Very quiet place to study for exams.','Hope to see you again!','2026-07-13 09:45:00'),

(5,4,4,'Lots of charging outlets and comfortable seats.','Thank you!','2026-07-14 13:20:00'),

(6,5,2,'Music was too loud and WiFi was unstable.','We will work on improving.','2026-07-15 20:00:00');

-- Reports
INSERT INTO Reports
(reporter_id, reported_user_id, reported_cafe_id, reported_review_id,
report_code, status, created_on)
VALUES
(2,4,1,1,3,'ongoing','2026-07-11 11:05:00'),
(3,5,1,2,1,'resolved','2026-07-12 10:00:00'),
(2,6,2,3,4,'ongoing','2026-07-13 15:30:00'),
(3,4,3,4,5,'resolved','2026-07-14 09:15:00'),
(2,5,4,5,2,'ongoing','2026-07-15 13:00:00'),
(3,6,5,6,3,'resolved','2026-07-16 08:45:00');


