-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 16, 2023 at 04:27 PM
-- Server version: 5.7.33
-- PHP Version: 7.2.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blog_pro`
--

-- --------------------------------------------------------

--
-- Table structure for table `comment`
--

CREATE TABLE `comment` (
  `id` int(11) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `is_enabled` tinyint(1) NOT NULL,
  `id_user` int(11) NOT NULL,
  `id_post` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `comment`
--

INSERT INTO `comment` (`id`, `content`, `created_at`, `update_date`, `is_enabled`, `id_user`, `id_post`) VALUES
(1, 'commentaire test 2 blablablablablablablablabla', '2023-05-02 00:00:00', '2023-05-03 00:00:00', 1, 2, 149),
(2, 'commentaire test 2 blablablablablablablablabla', '2023-05-02 00:00:00', '2023-05-03 00:00:00', 0, 2, 147),
(3, 'commentaire test blabla', '2023-05-11 00:00:00', '2023-05-11 00:00:00', 1, 3, 149),
(4, 'commentaire test blablablabla', '2023-05-11 00:00:00', '2023-05-11 00:00:00', 1, 4, 149),
(5, 'commentaire test admin', '2023-05-11 00:00:00', '2023-05-11 00:00:00', 1, 1, 149),
(7, 'test', '2023-06-10 23:55:37', '2023-06-10 23:55:37', 0, 1, 147),
(10, 'test commentaire pour anonymisation', '2023-07-01 20:43:32', '2023-07-01 20:43:32', 0, 2, 148);

-- --------------------------------------------------------

--
-- Table structure for table `contactform`
--

CREATE TABLE `contactform` (
  `id` int(11) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `email` varchar(150) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `contactform`
--

INSERT INTO `contactform` (`id`, `lastname`, `firstname`, `email`, `content`, `created_at`) VALUES
(9, 'BENINCA', 'AURELIE', 'aurelie.beninca@gmail.com', 'bonjour je suis un contact Form de test : )', '2023-03-16 13:29:14'),
(13, 'BENINCA', 'AURELIE', 'aurelie.beninca@gmail.com', 'test render\r\n', '2023-03-18 19:29:10'),
(14, 'BENINCA', 'AURELIE', 'aurelie.beninca@gmail.com', 'blabla', '2023-03-19 17:10:16'),
(15, 'BENINCA', 'AURELIE', 'aurelie.beninca@gmail.com', 'test global', '2023-04-10 19:23:35'),
(23, 'MARTIN', 'Pêcheur', 'martin@pecheur.fr', 'Bonjour, \r\nJe suis un formulaire de contact', '2023-07-16 18:27:11');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `title` varchar(200) NOT NULL,
  `lead` varchar(250) NOT NULL,
  `content` text NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `update_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `id_user` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `title`, `lead`, `content`, `created_at`, `update_date`, `id_user`) VALUES
(147, 'Le monde de la fantasy: une évasion dans un monde magique', 'Découvrez la magie et l\'imagination du genre fantasy, où les mondes fictifs, les créatures mythiques et les personnages héroïques règnent en maîtres.', 'La fantasy est un genre de fiction qui transporte les lecteurs dans un monde magique et imaginaire. Ces histoires sont peuplées de créatures mythiques telles que des dragons, des elfes, des nains et des sorciers. Dans un monde de fantasy, les personnages héroïques se battent contre le mal et sauvent le monde.\r\n\r\nLes auteurs de fantasy créent des mondes complexes avec leur propre histoire, géographie, culture et langage. Ces mondes sont souvent inspirés de notre propre histoire ou de cultures anciennes. Les auteurs utilisent également des éléments de la mythologie pour donner vie à leurs mondes.\r\n\r\nLorsque vous lisez de la fantasy, vous pouvez vous évader dans un monde magique qui n\'existe pas dans la vie réelle. Vous pouvez rencontrer des personnages fascinants, apprendre de nouvelles cultures et découvrir des aventures épiques. La fantasy peut être une source d\'inspiration pour votre propre vie, car elle encourage la créativité et l\'imagination.', '2023-03-19 16:25:11', '2023-03-19 16:25:11', 1),
(148, 'Les héros de la fantasy : de la faiblesse à la force', 'Les héros de la fantasy sont souvent confrontés à des défis incroyables et à des ennemis redoutables. Découvrez comment ces personnages passent de la faiblesse à la force.', 'Dans la fantasy, les héros sont souvent des personnages ordinaires qui sont appelés à faire des choses extraordinaires. Ils peuvent être intimidés, maladroits ou même peureux au début de leur voyage, mais ils finissent par devenir des guerriers courageux et puissants.\r\n\r\nLes héros de fantasy passent souvent par un processus de transformation, où ils apprennent à maîtriser leurs compétences, à vaincre leurs peurs et à surmonter leurs faiblesses. Les épreuves qu\'ils affrontent les obligent à devenir plus forts et plus résilients.\r\n\r\nLes héros de fantasy sont également des modèles pour les lecteurs. Ils nous rappellent que nous aussi, nous avons le potentiel de devenir des héros et de vaincre les obstacles de la vie.', '2023-03-19 16:25:11', '2023-03-19 16:25:11', 1),
(149, 'L\'importance de la magie dans la fantasy', 'La magie est un élément essentiel de nombreux récits de fantasy, apportant un niveau de merveilleux et de mystère à ces histoires qui captivent l\'imagination des lecteurs.', 'La magie est un élément central de nombreux récits de fantasy. Elle peut prendre différentes formes, depuis les sorts et les enchantements jusqu\'aux créatures fantastiques et aux mondes enchantés. La magie peut apporter un niveau de merveilleux et de mystère à ces histoires qui captivent l\'imagination des lecteurs.\r\n\r\nLa magie est souvent utilisée pour créer des mondes imaginaires complexes et détaillés, tels que ceux que l\'on trouve dans les œuvres de J.R.R. Tolkien ou de George R.R. Martin. Elle peut également être utilisée pour renforcer les personnages, en leur donnant des pouvoirs spéciaux ou en leur permettant de surmonter des obstacles apparemment insurmontables.\r\n\r\nCependant, la magie peut également être un élément dangereux dans les récits de fantasy. Elle peut être utilisée pour causer des destructions massives et des tragédies, comme on le voit dans la saga Harry Potter de J.K. Rowling. La magie peut également être utilisée pour représenter des idées plus sombres, comme la corruption et la manipulation.\r\n\r\nDans l\'ensemble, la magie est un élément crucial de la fantasy. Elle peut donner vie à des mondes imaginaires et à des personnages incroyables, tout en ajoutant une touche de merveilleux et de mystère à ces histoires captivantes.', '2023-03-19 16:29:38', '2023-03-19 16:29:38', 1),
(150, 'Les dragons dans la fantasy', 'Les dragons sont des créatures emblématiques de la fantasy, symboles de puissance et de majesté qui captivent l\'imagination des lecteurs depuis des siècles.', 'Les dragons sont des créatures emblématiques de la fantasy, symboles de puissance et de majesté qui captivent l\'imagination des lecteurs depuis des siècles. Ils peuvent être trouvés dans une variété de récits de fantasy, allant de la légende de Beowulf à la série de romans de George R.R. Martin, Game of Thrones.\r\n\r\nLes dragons sont souvent représentés comme des créatures féroces et redoutables, dotées d\'écailles dures comme l\'acier et de flammes brûlantes. Ils peuvent être utilisés pour représenter des idées telles que la force, la puissance et la domination. Cependant, dans certains récits de fantasy, les dragons peuvent également être utilisés pour représenter des idées plus sombres, telles que la cupidité et la tyrannie.\r\n\r\nDans de nombreux récits de fantasy, les dragons sont également des créatures intelligentes, capables de parler et d\'interagir avec les personnages. Ils peuvent avoir des personnalités distinctes et complexes, ajoutant une profondeur supplémentaire à l\'histoire.\r\n\r\nEn fin de compte, les dragons restent un élément important de la fantasy, symbolisant la puissance et la majesté tout en ajoutant une touche de danger et de mystère aux histoires captivantes', '2023-03-19 16:29:38', '2023-03-19 16:29:38', 1);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `lastname` varchar(150) NOT NULL,
  `firstname` varchar(150) NOT NULL,
  `pseudonym` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `password` varchar(200) NOT NULL,
  `token` int(11) NOT NULL,
  `role` varchar(50) NOT NULL,
  `is_verified` tinyint(1) NOT NULL,
  `avatar` varchar(150) DEFAULT NULL,
  `registration_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `lastname`, `firstname`, `pseudonym`, `email`, `password`, `token`, `role`, `is_verified`, `avatar`, `registration_date`) VALUES
(1, 'Beninca', 'Aurélie', 'Shiloe', 'aurelie.beninca@gmail.com', '$2y$10$2iMGE3URrgTzc.TTvP5Tj./VIsom0Hd4wskpE3oHZ2ES28GZ2eP7S', 0, 'admin', 1, '64b265c0769896.96541324.png', '2023-03-05 00:00:00'),
(2, 'anonyme', 'anonyme', 'anonyme', 'anonyme@a.fr', '$2y$10$LGfniULuXeAtKigl81qquO1F6dlQ3mAtEoeqlcIwHgE4LyyeAKCzW', 34426914, 'utilisateur', 1, '645c1c72f1f761.30302303.png', '2023-05-11 00:36:35'),
(3, 'Germain', 'Lenny', 'Chaton', 'glenny.dragon@gmail.com', '$2y$10$R03WRZbbCwtOodQGSw4yCuW3QTC0G9MPT7gKV.o0v/DOJ0vt6AnG6', 0, 'utilisateur', 1, '64a06eb01b24f8.21285323.jpg', '2023-04-02 17:09:14'),
(4, 'Germain', 'Ambre', 'Lapin', 'ambre.lapinrose@gmail.com', '$2y$10$q9yh4R9QNsnaOcHdbPwtreNG5lpoOP7r4hlStqxEbwVorXBCZ3PzO', 0, 'utilisateur', 1, '6436e47b184b29.60954334.jpg', '2023-04-02 17:10:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comment`
--
ALTER TABLE `comment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`),
  ADD KEY `id_post` (`id_post`);

--
-- Indexes for table `contactform`
--
ALTER TABLE `contactform`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_user` (`id_user`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comment`
--
ALTER TABLE `comment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `contactform`
--
ALTER TABLE `contactform`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=154;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comment`
--
ALTER TABLE `comment`
  ADD CONSTRAINT `comment_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`),
  ADD CONSTRAINT `comment_ibfk_2` FOREIGN KEY (`id_post`) REFERENCES `post` (`id`);

--
-- Constraints for table `post`
--
ALTER TABLE `post`
  ADD CONSTRAINT `post_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `user` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
