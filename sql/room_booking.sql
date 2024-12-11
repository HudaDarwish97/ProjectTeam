CREATE DATABASE `room_booking`;
USE `room_booking`;

CREATE TABLE `adminlogs` (
  `log_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `admin_id` int(11) NOT NULL,
  `action` varchar(255) NOT NULL,
  `action_timestamp` datetime NOT NULL DEFAULT current_timestamp(),
  `details` text DEFAULT NULL
);

INSERT INTO `adminlogs` (`log_id`, `admin_id`, `action`, `action_timestamp`, `details`) VALUES
(1, 1, 'Added new room: Room 101', '2024-11-25 00:00:00', NULL),
(2, 1, 'Booked Room 102 for user 2', '2024-11-26 00:00:00', NULL),
(3, 1, 'Deleted booking for Room 103', '2024-11-27 00:00:00', NULL);


CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `booking_date` date NOT NULL,
  `time_slot` varchar(50) NOT NULL,
  `status` enum('Pending','Confirmed','Cancelled') NOT NULL DEFAULT 'Pending'
);

INSERT INTO `bookings` (`booking_id`, `user_id`, `room_id`, `booking_date`, `time_slot`, `status`) VALUES
(6, 1, 1, '2024-11-26', '09:00-11:00', 'Confirmed'),
(7, 2, 2, '2024-11-26', '11:00-13:00', 'Pending');

CREATE TABLE `comments` (
  `comment_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
  `user_id` int(11) NOT NULL,
  `room_id` int(11) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
);

INSERT INTO `comments` (`comment_id`, `user_id`, `room_id`, `comment_text`, `created_at`) VALUES
(0, 0, 6, 'fff', '2024-12-10 19:12:14'),
(1, 1, 1, 'Great room for lectures, everything works fine.', '2024-11-25 00:00:00'),
(2, 2, 2, 'The projector is a bit outdated, but the room is good.', '2024-11-26 00:00:00');


CREATE TABLE `comment_replies` (
  `reply_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `comment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reply_text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
);

INSERT INTO `comment_replies` (`reply_id`, `comment_id`, `user_id`, `reply_text`, `created_at`) VALUES
(0, 0, 0, 'hrhhr', '2024-12-10 19:16:44');

CREATE TABLE `notifications` (
  `notification_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `reply_id` int(11) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` datetime DEFAULT current_timestamp()
);

CREATE TABLE `rooms` (
  `room_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `room_name` varchar(100) NOT NULL,
  `room_type` enum('Lecture','Lab') NOT NULL,
  `building` varchar(100) NOT NULL,
  `floor` int(11) NOT NULL,
  `department` varchar(100) NOT NULL,
  `capacity` int(11) NOT NULL,
  `image1` varchar(255) DEFAULT NULL,
  `image2` varchar(255) DEFAULT NULL,
  `image3` varchar(255) DEFAULT NULL,
  `image4` varchar(255) DEFAULT NULL,
  `image5` varchar(255) DEFAULT NULL,
  `availability_status` enum('Available','Booked') NOT NULL DEFAULT 'Available',
  `description` varchar(255) NOT NULL
);


INSERT INTO `rooms` (`room_id`, `room_name`, `room_type`, `building`, `floor`, `department`, `capacity`, `image1`, `image2`, `image3`, `image4`, `image5`, `availability_status`, `description`) VALUES
(1, 'Room 021', 'Lab', 'IT', 0, 'IS', 45, 'roomL1.png', 'roomL2.jpg', 'roomL3.jpg', 'roomL4.jpg',  'roomL5.jpeg' 'Available', 'A spacious lab equipped with the latest technology.'),
(2, 'Room 1006', 'Lab', 'IT', 1, 'IS', 50, 'roomL2.jpg', 'roomL1.png', 'roomL4.jpg', 'roomL5.jpeg', 'roomL3.jpg', 'Available', 'A spacious lab equipped with the latest technology.'),
(3, 'Room 2005', 'Lab', 'IT', 2, 'IS', 50, 'roomL3.jpg', 'roomL4.jpg', 'roomL2.jpg', 'roomL1.png', 'roomL5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(4, 'Room 032', 'Lecture', 'IT', 0, 'IS', 30, 'roomC1.jpeg', 'roomC3.jpg', 'roomC4.jpg', 'roomC2.jpg', 'roomC5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(5, 'Room 2008', 'Lecture', 'IT', 2, 'IS', 32, 'roomC2.jpg', 'roomC1.jpeg', 'roomC3.jpg', 'roomC4.jpg', 'roomC6.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(6, 'Room 051', 'Lab', 'IT', 0, 'CS', 45, 'roomL4.jpg', 'roomL2.jpg', 'roomL5.jpeg', 'roomL1.png', 'roomL3.jpg', 'Available', 'A spacious lab equipped with the latest technology.'),
(7, 'Room 1049', 'Lab', 'IT', 1, 'CS', 50, 'roomL5.jpeg', 'roomL1.png', 'roomL2.jpg', 'roomL4.jpg', 'roomL6.jpg', 'Available', 'A spacious lab equipped with the latest technology.'),
(8, 'Room 2050', 'Lab', 'IT', 2, 'CS', 50, 'roomL6.jpg', 'roomL3.jpg', 'roomL1.png', 'roomL2.jpg', 'roomL5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(9, 'Room 049', 'Lecture', 'IT', 0, 'CS', 30, 'roomC3.jpg', 'roomC5.jpeg', 'roomC6.jpeg', 'roomC1.jpeg', 'roomC2.jpg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(10, 'Room 1047', 'Lecture', 'IT', 1, 'CS', 55, 'roomC4.jpg', 'roomC3.jpg', 'roomC6.jpeg', 'roomC5.jpeg', 'roomC2.jpg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(11, 'Room 079', 'Lab', 'IT', 0, 'CE', 45, 'roomL7.jpeg', 'roomL1.png', 'roomL4.jpg', 'roomL5.jpeg', 'roomL3.jpg', 'Available', 'A spacious lab equipped with the latest technology.'),
(12, 'Room 1081', 'Lab', 'IT', 1, 'CE', 50, 'roomL8.jpg', 'roomL2.jpg', 'roomL3.jpg', 'roomL4.jpg',  'roomL5.jpeg', 'Available', 'A spacious lab equipped with the latest technology.'),
(13, 'Room 2091', 'Lab', 'IT', 2, 'CE', 50, 'roomL9.jpg', 'roomL8.jpg', 'roomL4.jpg', 'roomL2.jpg', 'roomL1.png', 'Available', 'A spacious lab equipped with the latest technology.'),
(14, 'Room 085', 'Lecture', 'IT', 0, 'CE', 30, 'roomC5.jpeg', 'roomC3.jpg', 'roomC4.jpg', 'roomC2.jpg', 'roomC6.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.'),
(15, 'Room 1086', 'Lecture', 'IT', 1, 'CE', 55, 'roomC6.jpeg', 'roomC1.jpeg', 'roomC3.jpg', 'roomC4.jpg', 'roomC5.jpeg', 'Available', 'Ideal for lectures and workshops, large and spacious area for explanation.');


CREATE TABLE `users` (
  `user_id` int(11) NOT NULL UNIQUE AUTO_INCREMENT PRIMARY KEY,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_role` enum('Admin','User') NOT NULL DEFAULT 'User'
);

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`, `user_role`) VALUES
(0, 'noor', '2555042@stu.uob.edu.bh', '$2y$10$8p1pfWgbdX/eu2/jfpfSWOa.pkWHuUWcEw9rVp6Vo0uw8LEnhZ0Fi', 'User');