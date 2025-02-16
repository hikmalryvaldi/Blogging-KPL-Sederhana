-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 15, 2025 at 11:27 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tubes_kpl`
--

-- --------------------------------------------------------

--
-- Table structure for table `articles`
--

CREATE TABLE `articles` (
  `id` int(11) NOT NULL,
  `penulis` varchar(30) NOT NULL,
  `judul` varchar(30) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `artikel_text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `users_id` int(11) DEFAULT NULL,
  `aksi` enum('public','private') DEFAULT 'public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `articles`
--

INSERT INTO `articles` (`id`, `penulis`, `judul`, `gambar`, `artikel_text`, `created_at`, `users_id`, `aksi`) VALUES
(1, 'Hikmal Ryvaldi', 'Blogging', 'Screenshot 2025-02-13 130737.png', 'PHP 8.4 is a major update of the PHP language.\r\nIt contains many new features, such as property hooks, asymmetric visibility, an updated DOM API, performance improvements, bug fixes, and general cleanup.', '2025-02-12 19:36:03', NULL, 'public'),
(3, 'hikmal', 'Bangun pagi', 'Screenshot 2025-02-13 130737.png', 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Numquam repudiandae voluptatibus corrupti quisquam iure doloremque impedit cupiditate, facere animi dicta quibusdam. Quis similique quibusdam commodi eligendi laboriosam laudantium necessitatibus blanditiis, quasi quo sed esse dolorum est amet ullam animi repellendus?', '2025-02-13 07:14:25', NULL, 'public'),
(6, 'ojan', 'Kedai DIens', 'images.png', 'makanmakanmakanmakanmakanmakanmakan', '2025-02-13 07:17:10', NULL, 'public'),
(10, 'novan', 'ambatukam', 'Screenshot 2025-02-13 130737.png', 'penghitaman', '2025-02-13 11:09:51', NULL, 'public'),
(12, 'Hikmal', 'PHP', 'Screenshot 2025-02-13 130737.png', 'A popular general-purpose scripting language that is especially suited to web development. Fast, flexible and pragmatic, PHP powers everything from your blog to the most popular websites in the world.', '2025-02-13 13:37:06', NULL, 'public'),
(13, 'as', 'dasd', 'Screenshot 2025-02-13 130737.png', 'asdasd', '2025-02-13 13:51:22', NULL, 'public'),
(15, 'kelompok KPL', 'TUBES KELOMPOK', 'download.jpg', 'KPL merupakan salah satu matakuliah pada Program Studi Kependidikan yang memberikan wawasan dan pengalaman praktis di sekolah dan lembaga pendidikan mitra kepada mahasiswa Program Sarjana (S1) Kependidikan.', '2025-02-13 16:07:47', NULL, 'public'),
(17, 'Nton', 'PHP', 'download.jpg', 'PHP merupakan singkatan dari PHP : Hypertext Preprocessor adalah salah satu Bahasa scripting open source yang banyak digunakan oleh Web Developer untuk pengembangan Web. PHP banyak digunakan untuk membuat banyak project seperti Grafik Antarmuka (GUI), Website Dinamis, dan lain-lain.', '2025-02-15 16:30:20', NULL, 'public'),
(18, 'Brendan Eich', 'javascript', 'Screenshot 2025-02-15 220605.png', 'JavaScript adalah bahasa pemrograman yang digunakan developer untuk membuat halaman web yang interaktif. Dari menyegarkan umpan media sosial hingga menampilkan animasi dan peta interaktif, fungsi JavaScript dapat meningkatkan pengalaman pengguna situs web. Sebagai bahasa skrip sisi klien, JavaScript adalah salah satu teknologi inti dari World Wide Web. Misalnya, saat menjelajah internet, kapan pun Anda melihat carousel gambar, menu tarik-turun klik untuk menampilkan, atau warna elemen yang berubah secara dinamis di halaman web, Anda melihat efek JavaScript.', '2025-02-15 22:06:19', NULL, 'public');

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `comment_text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `users_id` int(11) DEFAULT NULL,
  `article_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `comments`
--

INSERT INTO `comments` (`id`, `username`, `comment_text`, `created_at`, `users_id`, `article_id`) VALUES
(1, 'hikmal', 'ini adalah komen saya', '2025-02-12 19:20:06', NULL, 0),
(2, 'putera26', 'adwaw', '2025-02-13 13:20:37', NULL, 1),
(3, 'dwi_putera_26', 'awd', '2025-02-13 13:20:42', NULL, 1),
(4, 'awd', 'awdawd', '2025-02-13 13:20:54', NULL, 3),
(5, 'hikmal', 'nice', '2025-02-13 13:52:49', NULL, 13),
(6, 'boleh', 'tes', '2025-02-13 15:05:50', NULL, 9);

-- --------------------------------------------------------

--
-- Table structure for table `histories`
--

CREATE TABLE `histories` (
  `id` int(11) NOT NULL,
  `judul` varchar(30) NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `artikel_text` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `articles_id` int(11) DEFAULT NULL,
  `aksi` enum('public','private') DEFAULT 'public'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `histories`
--

INSERT INTO `histories` (`id`, `judul`, `gambar`, `artikel_text`, `created_at`, `articles_id`, `aksi`) VALUES
(35, 'PHP', 'download.jpg', 'PHP merupakan singkatan dari PHP : Hypertext Preprocessor adalah salah satu Bahasa scripting open source yang banyak digunakan oleh Web Developer untuk pengembangan Web. PHP banyak digunakan untuk membuat banyak project seperti Grafik Antarmuka (GUI), Website Dinamis, dan lain-lain.', '2025-02-15 22:03:59', 17, 'private'),
(36, 'TUBES KELOMPOK', 'download.jpg', 'KPL merupakan salah satu matakuliah pada Program Studi Kependidikan yang memberikan wawasan dan pengalaman praktis di sekolah dan lembaga pendidikan mitra kepada mahasiswa Program Sarjana (S1) Kependidikan.', '2025-02-15 22:04:10', 15, 'public'),
(37, 'Kedai DIens', 'images.png', 'makanmakanmakanmakanmakanmakanmakan', '2025-02-15 22:04:18', 6, 'public'),
(38, 'Kedai DIens', 'images.png', 'makanmakanmakanmakanmakanmakanmakan', '2025-02-15 22:04:35', 6, 'private'),
(39, 'TUBES KELOMPOK', 'download.jpg', 'KPL merupakan salah satu matakuliah pada Program Studi Kependidikan yang memberikan wawasan dan pengalaman praktis di sekolah dan lembaga pendidikan mitra kepada mahasiswa Program Sarjana (S1) Kependidikan.', '2025-02-15 22:04:50', 15, 'private');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `pwd` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `pwd`, `email`, `created_at`) VALUES
(17, 'Hikmal', '$2y$12$EBlg5dNLYdCYm60ot3c8uOcCDzKdWwAwAauxomQK.N.PbUF.n.4rW', 'hikmal@hello.co', '2025-02-15 22:20:41');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `users_id` (`users_id`);

--
-- Indexes for table `histories`
--
ALTER TABLE `histories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `articles_id` (`articles_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `articles`
--
ALTER TABLE `articles`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `histories`
--
ALTER TABLE `histories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `articles`
--
ALTER TABLE `articles`
  ADD CONSTRAINT `articles_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`users_id`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `histories`
--
ALTER TABLE `histories`
  ADD CONSTRAINT `histories_ibfk_1` FOREIGN KEY (`articles_id`) REFERENCES `articles` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
