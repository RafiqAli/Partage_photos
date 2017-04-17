-- phpMyAdmin SQL Dump
-- version 4.6.6
-- https://www.phpmyadmin.net/
--
-- Client :  localhost
-- Généré le :  Lun 17 Avril 2017 à 14:29
-- Version du serveur :  5.7.17-0ubuntu0.16.04.1
-- Version de PHP :  7.0.15-0ubuntu0.16.04.4

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
-- Structure de la table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `categories`
--

INSERT INTO `categories` (`id`, `name`, `description`) VALUES
(1, 'animals', 'this is a sample animals category'),
(2, 'name', 'description'),
(3, 'name', 'description');

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
(3, 'club1', 'club1 description', 'ali'),
(4, 'club1', 'club1 description', 'ali'),
(5, 'club2', 'club2 description', 'yassir'),
(6, 'club2', 'club2 description', 'yassir');

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
(7, 'this is content', 'ali', 19),
(8, 'content number 2', 'ali', 19),
(9, 'content 3', 'ali', 19),
(10, 'content 4', 'ali', 19);

-- --------------------------------------------------------

--
-- Structure de la table `local_areas`
--

CREATE TABLE `local_areas` (
  `id` int(11) NOT NULL,
  `street` varchar(255) NOT NULL,
  `city` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Structure de la table `photos`
--

CREATE TABLE `photos` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `link` varchar(255) DEFAULT NULL,
  `description` text NOT NULL,
  `file` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `visibility` int(20) NOT NULL,
  `local_area_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `photos`
--

INSERT INTO `photos` (`id`, `title`, `name`, `date`, `link`, `description`, `file`, `owner`, `visibility`, `local_area_id`) VALUES
(18, 'PhotoTest', '14212165_1379492905441163_7402284545959690173_n.jpg', '2017-03-15', '', 'this is a description', 'mDEAbMBr.jpeg', 'ali', 0, NULL),
(19, 'PhotoTest', '14212165_1379492905441163_7402284545959690173_n.jpg', '2017-03-15', '', 'this is a description', 'GX3l4fZI.jpeg', 'ali', 0, NULL),
(21, 'this is a name', 'tightropewalkers.jpg', '2017-03-15', '', 'this is a description', 'iC3NPOEb.jpeg', 'ali', 0, NULL),
(24, 'oooooooooooooo', '12767598_1682830325319227_1382226467_n.jpg', '2017-03-21', '', 'ooooooooooooooooooo', 'sOpEIUL1.jpeg', 'yassir', 0, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `photo_category`
--

CREATE TABLE `photo_category` (
  `photo_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `photo_category`
--

INSERT INTO `photo_category` (`photo_id`, `category_id`, `date_created`) VALUES
(18, 1, '2017-04-13'),
(19, 1, '2017-04-13'),
(19, 2, '2017-04-14');

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
-- Structure de la table `ratings`
--

CREATE TABLE `ratings` (
  `photo_id` int(11) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `value` int(11) NOT NULL,
  `description` text,
  `date_created` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `ratings`
--

INSERT INTO `ratings` (`photo_id`, `owner`, `value`, `description`, `date_created`) VALUES
(2, 'ali', 3, 'description', '2017-04-13'),
(18, 'ali', 4, 'description', '2017-04-13'),
(19, 'ali', 5, NULL, '2017-04-14'),
(19, 'yassir', 5, NULL, '2017-04-14'),
(21, 'ali', 4, NULL, '2017-04-14'),
(21, 'yassir', 5, NULL, '2017-04-14');

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
('yassir', '5baa61e4c9b93f3f0682250b6cf8331b7ee68fd8');

-- --------------------------------------------------------

--
-- Structure de la table `user_club`
--

CREATE TABLE `user_club` (
  `user_login` varchar(255) NOT NULL,
  `club_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `user_club`
--

INSERT INTO `user_club` (`user_login`, `club_id`) VALUES
('yassir', 6);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

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
-- Index pour la table `local_areas`
--
ALTER TABLE `local_areas`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photos`
--
ALTER TABLE `photos`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `photo_category`
--
ALTER TABLE `photo_category`
  ADD PRIMARY KEY (`photo_id`,`category_id`);

--
-- Index pour la table `photo_club`
--
ALTER TABLE `photo_club`
  ADD PRIMARY KEY (`photo_id`,`club_id`);

--
-- Index pour la table `ratings`
--
ALTER TABLE `ratings`
  ADD PRIMARY KEY (`photo_id`,`owner`);

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
-- AUTO_INCREMENT pour la table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `clubs`
--
ALTER TABLE `clubs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `local_areas`
--
ALTER TABLE `local_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `photos`
--
ALTER TABLE `photos`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
