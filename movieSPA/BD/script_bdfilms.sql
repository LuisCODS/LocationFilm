
--
-- Banco de dados: `bdfilms`
--
CREATE DATABASE IF NOT EXISTS `bdfilms` DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE `bdfilms`;

-- --------------------------------------------------------

--
-- Estrutura da tabela `categories`
--

DROP TABLE IF EXISTS `categories`;
CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) DEFAULT NULL,
  `slug` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `categories`
--

INSERT INTO `categories` (`id`, `titre`, `slug`, `created_at`, `updated_at`) VALUES
(1, 'Action', 'action', '2020-11-08 06:31:38', '2020-11-08 06:31:49'),
(2, 'Romance', 'romance', '2020-11-08 08:12:37', '2020-11-08 08:12:37'),
(9, 'Horreur', 'horreur', '2020-11-09 08:31:18', '2020-11-09 08:31:18'),
(10, 'Drame', 'drame', '2020-11-09 08:31:42', '2020-11-09 08:31:42');

-- --------------------------------------------------------

--
-- Estrutura da tabela `films`
--

DROP TABLE IF EXISTS `films`;
CREATE TABLE IF NOT EXISTS `films` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `category_id` int(11) DEFAULT NULL,
  `titre` varchar(255) NOT NULL DEFAULT '',
  `image` text NOT NULL,
  `preview_url` text NOT NULL,
  `auteur` varchar(255) DEFAULT NULL,
  `duree` varchar(10) DEFAULT NULL,
  `prix` int(11) UNSIGNED NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=42 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `films`
--

INSERT INTO `films` (`id`, `category_id`, `titre`, `image`, `preview_url`, `auteur`, `duree`, `prix`, `created_at`, `updated_at`) VALUES
(1, 1, 'Superman', '92ea353a22d8540c4b333b7fa890a9e71bf192fb.jpg', 'https://www.youtube.com/watch?v=T6DJcgm3wNY', 'Jerry Sieg', '3h 8m', 10, '2020-11-08 06:30:53', '2020-11-08 06:30:53'),
(2, 1, 'Dark Tower', '022cc761e7338535863dd34464cb085bd2c029ec.jpeg', 'https://www.youtube.com/watch?v=GjwfqXTebIY', 'Nikolaj Arcel', '1h 35m', 20, '2020-11-08 06:35:36', '2020-11-08 06:35:36'),
(3, 1, 'Amazing Spiderma 3', '6b40a95e6886bc538962ff5abad36e4c6e225409.jpeg', 'https://www.youtube.com/watch?v=Y51d7UsxfKY', 'Jon Watts', '2h 13m', 15, '2020-11-08 06:36:08', '2020-11-08 06:36:08'),
(4, 1, 'Aladdin', 'ac128a1c3a3f4032bb835366a6c6a9077ccba20c.jpg', 'https://www.youtube.com/watch?v=foyufD52aog', 'Guy Ritchie', '2h 8m', 30, '2020-11-08 06:39:08', '2020-11-08 06:39:08'),
(5, 2, 'Le Diable S\'habille en Prada', '9827fbe7af3835f1363a2394f6c643ce27d8868b.jpg', 'https://www.youtube.com/watch?v=SkXERnN-vzw', 'David Frankel', '1h 50m', 25, '2020-11-08 06:40:40', '2020-11-08 06:40:40'),
(6, 2, 'Focus', 'b39a4f6316265e04303e07138cc8d6544d5831f8.jpg', 'https://www.youtube.com/watch?v=MxCRgtdAuBo', 'Denise Di Novi', '1h 45m', 8, '2020-11-08 06:40:40', '2020-11-08 06:40:40'),
(30, 10, 'Lion', '710701e439370e0a335478c53696652c4e0a7e0d.jpg', 'https://www.youtube.com/watch?v=mD23AJkyq6g', 'Garth Davis', '2h', 10, '2020-11-09 08:34:34', '2020-11-09 08:34:34'),
(34, 9, 'Jigsall L\'hÃ©ritage', '04b227096c84c46e244df0f4c24c60326b2529f4.jpg', 'https://www.youtube.com/watch?v=rF5viX42K3s', 'ASWER', '66', 10, '2020-11-16 03:34:33', '2020-11-16 03:34:33'),
(41, 2, 'Teste Ajouter un Film avatar', 'avatar.jpg', 'Teste Ajouter un Film avatar', 'Teste Ajouter un Film avatar', '66', 5, '2020-12-01 00:36:20', '2020-12-01 00:36:20');

-- --------------------------------------------------------

--
-- Estrutura da tabela `locations`
--

DROP TABLE IF EXISTS `locations`;
CREATE TABLE IF NOT EXISTS `locations` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `film_id` int(11) NOT NULL,
  `membre_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=104 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `locations`
--

INSERT INTO `locations` (`id`, `film_id`, `membre_id`, `quantity`, `created_at`, `updated_at`) VALUES
(93, 1, 2, NULL, '2020-11-10 07:00:01', '2020-11-10 07:00:01'),
(94, 2, 1, NULL, '2020-11-10 07:00:11', '2020-11-10 07:00:11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `membres`
--

DROP TABLE IF EXISTS `membres`;
CREATE TABLE IF NOT EXISTS `membres` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT '',
  `is_admin` int(11) DEFAULT 0,
  `password` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `membres`
--

INSERT INTO `membres` (`id`, `nom`, `email`, `is_admin`, `password`, `created_at`, `updated_at`) VALUES
(1, 'Antonio', 'atavares@cmaisonneuve.qc.ca', 0, '$2y$10$MxuvrN8Dc0ZQ6A5hIbfiPeKYtc4C3k3Xx1ER22NSNTZ43ZfzP2/Cq', '2020-11-09 03:39:58', '2020-11-08 07:39:03'),
(3, 'admin', 'admin@gmail.com', 1, '$2y$10$h1Pg/PTwAdytvUEqIomcKOqxRlaIEBuokcTG2..vYOxrEPu0Ws31S', '2020-11-09 04:40:05', '2020-11-08 12:34:22'),
(4, 'membre', 'membre@gmail.com', 0, '$2y$10$xnB8OxnsRUNWnFPWRUsIv.Ocq0bcKW3FyRSjvVVNeX85cd46BkWHO', '2020-11-10 01:13:22', '2020-11-10 01:13:22'),
(5, 'Janie Racine', 'janieracine@hotmail.com', 0, '$2y$10$4pxJLuWJ/F9n83BWe8jUEuTGZh0NCCDkrTnXAdeygW8RGFUIOi/8y', '2020-11-16 03:38:20', '2020-11-16 03:38:20'),
(7, 'Luis Santos', 'tennis.bresil@gmail.com', 0, '$2y$10$Xi97fgZXAwJs.UmKjGNGtuM41GxYG2sU9OMKVKSeMstqZsRjScrIC', '2020-11-24 17:01:11', '2020-11-24 17:01:11');

-- --------------------------------------------------------

--
-- Estrutura da tabela `rentals`
--

DROP TABLE IF EXISTS `rentals`;
CREATE TABLE IF NOT EXISTS `rentals` (
  `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  `film_id` int(11) NOT NULL,
  `membre_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8;

--
-- Extraindo dados da tabela `rentals`
--

INSERT INTO `rentals` (`id`, `film_id`, `membre_id`, `quantity`, `created_at`, `updated_at`) VALUES
(24, 1, 4, 1, '2020-11-16 02:50:03', '2020-11-16 02:50:03'),
(25, 3, 4, 1, '2020-11-16 02:50:03', '2020-11-16 02:50:03'),
(26, 2, 2, 1, '2020-11-16 02:51:03', '2020-11-16 02:51:03'),
(27, 1, 7, 2, '2020-11-24 17:01:39', '2020-11-24 17:01:39'),
(28, 6, 7, 1, '2020-11-24 17:03:23', '2020-11-24 17:03:23'),
(29, 34, 7, 1, '2020-11-30 23:37:48', '2020-11-30 23:37:48'),
(30, 41, 5, 1, '2020-12-01 00:39:59', '2020-12-01 00:39:59');
COMMIT;
