-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 27, 2020 at 06:02 AM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `proyekku.com`
--

-- --------------------------------------------------------

--
-- Table structure for table `division`
--

CREATE TABLE `division` (
  `id` int(11) NOT NULL,
  `idpt` int(11) NOT NULL,
  `division` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `division`
--

INSERT INTO `division` (`id`, `idpt`, `division`, `status`) VALUES
(1, 2, 'IT', ''),
(2, 2, 'Banking', ''),
(3, 2, 'Management', ''),
(4, 2, 'Fraud', ''),
(5, 2, 'Banking Div', 'soft_delete'),
(6, 3, 'Banking', '');

-- --------------------------------------------------------

--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'Super Admin'),
(2, 'Admin Perusahaan'),
(3, 'Admin Divisi'),
(4, 'User Divisi');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `idrole` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `idrole`, `name`, `username`, `password`, `status`) VALUES
(1, 1, 'madanz', 'madanzdanz@gmail.com', '202cb962ac59075b964b07152d234b70', 'active'),
(2, 2, 'harkiramadhan', 'harkiramadhan@gmail.com', '202cb962ac59075b964b07152d234b70', 'active'),
(3, 2, 'AHMAD HARKI RAMADHAN', 'osdqm13@gmail.com', '202cb962ac59075b964b07152d234b70', 'active');

-- --------------------------------------------------------

--
-- Table structure for table `userpt`
--

CREATE TABLE `userpt` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL,
  `idpt` int(11) NOT NULL,
  `idrole` int(11) NOT NULL,
  `iddiv` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `userpt`
--

INSERT INTO `userpt` (`id`, `name`, `username`, `password`, `status`, `idpt`, `idrole`, `iddiv`) VALUES
(1, 'AHMAD HARKI RAMADHAN', 'anuanu@gmail.com', '202cb962ac59075b964b07152d234b70', '', 2, 3, 2),
(2, 'ahmad harki', 'anu@gmail.com', '202cb962ac59075b964b07152d234b70', 'active', 2, 3, 2),
(3, 'anuannn', 'alvianrht@gmail.com', '202cb962ac59075b964b07152d234b70', 'active', 2, 4, 2),
(4, 'AHMAD HARKI RAMADHAN', 'ahmad.harki@unf.ac.id', '202cb962ac59075b964b07152d234b70', 'active', 2, 4, 2);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_FK` (`idrole`);

--
-- Indexes for table `userpt`
--
ALTER TABLE `userpt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userpt_FK` (`idrole`),
  ADD KEY `userpt_FK_1` (`iddiv`),
  ADD KEY `userpt_FK_2` (`idpt`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `userpt`
--
ALTER TABLE `userpt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_FK` FOREIGN KEY (`idrole`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `userpt`
--
ALTER TABLE `userpt`
  ADD CONSTRAINT `userpt_FK` FOREIGN KEY (`idrole`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userpt_FK_1` FOREIGN KEY (`iddiv`) REFERENCES `division` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userpt_FK_2` FOREIGN KEY (`idpt`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;