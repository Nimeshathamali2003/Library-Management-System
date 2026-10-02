-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 02, 2026 at 08:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library_management_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` int(11) NOT NULL,
  `title` varchar(150) NOT NULL,
  `author` varchar(100) NOT NULL,
  `category_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL DEFAULT 0,
  `status` varchar(20) DEFAULT 'Good'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `category_id`, `quantity`, `status`) VALUES
(1, 'The Alchemist', 'Paulo Coelho', 1, 5, 'Damaged'),
(2, 'Atomic Habits', 'James Clear', 16, 6, 'Good'),
(3, 'Sapiens', 'Yuval Noah Harari', 3, 4, 'Good'),
(4, 'The Great Gatsby', 'F. Scott Fitzgerald', 1, 5, 'Good'),
(5, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 5, 12, 'Good'),
(6, 'The Da Vinci Code', 'Dan Brown', 6, 7, 'Good'),
(7, 'Think and Grow Rich', 'Napoleon Hill', 16, 2, 'Good'),
(8, 'Rich Dad Poor Dad', 'Robert Kiyosaki', 38, 10, 'Good'),
(9, 'The Power of Now', 'Eckhart Tolle', 15, 4, 'Good'),
(10, 'To Kill a Mockingbird', 'Harper Lee', 1, 9, 'Good'),
(11, 'The Catcher in the Rye', 'J.D. Salinger', 1, 3, 'Good'),
(12, 'Pride and Prejudice', 'Jane Austen', 8, 7, 'Good'),
(13, '1984', 'George Orwell', 5, 6, 'Damaged'),
(14, 'The Hobbit', 'J.R.R. Tolkien', 5, 8, 'Good'),
(15, 'Fahrenheit 451', 'Ray Bradbury', 5, 3, 'Good'),
(16, 'The Shining', 'Stephen King', 10, 5, 'Good'),
(17, 'Gone Girl', 'Gillian Flynn', 9, 4, 'Good'),
(18, 'The Silent Patient', 'Alex Michaelides', 9, 6, 'Good'),
(19, 'Educated', 'Tara Westover', 7, 4, 'Damaged'),
(20, 'Becoming', 'Michelle Obama', 7, 5, 'Good'),
(21, 'The Art of War', 'Sun Tzu', 4, 9, 'Good'),
(22, 'Meditations', 'Marcus Aurelius', 14, 7, 'Good'),
(23, 'The Subtle Art of Not Giving a F*ck', 'Mark Manson', 16, 8, 'Good'),
(24, 'Can\'t Hurt Me', 'David Goggins', 16, 5, 'Good'),
(25, 'The 7 Habits of Highly Effective People', 'Stephen Covey', 16, 10, 'Good'),
(26, 'The Psychology of Money', 'Morgan Housel', 15, 6, 'Good'),
(27, 'Thinking, Fast and Slow', 'Daniel Kahneman', 15, 2, 'Good'),
(28, 'The Book Thief', 'Markus Zusak', 5, 3, 'Good'),
(29, 'The Kite Runner', 'Khaled Hosseini', 1, 5, 'Good'),
(30, 'A Thousand Splendid Suns', 'Khaled Hosseini', 1, 6, 'Good'),
(31, 'The Hunger Games', 'Suzanne Collins', 5, 7, 'Good'),
(32, 'Divergent', 'Veronica Roth', 5, 8, 'Good'),
(33, 'Twilight', 'Stephenie Meyer', 8, 9, 'Good'),
(34, 'The Notebook', 'Nicholas Sparks', 8, 4, 'Good'),
(35, 'The Time Traveler\'s Wife', 'Audrey Niffenegger', 8, 3, 'Good'),
(36, 'The Road', 'Cormac McCarthy', 5, 6, 'Good'),
(37, 'The Handmaid\'s Tale', 'Margaret Atwood', 5, 5, 'Good'),
(38, 'The Fault in Our Stars', 'John Green', 8, 7, 'Good'),
(39, 'Looking for Alaska', 'John Green', 8, 6, 'Good'),
(40, 'Paper Towns', 'John Green', 8, 5, 'Good'),
(41, 'Percy Jackson: The Lightning Thief', 'Rick Riordan', 5, 9, 'Good'),
(42, 'The Maze Runner', 'James Dashner', 5, 7, 'Good'),
(43, 'The Giver', 'Lois Lowry', 5, 5, 'Good'),
(44, 'The Four Agreements', 'Don Miguel Ruiz', 16, 4, 'Good'),
(45, 'The Power of Habit', 'Charles Duhigg', 16, 11, 'Good'),
(46, 'Outliers', 'Malcolm Gladwell', 15, 6, 'Good'),
(47, 'Blink', 'Malcolm Gladwell', 15, 6, 'Good'),
(48, 'The Tipping Point', 'Malcolm Gladwell', 15, 8, 'Good'),
(49, 'The World Is Flat', 'Thomas Friedman', 3, 3, 'Good'),
(50, 'madolduwa', 'matinwichamasinha', 34, 11, 'Good'),
(51, 'Beddegama', 'A.P.Gunarathna', 1, 15, 'Good'),
(52, 'Harry Potter and the Philosopher\'s Stone', 'J.K. Rowling', 1, 10, 'Good'),
(53, 'Yuganthaya', 'matinwichamasinha', 1, 9, 'Good'),
(54, 'Kaliyugaya', 'matinwichamasinha', 1, 10, 'Good'),
(55, 'Gamperaliya', 'matinwichamasinha', 1, 3, 'Good'),
(56, 'Gamperaliya', 'matinwichamasinha', 1, 4, 'Good'),
(57, 'Sudu Duwa', 'Paulo Coelho', 8, 5, 'Good'),
(58, 'Ape Lokaya', 'J.K. Rowling', 5, 4, 'Good'),
(59, 'Lassana Baba', 'J.K. Rowling', 13, 6, 'Good'),
(60, 'The Silent Patient', 'Alex Michaelides ', 6, 5, 'Good'),
(61, 'Don Miguel Ruiz', 'Self-Help', 16, 9, 'Good'),
(62, 'Nimanthara', 'Paulo Coelho', 17, 5, 'Good'),
(63, 'Nangii', 'J.K. Rowling', 16, 4, 'Good'),
(64, 'Nelawilla', 'matinwichamasinha', 20, 6, 'Good'),
(65, 'Ape Amma', 'A.P.Gunarathna', 5, 2, 'Good'),
(66, 'Loku Sir', 'Alex Michaelides ', 12, 6, 'Good'),
(67, 'Ran Tetiyaka Kadulu', 'matinwichamasinha', 8, 5, 'Good'),
(68, 'nime', 'matinwichamasinha', 18, 5, 'Good'),
(69, 'The Alchemist', 'Paulo Coelho', 1, 2, 'Good'),
(70, 'ABC', 'EXAV', 16, 2147483647, 'Good');

-- --------------------------------------------------------

--
-- Table structure for table `borrow`
--

CREATE TABLE `borrow` (
  `borrow_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `borrow`
--

INSERT INTO `borrow` (`borrow_id`, `user_id`, `book_id`, `borrow_date`, `return_date`, `status`) VALUES
(1, 2, 1, '2026-07-08', '2026-07-08', 'Returned'),
(2, 2, 5, '2026-06-28', '2026-07-15', 'Returned'),
(3, 56, 1, '2026-07-08', '2026-09-22', 'Returned'),
(4, 2, 1, '2026-07-10', NULL, 'Borrowed'),
(5, 2, 50, '2026-06-28', '2026-09-23', 'Returned'),
(6, 2, 43, '2026-07-02', '2026-07-10', 'Returned'),
(7, 2, 47, '2026-07-01', '2026-07-10', 'Returned'),
(8, 2, 42, '2026-07-11', NULL, 'Borrowed'),
(9, 2, 45, '2026-07-11', '2026-07-11', 'Returned'),
(10, 7, 27, '2026-07-13', NULL, 'Borrowed'),
(11, 7, 27, '2026-07-13', NULL, 'Borrowed'),
(12, 2, 1, '2026-07-14', NULL, 'Borrowed'),
(13, 1, 36, '2026-07-14', '2026-07-15', 'Returned'),
(14, 2, 1, '2026-07-15', NULL, 'Borrowed'),
(15, 2, 1, '2026-07-15', NULL, 'Borrowed'),
(16, 2, 2, '2026-07-15', NULL, 'Borrowed'),
(17, 2, 2, '2026-07-15', NULL, 'Borrowed'),
(18, 2, 3, '2026-07-15', NULL, 'Borrowed'),
(19, 2, 3, '2026-07-15', NULL, 'Borrowed'),
(20, 2, 4, '2026-07-15', NULL, 'Borrowed'),
(21, 2, 4, '2026-07-15', NULL, 'Borrowed'),
(22, 2, 5, '2026-07-15', NULL, 'Borrowed'),
(23, 2, 5, '2026-07-15', NULL, 'Borrowed'),
(24, 1, 7, '2026-07-15', NULL, 'Borrowed'),
(25, 7, 6, '2026-07-15', '2026-07-15', 'Returned'),
(26, 54, 11, '2026-07-15', NULL, 'Borrowed'),
(27, 7, 55, '2026-07-15', NULL, 'Borrowed'),
(28, 3, 55, '2026-07-15', NULL, 'Borrowed'),
(29, 7, 56, '2026-07-15', NULL, 'Borrowed'),
(30, 3, 53, '2026-07-15', '2026-09-22', 'Returned'),
(31, 3, 57, '2026-07-15', NULL, 'Borrowed'),
(32, 8, 58, '2026-07-15', NULL, 'Borrowed'),
(33, 12, 59, '2026-07-15', NULL, 'Borrowed'),
(34, 6, 9, '2026-07-20', NULL, 'Borrowed'),
(35, 15, 61, '2026-07-20', NULL, 'Borrowed'),
(37, 55, 41, '2026-07-21', NULL, 'Borrowed'),
(38, 8, 58, '2026-09-14', NULL, 'Borrowed'),
(39, 58, 68, '2026-09-23', '2026-09-23', 'Returned'),
(40, 58, 68, '2026-09-23', '2026-09-23', 'Returned'),
(41, 58, 68, '2026-09-23', '2026-09-23', 'Returned');

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`category_id`, `category_name`) VALUES
(1, 'Fiction'),
(2, 'Non-Fiction'),
(3, 'Science'),
(4, 'History'),
(5, 'Fantasy'),
(6, 'Mystery'),
(7, 'Biography'),
(8, 'Romance'),
(9, 'Thriller'),
(10, 'Horror'),
(11, 'Adventure'),
(12, 'Comedy'),
(13, 'Drama'),
(14, 'Philosophy'),
(15, 'Psychology'),
(16, 'Self-Help'),
(17, 'Cooking'),
(18, 'Travel'),
(19, 'Art'),
(20, 'Music'),
(21, 'Poetry'),
(22, 'Religion'),
(23, 'Politics'),
(24, 'Economics'),
(25, 'Mathematics'),
(26, 'Physics'),
(27, 'Chemistry'),
(28, 'Biology'),
(29, 'Astronomy'),
(30, 'Geography'),
(31, 'Engineering'),
(32, 'Medicine'),
(33, 'Law'),
(34, 'Education'),
(35, 'Sports'),
(36, 'Gardening'),
(37, 'Parenting'),
(38, 'Business'),
(39, 'Marketing'),
(40, 'Finance'),
(41, 'Computer Science'),
(42, 'AI & ML'),
(43, 'Data Science'),
(44, 'Robotics'),
(45, 'Cybersecurity'),
(46, 'Networking'),
(47, 'Operating Systems'),
(48, 'Database'),
(49, 'Web Dev'),
(50, 'Mobile Dev'),
(51, 'Fiction'),
(52, 'Non-Fiction'),
(53, 'Science'),
(54, 'History'),
(55, 'Fantasy'),
(56, 'Mystery'),
(57, 'Biography'),
(58, 'Romance'),
(59, 'Thriller'),
(60, 'Horror'),
(61, 'Adventure'),
(62, 'Comedy'),
(63, 'Drama'),
(64, 'Philosophy'),
(65, 'Psychology'),
(66, 'Self-Help'),
(67, 'Cooking'),
(68, 'Travel'),
(69, 'Art'),
(70, 'Music'),
(71, 'Poetry'),
(72, 'Religion'),
(73, 'Politics'),
(74, 'Economics'),
(75, 'Mathematics'),
(76, 'Physics'),
(77, 'Chemistry'),
(78, 'Biology'),
(79, 'Astronomy'),
(80, 'Geography'),
(81, 'Engineering'),
(82, 'Medicine'),
(83, 'Law'),
(84, 'Education'),
(85, 'Sports'),
(86, 'Gardening'),
(87, 'Parenting'),
(88, 'Business'),
(89, 'Marketing'),
(90, 'Finance'),
(91, 'Computer Science'),
(92, 'AI & ML'),
(93, 'Data Science'),
(94, 'Robotics'),
(95, 'Cybersecurity'),
(96, 'Networking'),
(97, 'Operating Systems'),
(98, 'Database'),
(99, 'Web Dev'),
(100, 'Mobile Dev'),
(101, 'Fiction'),
(102, 'Non-Fiction'),
(103, 'Science'),
(104, 'History'),
(105, 'Fantasy'),
(106, 'Mystery'),
(107, 'Biography'),
(108, 'Romance'),
(109, 'Thriller'),
(110, 'Horror');

-- --------------------------------------------------------

--
-- Table structure for table `fine`
--

CREATE TABLE `fine` (
  `fine_id` int(11) NOT NULL,
  `borrow_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `status` varchar(20) DEFAULT 'Unpaid'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fine`
--

INSERT INTO `fine` (`fine_id`, `borrow_id`, `amount`, `status`) VALUES
(38, 1, 0.00, 'Unpaid'),
(39, 2, 300.00, 'Paid'),
(40, 4, 0.00, 'Unpaid'),
(41, 5, 300.00, 'Unpaid'),
(42, 6, 50.00, 'Unpaid'),
(43, 7, 100.00, 'Unpaid'),
(44, 8, 0.00, 'Unpaid'),
(45, 3, 0.00, 'Paid');

-- --------------------------------------------------------

--
-- Table structure for table `reservation`
--

CREATE TABLE `reservation` (
  `reservation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `reservation_date` date NOT NULL,
  `status` varchar(20) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `reservation`
--

INSERT INTO `reservation` (`reservation_id`, `user_id`, `book_id`, `reservation_date`, `status`) VALUES
(158, 56, 2, '2026-07-08', 'Completed'),
(160, 55, 41, '2026-07-11', 'Pending'),
(162, 1, 1, '2026-07-15', 'Pending'),
(163, 6, 9, '2026-07-15', 'Completed'),
(164, 3, 1, '2026-07-15', 'Pending'),
(165, 4, 57, '2026-07-15', 'Expired'),
(166, 8, 58, '2026-07-15', 'Completed'),
(168, 8, 58, '2026-07-10', 'Completed'),
(170, 12, 46, '2026-07-23', 'Pending'),
(171, 16, 60, '2026-09-14', 'Pending'),
(172, 17, 61, '2026-09-14', 'Pending'),
(173, 53, 49, '2026-09-14', 'Pending'),
(174, 2, 48, '2026-09-15', 'Pending'),
(175, 15, 67, '2026-09-22', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` varchar(50) NOT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `role`, `password`) VALUES
(1, 'System Admin', 'admin@library.com', 'Admin', 'admin123'),
(2, 'Test Member', 'member@library.com', 'Member', 'member123'),
(3, 'Saman Perera', 'saman@gmail.com', 'Member', '123456'),
(4, 'Nimal Fernando', 'nimal@yahoo.com', 'Member', '123456'),
(5, 'Kumari Silva', 'kumari@hotmail.com', 'Librarian', '123456'),
(6, 'Asanka Rathnayake', 'asanka@gmail.com', 'Member', '123456'),
(7, 'Chaminda Bandara', 'chaminda@gmail.com', 'Member', '123456'),
(8, 'Nuwan Jayawardena', 'nuwan@yahoo.com', 'Member', '123456'),
(9, 'Malith Karunaratne', 'malith@gmail.com', 'Member', '123456'),
(10, 'Thilini Gamage', 'thilini@hotmail.com', 'Librarian', '123456'),
(11, 'Nishantha Kumara', 'nishantha@gmail.com', 'Member', '123456'),
(12, 'Lakshmi Menon', 'lakshmi@gmail.com', 'Member', '123456'),
(13, 'Amal Wijesinghe', 'amal@gmail.com', 'Member', '123456'),
(14, 'Sajith Premadasa', 'sajith@gmail.com', 'Member', '123456'),
(15, 'Tharindu Dissanayake', 'tharindu@yahoo.com', 'Member', '123456'),
(16, 'Sanduni Wickramasinghe', 'sanduni@gmail.com', 'Member', '123456'),
(17, 'Anura Silva', 'anura@gmail.com', 'Member', '123456'),
(18, 'Madushani Perera', 'madushani@gmail.com', 'Member', '123456'),
(19, 'Niroshan Fernando', 'niroshan@gmail.com', 'Member', '123456'),
(20, 'Dilshan Cooray', 'dilshan@gmail.com', 'Member', '123456'),
(21, 'Nayana Kumari', 'nayana@gmail.com', 'Member', '123456'),
(22, 'Ruwan Wickramasinghe', 'ruwan@gmail.com', 'Member', '123456'),
(23, 'Samantha Rathnayake', 'samantha@gmail.com', 'Member', '123456'),
(24, 'Nadeeka Perera', 'nadeeka@gmail.com', 'Member', '123456'),
(25, 'Gihan Silva', 'gihan@gmail.com', 'Member', '123456'),
(26, 'Mihiri Madushanka', 'mihiri@gmail.com', 'Member', '123456'),
(27, 'Chamara Bandara', 'chamara@gmail.com', 'Member', '123456'),
(28, 'Upul Kumara', 'upul@gmail.com', 'Member', '123456'),
(29, 'Harshana Weerasinghe', 'harshana@gmail.com', 'Member', '123456'),
(30, 'Shanika De Silva', 'shanika@gmail.com', 'Member', '123456'),
(31, 'Lalith Jayasuriya', 'lalith@gmail.com', 'Member', '123456'),
(32, 'Priya Rajapaksa', 'priya@gmail.com', 'Member', '123456'),
(33, 'Samudra Wijesooriya', 'samudra@gmail.com', 'Member', '123456'),
(34, 'Hirunika Perera', 'hirunika@gmail.com', 'Member', '123456'),
(35, 'Thushara Samaraweera', 'thushara@gmail.com', 'Member', '123456'),
(36, 'Pradeep Kumara', 'pradeep@gmail.com', 'Member', '123456'),
(37, 'Nishadhi Ranasinghe', 'nishadhi@gmail.com', 'Member', '123456'),
(38, 'Dhanushka Madushanka', 'dhanushka@gmail.com', 'Member', '123456'),
(39, 'Geetha Samarasekara', 'geetha@gmail.com', 'Member', '123456'),
(40, 'Mahesh Perera', 'mahesh@gmail.com', 'Member', '123456'),
(41, 'Sachini Gamage', 'sachini@gmail.com', 'Member', '123456'),
(42, 'Rohan Silva', 'rohan@gmail.com', 'Member', '123456'),
(43, 'Dilini Wickramasinghe', 'dilini@gmail.com', 'Member', '123456'),
(44, 'Nuwanthi Edirisinghe', 'nuwanthi@gmail.com', 'Member', '123456'),
(45, 'Hasitha Abeykoon', 'hasitha@gmail.com', 'Member', '123456'),
(46, 'Tharushi Samaraweera', 'tharushi@gmail.com', 'Member', '123456'),
(47, 'Chathura Bandara', 'chathura@gmail.com', 'Member', '123456'),
(48, 'Ashani Silva', 'ashani@gmail.com', 'Member', '123456'),
(49, 'Madhuka Fernando', 'madhuka@gmail.com', 'Member', '123456'),
(50, 'Sandun Perera', 'sandun@gmail.com', 'Member', '123456'),
(51, 'Ravindu Rathnayake', 'ravindu@gmail.com', 'Member', '123456'),
(52, 'Nethmini Wijesinghe', 'nethmini@gmail.com', 'Member', '123456'),
(53, 'nimesha thamali', 'nimeshathamali151@gmail.com', 'Member', 'madu1234'),
(54, 'Shashira Nishmi', 'sashira1@gmail.com', 'Member', 'sashira123'),
(55, 'Nuwan Perera', 'nuwan@gmail.com', 'Member', '123456'),
(56, 'lakindu yomal', 'lakindu2@gmail.com', 'Member', '123456'),
(57, 'A.L.TAlataf', 'althaf12@gmail.com', 'Member', '123456'),
(58, 'NEMASHA', 'nemasha3@gmail.com', 'Member', '123456'),
(59, 'ABC', 'abc@library.com', 'Member', '123456'),
(60, 'BCD', 'bcd@library.com', 'Member', 'admin123'),
(61, 'DEF', 'def@library.com', 'Member', '123456');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`borrow_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `fine`
--
ALTER TABLE `fine`
  ADD PRIMARY KEY (`fine_id`),
  ADD KEY `borrow_id` (`borrow_id`);

--
-- Indexes for table `reservation`
--
ALTER TABLE `reservation`
  ADD PRIMARY KEY (`reservation_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `book_id` (`book_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `book_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=71;

--
-- AUTO_INCREMENT for table `borrow`
--
ALTER TABLE `borrow`
  MODIFY `borrow_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `fine`
--
ALTER TABLE `fine`
  MODIFY `fine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `reservation`
--
ALTER TABLE `reservation`
  MODIFY `reservation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=176;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `books`
--
ALTER TABLE `books`
  ADD CONSTRAINT `books_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `category` (`category_id`) ON DELETE CASCADE;

--
-- Constraints for table `borrow`
--
ALTER TABLE `borrow`
  ADD CONSTRAINT `borrow_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `borrow_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;

--
-- Constraints for table `fine`
--
ALTER TABLE `fine`
  ADD CONSTRAINT `fine_ibfk_1` FOREIGN KEY (`borrow_id`) REFERENCES `borrow` (`borrow_id`) ON DELETE CASCADE;

--
-- Constraints for table `reservation`
--
ALTER TABLE `reservation`
  ADD CONSTRAINT `reservation_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `reservation_ibfk_2` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
