-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1
-- Üretim Zamanı: 19 Ara 2025, 09:30:21
-- Sunucu sürümü: 10.4.32-MariaDB
-- PHP Sürümü: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `gourmet_db`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `recipes`
--

CREATE TABLE `recipes` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `content` text NOT NULL,
  `image_url` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Tablo döküm verisi `recipes`
--

INSERT INTO `recipes` (`id`, `title`, `category`, `content`, `image_url`, `created_at`) VALUES
(1, 'Rice Pudding', 'Desserts', 'Wash the rice and boil it with milk. Add sugar and vanilla...', 'rice_pudding.jpg', '2025-12-19 11:04:06'),
(2, 'Lentil Soup', 'Main Courses', 'Fry the onions and add red lentils. Boil with water...', 'lentil_soup.jpg', '2025-12-19 11:04:06'),
(3, 'Menemen', 'Breakfast', 'Saute tomatoes and green peppers, then add eggs...', 'menemen.jpg', '2025-12-19 11:04:06'),
(4, 'Meatballs', 'Main Courses', 'Mix ground beef with spices. Bake with potatoes...', 'meatballs.jpg', '2025-12-19 11:04:06'),
(5, 'Magnolia', 'Desserts', 'Crush biscuits, make pudding with milk and cream...', 'magnolia.jpg', '2025-12-19 11:04:06');

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `recipes`
--
ALTER TABLE `recipes`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `recipes`
--
ALTER TABLE `recipes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
