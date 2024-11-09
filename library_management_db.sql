-- noinspection SqlNoDataSourceInspectionForFile

-- noinspection SqlDialectInspectionForFile

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 05, 2024 at 07:20 AM
-- Server version: 8.3.0
-- PHP Version: 8.2.18

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
-- Table structure for table `books_table`
--

CREATE TABLE books_table (
  `id` int(11) NOT NULL,
  `book_name` varchar(250) NOT NULL,
  `isbnno` varchar(250) NOT NULL,
  `author` varchar(250) NOT NULL,
  `publisher` varchar(250) NOT NULL,
  `price` varchar(250) NOT NULL,
  `quantity` varchar(250) NOT NULL,
  `place` varchar(250) NOT NULL,
  `category` varchar(250) NOT NULL,
  `availability` tinyint(4) NOT NULL COMMENT '1=available, 0=not available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories_table`
--

CREATE TABLE categories_table (
  `id` int(11) NOT NULL,
  `category_name` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=active, 0=inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `issues_table`
--

CREATE TABLE issues_table (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `issue_date` varchar(250) NOT NULL,
  `due_date` varchar(250) NOT NULL,
  `status` varchar(250) NOT NULL DEFAULT '0' COMMENT '3=request sent, 1=accept, 2=reject',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `locations_table`
--

CREATE TABLE locations_table (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `status` tinyint(4) NOT NULL COMMENT '1=active, 0=inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `returns_table`
--

CREATE TABLE returns_table (
  `id` int(11) NOT NULL,
  `book_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `return_date` varchar(250) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users_table`
--

CREATE TABLE users_table (
  `id` int(11) NOT NULL,
  `user_name` varchar(250) NOT NULL,
  `email` varchar(250) NOT NULL,
  `password` varchar(250) NOT NULL,
  `role` tinyint(4) NOT NULL COMMENT '1=admin, 2=user',
  `status` tinyint(4) NOT NULL COMMENT '1=active, 0=inactive',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users_table`
--

INSERT INTO users_table (id, user_name, email, password, role, status, created_at) VALUES
-- Admin_user
(1, 'Admin', 'admin@library.com', md5('password'), 1, 1, NOW()),
-- Active_user
(3, 'User', 'user@library.com', md5('password'), 2, 1, NOW()),
-- Disabled_user
(2, 'User User', 'user@example.com', md5('password'), 2, 0, NOW());


--
-- Dumping data for table `books_table`
--

INSERT INTO books_table (id, book_name, isbnno, author, publisher, price, quantity, place, category, availability, created_at) VALUES
(1, '1984', '9780451524935', 'George Orwell', 'Secker & Warburg', '9.99', '100', 'London', 'Dystopian Fiction', 1, NOW()),
(2, 'To Kill a Mockingbird', '9780061120084', 'Harper Lee', 'J.B. Lippincott & Co.', '12.50', '150', 'New York City', 'Classic Fiction', 1, NOW()),
(3, 'The Great Gatsby', '9780743273565', 'F. Scott Fitzgerald', 'Charles Scribner''s Sons', '10.00', '200', 'East Egg', 'Modern Classic', 1, NOW()),
(4, 'Pride and Prejudice', '9781853260509', 'Jane Austen', 'Thomas Egerton', '8.99', '300', 'Longbourn', 'Romance', 1, NOW()),
(5, 'The Catcher in the Rye', '9780143039882', 'J.D. Salinger', 'Little, Brown and Company', '11.99', '250', 'Central Park West', 'Coming-of-Age', 1, NOW());

--
-- Dumping data for table `categories_table`
--

INSERT INTO categories_table (id, category_name, status, created_at) VALUES
(1, 'Fiction', 1, NOW()),
(2, 'Non-Fiction', 1, NOW()),
(3, 'Mystery', 1, NOW()),
(4, 'Romance', 1, NOW()),
(5, 'Science Fiction', 1, NOW()),
(6, 'Dystopian Fiction', 1, NOW()),
(7, 'Classic Fiction', 1, NOW()),
(8, 'Modern Classic', 1, NOW()),
(9, 'Coming-of-Age', 1, NOW());

--
-- Dumping data for table `locations_table`
--

INSERT INTO locations_table (id, name, status, created_at) VALUES
(1, 'Main Library', 1, NOW()),
(2, 'Branch Office', 1, NOW()),
(3, 'Bookstore', 1, NOW()),
(4, 'University Library', 1, NOW()),
(5, 'State Library', 1, NOW()),
(6, 'Community Center', 1, NOW());

--
-- Dumping data for table `issue_table`
--
INSERT INTO issues_table (id, book_id, user_id, user_name, status, issue_date, due_date, created_at) VALUES
(1, 1, 2, 'User User', 3, NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), NOW());

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books_table`
--
ALTER TABLE books_table
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `categories_table`
--
ALTER TABLE categories_table
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `issues_table`
--
ALTER TABLE issues_table
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `locations_table`
--
ALTER TABLE locations_table
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `returns_table`
--
ALTER TABLE returns_table
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users_table`
--
ALTER TABLE users_table
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `books_table`
--
ALTER TABLE books_table
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories_table`
--
ALTER TABLE categories_table
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `issues_table`
--
ALTER TABLE issues_table
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `locations_table`
--
ALTER TABLE locations_table
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `returns_table`
--
ALTER TABLE returns_table
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users_table`
--
ALTER TABLE users_table
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
