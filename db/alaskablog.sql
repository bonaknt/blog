-- phpMyAdmin SQL Dump
-- version 4.6.5.2
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Ven 31 Mars 2017 à 19:24
-- Version du serveur :  10.1.21-MariaDB
-- Version de PHP :  5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `alaskablog`
--

-- --------------------------------------------------------

--
-- Structure de la table `t_article`
--

CREATE TABLE `t_article` (
  `art_id` int(11) NOT NULL,
  `art_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `art_content` varchar(2000) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_article`
--

INSERT INTO `t_article` (`art_id`, `art_title`, `art_content`) VALUES
(1, 'Langage de programmation PHP', 'PHP: Hypertext Preprocessor, plus connu sous son sigle PHP (acronyme r&eacute;cursif), est un langage de programmation libre, principalement utilis&eacute; pour produire des pages Web dynamiques via un serveur HTTP, mais pouvant &eacute;galement fonctionner comme n\'importe quel langage interpr&eacute;t&eacute; de fa&ccedil;on locale. PHP est un langage imp&eacute;ratif orient&eacute; objet.<br /><br />PHP a permis de cr&eacute;er un grand nombre de sites web c&eacute;l&egrave;bres, comme Facebook, Wikip&eacute;dia, etc. Il est consid&eacute;r&eacute; comme une des bases de la cr&eacute;ation de sites web dits dynamiques mais &eacute;galement des applications web.'),
(2, 'Lorem ipsum', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut hendrerit mauris ac porttitor accumsan. Nunc vitae pulvinar odio, auctor interdum dolor. Aenean sodales dui quis metus iaculis, hendrerit vulputate lorem vestibulum. Suspendisse pulvinar, purus at euismod semper, nulla orci pulvinar massa, ac placerat nisi urna eu tellus. Fusce dapibus rutrum diam et dictum. Sed tellus ipsum, ullamcorper at consectetur vitae, gravida vel sem. Vestibulum pellentesque tortor et elit posuere vulputate. Sed et volutpat nunc. Praesent nec accumsan nisi, in hendrerit nibh. In ipsum mi, fermentum et eleifend eget, eleifend vitae libero. Phasellus in magna tempor diam consequat posuere eu eget urna. Fusce varius nulla dolor, vel semper dui accumsan vitae. Sed eget risus neque.'),
(3, 'Lorem ipsum in french', 'J’en dis autant de ceux qui, par mollesse d’esprit, c’est-à-dire par la crainte de la peine et de la douleur, manquent aux devoirs de la vie. Et il est très facile de rendre raison de ce que j’avance. Car, lorsque nous sommes tout à fait libres, et que rien ne nous empêche de faire ce qui peut nous donner le plus de plaisir, nous pouvons nous livrer entièrement à la volupté et chasser toute sorte de douleur ; mais, dans les temps destinés aux devoirs de la société ou à la nécessité des affaires, souvent il faut faire divorce avec la volupté, et ne se point refuser à la peine. La règle que suit en cela un homme sage, c’est de renoncer à de légères voluptés pour en avoir de plus grandes, et de savoir supporter des douleurs légères pour en éviter de plus fâcheuses.'),
(4, 'Framework Silex', 'Silex est un micro-framework PHP d&eacute;velopp&eacute; par la soci&eacute;t&eacute; fran&ccedil;aise SensioLabs, cr&eacute;atrice du framework Symfony. Silex est en quelque sorte le petit fr&egrave;re de Symfony et les deux frameworks reposent sur les m&ecirc;mes composants. Contrairement &agrave; Symfony qui fournit (et impose) une architecture compl&egrave;te (dite &laquo; full stack &raquo;), Silex est un framework minimaliste qui laisse beaucoup de libert&eacute; au d&eacute;veloppeur. C\'est pourquoi on peut le qualifier de micro-framework. Il fournit un ensemble r&eacute;duit de services au-dessus desquels on peut d&eacute;velopper une application Web. Son minimalisme le rend id&eacute;al pour s\'initier en douceur au fonctionnement d\'un framework PHP.'),
(5, 'JavaScript', 'JavaScript est un langage de programmation de scripts principalement employ&eacute; dans les pages web interactives mais aussi pour les serveurs avec l\'utilisation (par exemple) de Node.JS. C\'est un langage orient&eacute; objet &agrave; prototype, c\'est-&agrave;-dire que les bases du langage et ses principales interfaces sont fournies par des objets qui ne sont pas des instances de classes, mais qui sont chacun &eacute;quip&eacute;s de constructeurs permettant de cr&eacute;er leurs propri&eacute;t&eacute;s, et notamment une propri&eacute;t&eacute; de prototypage qui permet d\'en cr&eacute;er des objets h&eacute;ritiers personnalis&eacute;s. En outre, les fonctions sont des objets de premi&egrave;re classe.<br /><br />JavaScript a &eacute;t&eacute; cr&eacute;&eacute; en 1995 par Brendan Eich. Il a &eacute;t&eacute; standardis&eacute; sous le nom d\'ECMAScript en juin 1997 par Ecma International dans le standard ECMA-262. Le standard ECMA-262 en est actuellement &agrave; sa 7e &eacute;dition. JavaScript n\'est depuis qu\'une impl&eacute;mentation d\'ECMAScript, celle mise en &oelig;uvre par la fondation Mozilla. L\'impl&eacute;mentation d\'ECMAScript par Microsoft se nomme JScript, tandis que celle d\'Adobe Systems se nomme ActionScript.'),
(6, 'Langage de programmation JQUERY', 'jQuery is a fast, small, and feature-rich JavaScript library. It makes things like HTML document traversal and manipulation, event handling, animation, and Ajax much simpler with an easy-to-use API that works across a multitude of browsers. With a combination of versatility and extensibility, jQuery has changed the way that millions of people write JavaScript.'),
(7, 'Bootstrap', 'Bootstrap est un framework CSS, mais pas seulement, puisqu\'il embarque &eacute;galement des composants HTML et JavaScript. Il comporte un syst&egrave;me de grille simple et efficace pour mettre en ordre l\'aspect visuel d\'une page web. Il apporte du style pour les boutons, les formulaires, la navigation&hellip; Il permet ainsi de concevoir un site web rapidement et avec peu de lignes de code ajout&eacute;es. Le framework le plus proche de Bootstrap est sans doute <a href=\"http://foundation.zurb.com/\">Foundation</a> qui est pr&eacute;sent&eacute; comme &laquo; <em>The most advanced responsive front-end framework in the world</em> &raquo;. Cette absence de modestie est-elle de mise ? Je pense que c\'est surtout une affaire de go&ucirc;t et de pr&eacute;f&eacute;rence personnelle. En tout cas en terme de popularit&eacute; c\'est Bootstrap qui l\'emporte haut la main.');

-- --------------------------------------------------------

--
-- Structure de la table `t_comment`
--

CREATE TABLE `t_comment` (
  `com_id` int(11) NOT NULL,
  `com_content` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
  `art_id` int(11) NOT NULL,
  `usr_name` varchar(250) COLLATE utf8_unicode_ci NOT NULL,
  `parent_id` int(11) DEFAULT '0',
  `signalement` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_comment`
--

INSERT INTO `t_comment` (`com_id`, `com_content`, `art_id`, `usr_name`, `parent_id`, `signalement`) VALUES
(1, 'c\'est très cool', 3, 'Polo452', 0, 0),
(59, 'Je trouve l\'article constructif, j\'espère qu\'il y aura d\'autres articles de ceux même type car j\'ai pu apprendre beaucoup de chose grace à vous ! donc je vous dit un grand merci, le blog est cool !', 4, 'polo', 0, 0),
(110, 'parfait l\'article !', 4, 'miloud', 59, 0),
(122, 'reponds à miloud', 4, 'momo', 110, 0),
(125, 'Très bon langage !', 5, 'claude75', NULL, 0),
(126, 'j\'aime bien ce framework', 7, 'paul145', NULL, 0),
(127, 'moi aussi', 7, 'max74', 126, NULL),
(132, 'j\'aime bien bootstrap', 7, 'marco74', 0, NULL),
(133, 'Oui je confirme ça simplifie', 7, 'jean', 132, NULL);

-- --------------------------------------------------------

--
-- Structure de la table `t_user`
--

CREATE TABLE `t_user` (
  `usr_id` int(11) NOT NULL,
  `usr_name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `usr_password` varchar(88) COLLATE utf8_unicode_ci NOT NULL,
  `usr_salt` varchar(23) COLLATE utf8_unicode_ci NOT NULL,
  `usr_role` varchar(50) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Contenu de la table `t_user`
--

INSERT INTO `t_user` (`usr_id`, `usr_name`, `usr_password`, `usr_salt`, `usr_role`) VALUES
(3, 'admin', '$2y$13$j/mi49UnLq7KIW3MlNZdben9r2slNb68YCscigGNzQYsy6gz.Bt1W', 'EDDsl&fBCJB|a5XUtAlnQN8', 'ROLE_ADMIN'),
(4, 'administrateur', '$2y$13$yR58SaQXYfPvy14H0YLZBuF4ihPW9jdPzliT8Es5ZLpKrMKRg.m/m', '0f92a581f848258f6accdec', 'ROLE_ADMIN');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `t_article`
--
ALTER TABLE `t_article`
  ADD PRIMARY KEY (`art_id`);

--
-- Index pour la table `t_comment`
--
ALTER TABLE `t_comment`
  ADD PRIMARY KEY (`com_id`),
  ADD KEY `fk_com_art` (`art_id`);

--
-- Index pour la table `t_user`
--
ALTER TABLE `t_user`
  ADD PRIMARY KEY (`usr_id`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `t_article`
--
ALTER TABLE `t_article`
  MODIFY `art_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `t_comment`
--
ALTER TABLE `t_comment`
  MODIFY `com_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=134;
--
-- AUTO_INCREMENT pour la table `t_user`
--
ALTER TABLE `t_user`
  MODIFY `usr_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `t_comment`
--
ALTER TABLE `t_comment`
  ADD CONSTRAINT `fk_com_art` FOREIGN KEY (`art_id`) REFERENCES `t_article` (`art_id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
