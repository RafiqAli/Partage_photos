-- phpMyAdmin SQL Dump
-- version 4.5.5.1
-- http://www.phpmyadmin.net
--
-- Client :  127.0.0.1
-- Généré le :  Mar 04 Avril 2017 à 13:52
-- Version du serveur :  5.7.11
-- Version de PHP :  7.0.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `partage_photos`
--

-- --------------------------------------------------------

--
-- Structure de la table `clubs`
--

CREATE TABLE `clubs` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `clubs`
--

INSERT INTO `clubs` (`id`, `title`, `description`, `admin`) VALUES
(1, 'friends', 'this group is made for friends to meet and get to know each other more and share what they cherish with each other.', 'ali'),
(2, 'lovers', 'where lovers meet.', 'yassir'),
(3, 'test', 'test', 'yassir2');

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `photo_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `comments`
--

INSERT INTO `comments` (`id`, `content`, `owner`, `photo_id`) VALUES
(1, 'this is a comment', 'ali', 22),
(2, 'ok this is good', 'ali', 22),
(4, 'this is a comment 4', 'ali', 22),
(5, 'this is a comment 5', 'ali', 22),
(6, 'this might be id four', 'ali', 21),
(7, 'helo', 'yassir2', 25),
(8, 'nice tof', 'simo', 27);

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `description` text NOT NULL,
  `file` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `visibility` int(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `photos`
--

INSERT INTO `photos` (`id`, `title`, `name`, `date`, `description`, `file`, `owner`, `visibility`) VALUES
(19, 'PhotoTest', '14212165_1379492905441163_7402284545959690173_n.jpg', '2017-03-15', 'this is a description', 'GX3l4fZI.jpeg', 'ali', 0),
(21, 'this is a name', 'tightropewalkers.jpg', '2017-03-15', 'this is a description', 'iC3NPOEb.jpeg', 'ali', 0),
(25, 'hello world', '2.jpg', '2017-04-13', 'test', 'ro4DRgVa.jpeg', 'yassir2', NULL),
(27, 'kkk', '3.jpg', '2017-04-22', 'dd', 'fHKhoovm.jpeg', 'simo', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `photo_club`
--

CREATE TABLE `photo_club` (
  `photo_id` int(11) NOT NULL,
  `club_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `photo_club`
--

INSERT INTO `photo_club` (`photo_id`, `club_id`) VALUES
(18, 1),
(19, 1),
(21, 2),
(24, 2);

-- --------------------------------------------------------

--
-- Structure de la table `users`
--

CREATE TABLE `users` (
  `login` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `users`
--

INSERT INTO `users` (`login`, `password`) VALUES
('ali', 'e5e9fa1ba31ecd1ae84f75caaa474f3a663f05f4'),
('simo', '65f99581a93cf30dafc32b5c178edc6b0294a07f'),
('yassir', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8'),
('yassir2', '40bd001563085fc35165329ea1ff5c5ecbdbbeef');

-- --------------------------------------------------------

--
-- Structure de la table `user_club`
--

CREATE TABLE `user_club` (
  `user_login` varchar(255) NOT NULL,
  `club_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Index pour les tables exportées
--

--
-- Index pour la table `clubs`
--
ALTER TABLE `clubs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photo_club`
--
ALTER TABLE `photo_club`
  ADD PRIMARY KEY (`photo_id`,`club_id`);

--
-- Index pour la table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`login`),
  ADD UNIQUE KEY `login` (`login`);

--
-- Index pour la table `user_club`
--
ALTER TABLE `user_club`
  ADD PRIMARY KEY (`user_login`,`club_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
