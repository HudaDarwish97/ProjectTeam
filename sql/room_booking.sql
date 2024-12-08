-- Create the database and switch to it
CREATE DATABASE IF NOT EXISTS Room_booking;
USE Room_booking;

-- Table structure for table `adminlogs`
CREATE TABLE `adminlogs` (
  `log_id` INT(11) NOT NULL AUTO_INCREMENT,
  `admin_id` INT(11) NOT NULL,
  `action` VARCHAR(255) NOT NULL,
  `action_timestamp` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `details` TEXT DEFAULT NULL,
  PRIMARY KEY (`log_id`),
  KEY `admin_id` (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data for table `adminlogs`
INSERT INTO `adminlogs` (`log_id`, `admin_id`, `action`, `action_timestamp`, `details`) VALUES
(1, 1, 'Added new room: Room 101', '2024-11-25 00:00:00', NULL),
(2, 1, 'Booked Room 102 for user 2', '2024-11-26 00:00:00', NULL),
(3, 1, 'Deleted booking for Room 103', '2024-11-27 00:00:00', NULL);

-- Table structure for table `bookings`
CREATE TABLE `bookings` (
  `booking_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `room_id` INT(11) NOT NULL,
  `booking_date` DATE NOT NULL,
  `time_slot` VARCHAR(50) NOT NULL,
  `status` ENUM('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending',
  PRIMARY KEY (`booking_id`),
  KEY `user_id` (`user_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data for table `bookings`
INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `booking_date`, `time_slot`, `status`) VALUES
(6, 1, 1, '2024-11-26', '09:00-11:00', 'Confirmed'),
(7, 2, 2, '2024-11-26', '11:00-13:00', 'Pending');

-- Table structure for table `comments`
CREATE TABLE `comments` (
  `comment_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_id` INT(11) NOT NULL,
  `room_id` INT(11) NOT NULL,
  `comment_text` TEXT NOT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`comment_id`),
  KEY `user_id` (`user_id`),
  KEY `room_id` (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data for table `comments`
INSERT INTO `comments` (`comment_id`, `user_id`, `room_id`, `comment_text`, `created_at`) VALUES
(1, 1, 1, 'Great room for lectures, everything works fine.', '2024-11-25 00:00:00'),
(2, 2, 2, 'The projector is a bit outdated, but the room is good.', '2024-11-26 00:00:00');

-- Table structure for table `rooms`
CREATE TABLE `rooms` (
  `room_id` INT(11) NOT NULL AUTO_INCREMENT,
  `room_name` VARCHAR(100) NOT NULL UNIQUE,
  `room_type` ENUM('Lecture','Lab') NOT NULL,
  `building` VARCHAR(100) NOT NULL,
  `floor` INT(11) NOT NULL,
  `department` VARCHAR(100) NOT NULL,
  `capacity` INT(11) NOT NULL,
  `image1` VARCHAR(255) DEFAULT NULL,
  `image2` VARCHAR(255) DEFAULT NULL,
  `image3` VARCHAR(255) DEFAULT NULL,
  `image4` VARCHAR(255) DEFAULT NULL,
  `image5` VARCHAR(255) DEFAULT NULL,
  `availability_status` ENUM('Available','Booked') NOT NULL DEFAULT 'Available',
  `description` VARCHAR(255) NOT NULL,
  PRIMARY KEY (`room_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data for table `rooms`
INSERT INTO `rooms` (`room_id`, `room_name`, `room_type`, `building`, `floor`, `department`, `capacity`, `image1`, `image2`, `image3`, `image4`, `image5`, `availability_status`, `description`) VALUES
(1, 'Room 021', 'Lab', 'IT', 0, 'IS', 45, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(2, 'Room 1006', 'Lab', 'IT', 1, 'IS', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(3, 'Room 2005', 'Lab', 'IT', 2, 'IS', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(4, 'Room 032', 'Lecture', 'IT', 0, 'IS', 30, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(5, 'Room 2008', 'Lecture', 'IT', 2, 'IS', 32, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(6, 'Room 051', 'Lab', 'IT', 0, 'CS', 45, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(7, 'Room 1047', 'Lab', 'IT', 1, 'CS', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(8, 'Room 2050', 'Lab', 'IT', 2, 'CS', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(9, 'Room 049', 'Lecture', 'IT', 0, 'CS', 30, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(10, 'Room 1047', 'Lecture', 'IT', 1, 'CS', 55, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(11, 'Room 079', 'Lab', 'IT', 0, 'CE', 45, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(12, 'Room 1081', 'Lab', 'IT', 1, 'CE', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(13, 'Room 2091', 'Lab', 'IT', 2, 'CE', 50, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(14, 'Room 085', 'Lecture', 'IT', 0, 'CE', 30, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(15, 'Room 1086', 'Lecture', 'IT', 1, 'CE', 55, 'room1.jpeg', 'room2.jpeg', 'room3.jpeg', 'room4.jpeg', 'room5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.');

-- Table structure for table `users`
CREATE TABLE `users` (
  `user_id` INT(11) NOT NULL AUTO_INCREMENT,
  `user_name` VARCHAR(100) NOT NULL,
  `user_email` VARCHAR(150) NOT NULL,
  `user_password` VARCHAR(255) NOT NULL,
  `user_role` ENUM('Admin','User') NOT NULL DEFAULT 'User',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_email` (`user_email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert data for table `users`
INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_role`) VALUES
(1, 'Admin User', 'admin@example.com', 'hashedpassword', 'Admin'),
(2, 'Regular User', 'user@example.com', 'hashedpassword', 'User');

-- Add foreign key constraints
ALTER TABLE `adminlogs`
  ADD CONSTRAINT `adminlogs_ibfk_1` FOREIGN KEY (`admin_id`) REFERENCES `users` (`user_id`);

ALTER TABLE `bookings`
  ADD CONSTRAINT `bookings_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `bookings_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`room_id`) REFERENCES `rooms` (`room_id`);

