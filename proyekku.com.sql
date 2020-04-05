-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 06 Apr 2020 pada 00.26
-- Versi server: 10.1.37-MariaDB
-- Versi PHP: 7.2.12

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
-- Struktur dari tabel `division`
--

CREATE TABLE `division` (
  `id` int(11) NOT NULL,
  `idpt` int(11) NOT NULL,
  `division` varchar(255) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `division`
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
-- Struktur dari tabel `project`
--

CREATE TABLE `project` (
  `id` int(11) NOT NULL,
  `idpt` int(11) NOT NULL,
  `iddiv` int(11) NOT NULL,
  `project_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `project`
--

INSERT INTO `project` (`id`, `idpt`, `iddiv`, `project_name`) VALUES
(1, 2, 1, 'Web Project'),
(3, 2, 1, 'Android Project'),
(4, 2, 2, 'rrrr');

-- --------------------------------------------------------

--
-- Struktur dari tabel `role`
--

CREATE TABLE `role` (
  `id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `role`
--

INSERT INTO `role` (`id`, `role`) VALUES
(1, 'Super Admin'),
(2, 'Admin Perusahaan'),
(3, 'Admin Divisi'),
(4, 'User Divisi');

-- --------------------------------------------------------

--
-- Struktur dari tabel `task`
--

CREATE TABLE `task` (
  `id` int(11) NOT NULL,
  `idpt` int(11) NOT NULL,
  `iddiv` int(11) NOT NULL,
  `idproject` int(11) NOT NULL,
  `pic` int(11) NOT NULL,
  `name` text NOT NULL,
  `actualStart` datetime NOT NULL,
  `actualEnd` datetime NOT NULL,
  `parent` int(11) NOT NULL DEFAULT '0',
  `progressValue` varchar(255) NOT NULL DEFAULT '0%',
  `connectTo` varchar(255) NOT NULL,
  `connectorType` varchar(255) NOT NULL,
  `status` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `task`
--

INSERT INTO `task` (`id`, `idpt`, `iddiv`, `idproject`, `pic`, `name`, `actualStart`, `actualEnd`, `parent`, `progressValue`, `connectTo`, `connectorType`, `status`, `timestamp`) VALUES
(4, 2, 1, 1, 3, 'Backend Coding', '2020-04-01 10:34:06', '2020-04-04 10:34:06', 0, '60%', '', '', '', '2020-04-04 12:06:16'),
(7, 2, 1, 1, 4, 'Mockup Design', '2020-04-12 00:00:00', '2020-04-14 00:00:00', 6, '10%', '8', 'finish-start', '', '2020-04-03 19:26:42'),
(8, 2, 1, 1, 3, 'Testing Web', '2020-04-04 13:46:00', '2020-04-07 13:46:00', 7, '40%', '9', 'finish-start', '', '2020-04-04 07:39:15'),
(9, 2, 1, 1, 1, 'Database ', '2020-04-08 06:13:28', '2020-04-10 22:11:53', 4, '36%', '14', 'finish-finish', 'Done', '2020-04-04 11:59:50'),
(13, 2, 1, 1, 2, 'test', '2020-04-04 14:58:26', '2020-04-14 16:58:26', 0, '72%', '', '', 'Done', '2020-04-04 11:59:46'),
(14, 2, 1, 1, 3, 'Frontend Coding', '2020-04-04 13:56:00', '2020-04-04 13:56:00', 0, '0%', '13', 'start-start', '', '2020-04-04 07:43:54'),
(15, 2, 1, 1, 5, 'Pentesting', '2020-04-06 13:46:00', '2020-04-07 13:46:00', 8, '40%', '', '', 'Done', '2020-04-05 20:13:24'),
(17, 2, 1, 1, 5, 'Wireframe Design', '2020-04-06 02:55:00', '2020-04-06 02:56:00', 0, '80%', '', '', '', '2020-04-05 20:14:11'),
(18, 2, 1, 3, 5, 'Wireframe Design', '2020-04-06 02:57:00', '2020-04-06 02:57:00', 0, '0%', '', '', '', '2020-04-05 19:57:11'),
(20, 2, 1, 1, 5, 'Blackbox Testing', '2020-04-06 13:46:00', '2020-04-07 13:46:00', 15, '0%', '', '', '', '2020-04-05 20:43:00'),
(22, 2, 1, 3, 5, 'Mockup Design', '2020-04-07 03:52:00', '2020-04-15 03:52:00', 0, '0%', '', '', '', '2020-04-05 20:52:32'),
(23, 2, 1, 3, 5, 'Design layout', '2020-04-07 04:20:00', '2020-04-10 05:04:00', 22, '80%', '', '', '', '2020-04-05 20:59:42'),
(24, 2, 1, 3, 5, 'Coret Coret ', '2020-04-07 03:52:00', '2020-04-08 03:52:00', 23, '80%', '25', 'finish-start', '', '2020-04-05 20:56:52'),
(25, 2, 1, 3, 5, 'Adobe Illustrator', '2020-04-08 14:53:26', '2020-04-09 14:53:26', 23, '60%', '', '', '', '2020-04-05 20:57:09');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
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
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `idrole`, `name`, `username`, `password`, `status`) VALUES
(1, 1, 'madanz', 'madanzdanz@gmail.com', '202cb962ac59075b964b07152d234b70', 'active'),
(2, 2, 'harkiramadhan', 'harkiramadhan@gmail.com', '202cb962ac59075b964b07152d234b70', 'active'),
(3, 2, 'AHMAD HARKI RAMADHAN', 'osdqm13@gmail.com', '202cb962ac59075b964b07152d234b70', 'active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `userpt`
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
-- Dumping data untuk tabel `userpt`
--

INSERT INTO `userpt` (`id`, `name`, `username`, `password`, `status`, `idpt`, `idrole`, `iddiv`) VALUES
(1, 'AHMAD HARKI RAMADHAN', 'anuanu@gmail.com', '202cb962ac59075b964b07152d234b70', '', 2, 3, 1),
(2, 'ahmad harki', 'anu@gmail.com', '202cb962ac59075b964b07152d234b70', 'active', 2, 3, 1),
(3, 'anuannn', 'alvianrht@gmail.com', '202cb962ac59075b964b07152d234b70', 'active', 2, 4, 2),
(4, 'AHMAD HARKI RAMADHAN', 'ahmad.harki@unf.ac.id', '202cb962ac59075b964b07152d234b70', 'active', 2, 4, 2),
(5, 'ahmad harki', 'web@web.com', '202cb962ac59075b964b07152d234b70', 'active', 2, 4, 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `division`
--
ALTER TABLE `division`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idpt` (`idpt`);

--
-- Indeks untuk tabel `project`
--
ALTER TABLE `project`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iddiv` (`iddiv`),
  ADD KEY `idpt` (`idpt`);

--
-- Indeks untuk tabel `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD KEY `iddiv` (`iddiv`),
  ADD KEY `task_ibfk_2` (`idproject`),
  ADD KEY `task_ibfk_3` (`idpt`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_FK` (`idrole`);

--
-- Indeks untuk tabel `userpt`
--
ALTER TABLE `userpt`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userpt_FK` (`idrole`),
  ADD KEY `userpt_FK_1` (`iddiv`),
  ADD KEY `userpt_FK_2` (`idpt`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `division`
--
ALTER TABLE `division`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `project`
--
ALTER TABLE `project`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `userpt`
--
ALTER TABLE `userpt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `division`
--
ALTER TABLE `division`
  ADD CONSTRAINT `division_ibfk_1` FOREIGN KEY (`idpt`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `project`
--
ALTER TABLE `project`
  ADD CONSTRAINT `project_ibfk_1` FOREIGN KEY (`iddiv`) REFERENCES `division` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `project_ibfk_2` FOREIGN KEY (`idpt`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`iddiv`) REFERENCES `division` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_2` FOREIGN KEY (`idproject`) REFERENCES `project` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `task_ibfk_3` FOREIGN KEY (`idpt`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_FK` FOREIGN KEY (`idrole`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `userpt`
--
ALTER TABLE `userpt`
  ADD CONSTRAINT `userpt_FK` FOREIGN KEY (`idrole`) REFERENCES `role` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userpt_FK_1` FOREIGN KEY (`iddiv`) REFERENCES `division` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userpt_FK_2` FOREIGN KEY (`idpt`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
