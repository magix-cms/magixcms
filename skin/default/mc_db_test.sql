-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Serveur: localhost
-- Généré le : Ven 28 Décembre 2012 à 11:43
-- Version du serveur: 5.1.44
-- Version de PHP: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `mc_template`
--

-- --------------------------------------------------------

--
-- Structure de la table `mc_catalog`
--

CREATE TABLE IF NOT EXISTS `mc_catalog` (
  `idcatalog` int(6) NOT NULL AUTO_INCREMENT,
  `idlang` tinyint(3) NOT NULL DEFAULT '0',
  `idadmin` tinyint(2) NOT NULL,
  `urlcatalog` varchar(125) NOT NULL,
  `titlecatalog` varchar(125) NOT NULL,
  `desccatalog` text,
  `price` decimal(12,2) DEFAULT NULL,
  `ordercatalog` int(6) NOT NULL,
  `publish` tinyint(1) NOT NULL DEFAULT '1',
  `date_catalog` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcatalog`),
  KEY `idclc` (`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `mc_catalog`
--

INSERT INTO `mc_catalog` (`idcatalog`, `idlang`, `idadmin`, `urlcatalog`, `titlecatalog`, `desccatalog`, `price`, `ordercatalog`, `publish`, `date_catalog`) VALUES
(1, 1, 1, 'trier-le-catalogue-en-drag-and-drop', 'Trier le catalogue en drag-and-drop', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', 1.00, 1, 1, '2012-12-23 17:21:03'),
(2, 1, 1, 'utilisation-des-tags', 'Utilisation des tags', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', 100000.00, 2, 1, '2012-12-23 17:21:21');

-- --------------------------------------------------------

--
-- Structure de la table `mc_catalog_c`
--

CREATE TABLE IF NOT EXISTS `mc_catalog_c` (
  `idclc` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `clibelle` varchar(125) NOT NULL,
  `pathclibelle` varchar(125) NOT NULL,
  `img_c` varchar(125) DEFAULT NULL,
  `c_content` text,
  `idlang` tinyint(3) NOT NULL DEFAULT '0',
  `corder` tinyint(3) NOT NULL,
  PRIMARY KEY (`idclc`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `mc_catalog_c`
--

INSERT INTO `mc_catalog_c` (`idclc`, `clibelle`, `pathclibelle`, `img_c`, `c_content`, `idlang`, `corder`) VALUES
(3, 'Catalogue multi-niveaux', 'catalogue-multi-niveaux', NULL, '<p>Description de ma CATEGORIE ''Catalogue multi-niveaux''</p>\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua</p>', 1, 3),
(4, 'Pages de contenu multi-niveaux', 'pages-de-contenu-multi-niveaux', NULL, '', 1, 4),
(5, 'Actualités catégorisées', 'actualites-categorisees', NULL, NULL, 1, 5);

-- --------------------------------------------------------

--
-- Structure de la table `mc_catalog_galery`
--

CREATE TABLE IF NOT EXISTS `mc_catalog_galery` (
  `idmicro` int(6) NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) NOT NULL,
  `imgcatalog` varchar(125) NOT NULL,
  PRIMARY KEY (`idmicro`),
  KEY `idcatalog` (`idcatalog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `mc_catalog_galery`
--


-- --------------------------------------------------------

--
-- Structure de la table `mc_catalog_img`
--

CREATE TABLE IF NOT EXISTS `mc_catalog_img` (
  `idcatalog` int(6) NOT NULL,
  `imgcatalog` varchar(125) NOT NULL,
  PRIMARY KEY (`idcatalog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mc_catalog_img`
--


-- --------------------------------------------------------

--
-- Structure de la table `mc_catalog_product`
--

CREATE TABLE IF NOT EXISTS `mc_catalog_product` (
  `idproduct` int(6) NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) NOT NULL,
  `idclc` tinyint(3) unsigned NOT NULL,
  `idcls` tinyint(3) unsigned NOT NULL DEFAULT '0',
  `orderproduct` int(6) NOT NULL,
  PRIMARY KEY (`idproduct`),
  KEY `idclc` (`idclc`),
  KEY `idcatalog` (`idcatalog`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `mc_catalog_product`
--

INSERT INTO `mc_catalog_product` (`idproduct`, `idcatalog`, `idclc`, `idcls`, `orderproduct`) VALUES
(3, 1, 3, 1, 0),
(4, 1, 3, 2, 0),
(5, 1, 5, 0, 0),
(6, 2, 5, 0, 0);

-- --------------------------------------------------------

--
-- Structure de la table `mc_catalog_rel_product`
--

CREATE TABLE IF NOT EXISTS `mc_catalog_rel_product` (
  `idrelproduct` int(6) NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) NOT NULL,
  `idproduct` int(6) NOT NULL,
  PRIMARY KEY (`idrelproduct`),
  KEY `idcatalog` (`idcatalog`),
  KEY `idproduct` (`idproduct`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Contenu de la table `mc_catalog_rel_product`
--

INSERT INTO `mc_catalog_rel_product` (`idrelproduct`, `idcatalog`, `idproduct`) VALUES
(3, 1, 6);

-- --------------------------------------------------------

--
-- Structure de la table `mc_catalog_s`
--

CREATE TABLE IF NOT EXISTS `mc_catalog_s` (
  `idcls` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `slibelle` varchar(125) NOT NULL,
  `pathslibelle` varchar(125) NOT NULL,
  `img_s` varchar(125) DEFAULT NULL,
  `s_content` text,
  `idclc` tinyint(3) unsigned NOT NULL,
  `sorder` tinyint(3) NOT NULL,
  PRIMARY KEY (`idcls`),
  KEY `idclc` (`idclc`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `mc_catalog_s`
--

INSERT INTO `mc_catalog_s` (`idcls`, `slibelle`, `pathslibelle`, `img_s`, `s_content`, `idclc`, `sorder`) VALUES
(1, 'Gestion des catégories', 'gestion-des-categories', NULL, '<p>Ma description concernant ''Gestion des cat&eacute;gories'' SOUS-CAT de ''catalogue multi-niveaux''</p>', 3, 1),
(2, 'Gestion des sous-catégories', 'gestion-des-sous-categories', NULL, NULL, 3, 2),
(3, 'Gestion de produits', 'gestion-de-produits', NULL, NULL, 3, 3),
(4, 'Gestion des pages enfants', 'gestion-des-pages-enfants', NULL, NULL, 4, 4),
(5, 'Gestion des pages parent', 'gestion-des-pages-parent', NULL, NULL, 4, 5);

-- --------------------------------------------------------

--
-- Structure de la table `mc_cms_pages`
--

CREATE TABLE IF NOT EXISTS `mc_cms_pages` (
  `idpage` int(7) NOT NULL AUTO_INCREMENT,
  `idadmin` tinyint(3) NOT NULL,
  `idlang` tinyint(3) NOT NULL,
  `idcat_p` int(7) NOT NULL DEFAULT '0',
  `title_page` varchar(125) NOT NULL,
  `uri_page` varchar(125) NOT NULL,
  `content_page` text,
  `seo_title_page` tinytext,
  `seo_desc_page` tinytext,
  `order_page` smallint(5) unsigned NOT NULL DEFAULT '0',
  `sidebar_page` tinyint(1) NOT NULL DEFAULT '0',
  `date_register` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpage`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Contenu de la table `mc_cms_pages`
--

INSERT INTO `mc_cms_pages` (`idpage`, `idadmin`, `idlang`, `idcat_p`, `title_page`, `uri_page`, `content_page`, `seo_title_page`, `seo_desc_page`, `order_page`, `sidebar_page`, `date_register`, `last_update`) VALUES
(1, 1, 1, 0, 'Magix-cms: Votre logiciel de gestion de site!', 'magix-cms-votre-logiciel-de-gestion-de-site', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>\n<p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\n<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>\n<p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>\n<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur.</p>', '', '', 1, 1, '0000-00-00 00:00:00', '2012-09-22 12:57:29'),
(2, 1, 1, 1, 'Gestion de pages', 'gestion-de-pages', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', '', '', 1, 1, '0000-00-00 00:00:00', '2012-09-22 13:02:46'),
(3, 1, 1, 1, 'Catalogue de produits en ligne', 'catalogue-de-produits-en-ligne', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', '', '', 2, 1, '0000-00-00 00:00:00', '2012-09-22 13:02:49'),
(4, 1, 1, 1, 'Flux d''actualités catégorisées', 'flux-d-actualites-categorisees', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', '', '', 3, 1, '0000-00-00 00:00:00', '2012-09-22 13:02:52'),
(5, 1, 1, 1, 'Formulaire de contact', 'formulaire-de-contact', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', '', '', 4, 1, '0000-00-00 00:00:00', '2012-09-22 13:02:54'),
(6, 1, 1, 0, 'Logiciel rédaction web multilingue', 'logiciel-redaction-web-multilingue', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', '', '', 2, 1, '0000-00-00 00:00:00', '2012-09-22 17:32:30'),
(7, 1, 1, 6, 'Variables de traductions flexibles', 'variables-de-traductions-flexibles', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', '', '', 5, 1, '0000-00-00 00:00:00', '2012-09-22 18:12:11'),
(8, 1, 2, 0, 'Magix CMS: you content management system', 'magix-cms-you-content-management-system', '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', '', '', 3, 1, '0000-00-00 00:00:00', '2012-09-23 18:24:38');

-- --------------------------------------------------------

--
-- Structure de la table `mc_cms_rel_lang`
--

CREATE TABLE IF NOT EXISTS `mc_cms_rel_lang` (
  `idrel_lang` int(7) NOT NULL AUTO_INCREMENT,
  `idpage` int(7) NOT NULL,
  `idlang_p` int(7) NOT NULL,
  PRIMARY KEY (`idrel_lang`),
  KEY `idpage` (`idpage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `mc_cms_rel_lang`
--


-- --------------------------------------------------------

--
-- Structure de la table `mc_config`
--

CREATE TABLE IF NOT EXISTS `mc_config` (
  `idconfig` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `max_record` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idconfig`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

--
-- Contenu de la table `mc_config`
--

INSERT INTO `mc_config` (`idconfig`, `attr_name`, `status`, `max_record`) VALUES
(1, 'lang', 1, 0),
(2, 'cms', 1, 0),
(3, 'news', 1, 0),
(4, 'catalog', 1, 0),
(5, 'metasrewrite', 1, 0),
(6, 'plugins', 1, 0);

-- --------------------------------------------------------

--
-- Structure de la table `mc_config_size_img`
--

CREATE TABLE IF NOT EXISTS `mc_config_size_img` (
  `id_size_img` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `idconfig` tinyint(3) unsigned NOT NULL,
  `config_size_attr` varchar(40) NOT NULL,
  `width` decimal(4,0) NOT NULL,
  `height` decimal(4,0) NOT NULL,
  `type` enum('small','medium','large') NOT NULL,
  `img_resizing` enum('basic','adaptive') NOT NULL,
  PRIMARY KEY (`id_size_img`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

--
-- Contenu de la table `mc_config_size_img`
--

INSERT INTO `mc_config_size_img` (`id_size_img`, `idconfig`, `config_size_attr`, `width`, `height`, `type`, `img_resizing`) VALUES
(1, 4, 'category', 120, 100, 'small', 'basic'),
(2, 4, 'subcategory', 120, 100, 'small', 'basic'),
(3, 4, 'product', 120, 100, 'small', 'basic'),
(4, 4, 'product', 350, 250, 'medium', 'basic'),
(5, 4, 'product', 700, 700, 'large', 'basic'),
(6, 4, 'galery', 120, 100, 'small', 'basic'),
(7, 4, 'galery', 700, 700, 'large', 'basic'),
(8, 3, 'news', 120, 100, 'small', 'basic'),
(9, 3, 'news', 350, 250, 'medium', 'basic');

-- --------------------------------------------------------

--
-- Structure de la table `mc_lang`
--

CREATE TABLE IF NOT EXISTS `mc_lang` (
  `idlang` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `iso` varchar(3) NOT NULL,
  `language` varchar(30) NOT NULL,
  `default_lang` tinyint(1) NOT NULL DEFAULT '0',
  `active_lang` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idlang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `mc_lang`
--

INSERT INTO `mc_lang` (`idlang`, `iso`, `language`, `default_lang`, `active_lang`) VALUES
(1, 'fr', 'francais', 1, 1),
(2, 'en', 'Angalis', 0, 1);

-- --------------------------------------------------------

--
-- Structure de la table `mc_metas_rewrite`
--

CREATE TABLE IF NOT EXISTS `mc_metas_rewrite` (
  `idrewrite` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `attribute` varchar(40) NOT NULL,
  `idlang` tinyint(3) NOT NULL DEFAULT '0',
  `strrewrite` tinytext,
  `idmetas` tinyint(1) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idrewrite`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

--
-- Contenu de la table `mc_metas_rewrite`
--


-- --------------------------------------------------------

--
-- Structure de la table `mc_news`
--

CREATE TABLE IF NOT EXISTS `mc_news` (
  `idnews` int(7) NOT NULL AUTO_INCREMENT,
  `keynews` varchar(40) NOT NULL,
  `n_uri` varchar(125) NOT NULL,
  `idadmin` tinyint(1) NOT NULL,
  `idlang` tinyint(3) NOT NULL,
  `n_title` varchar(125) NOT NULL,
  `n_image` varchar(25) DEFAULT NULL,
  `n_content` text NOT NULL,
  `date_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_publish` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idnews`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Contenu de la table `mc_news`
--

INSERT INTO `mc_news` (`idnews`, `keynews`, `n_uri`, `idadmin`, `idlang`, `n_title`, `n_image`, `n_content`, `date_register`, `date_publish`, `published`) VALUES
(1, 'mNOLy8BtvE02sJ2pfjEr', 'magix-cms-2-3-6-disponible', 1, 1, 'Magix CMS 2.3.6 Disponible', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', '2012-09-22 14:44:18', '2012-09-22 13:10:19', 1),
(2, 'vtSaejymFKeLEhpqvNGN', 'magix-cms-sur-github', 1, 1, 'Magix CMS sur GitHub', NULL, '<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>', '2012-09-22 14:44:30', '2012-09-22 14:44:41', 1);

-- --------------------------------------------------------

--
-- Structure de la table `mc_news_tag`
--

CREATE TABLE IF NOT EXISTS `mc_news_tag` (
  `idnews_tag` int(7) NOT NULL AUTO_INCREMENT,
  `name_tag` varchar(50) NOT NULL,
  `idnews` int(7) NOT NULL,
  PRIMARY KEY (`idnews_tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `mc_news_tag`
--

INSERT INTO `mc_news_tag` (`idnews_tag`, `name_tag`, `idnews`) VALUES
(1, 'upgrade', 1),
(2, 'version', 1),
(3, '100% magix', 1),
(4, 'upgrade', 2),
(5, 'github', 2);

-- --------------------------------------------------------

--
-- Structure de la table `mc_page_home`
--

CREATE TABLE IF NOT EXISTS `mc_page_home` (
  `idhome` tinyint(1) NOT NULL AUTO_INCREMENT,
  `subject` varchar(125) NOT NULL,
  `content` text NOT NULL,
  `metatitle` varchar(150) DEFAULT NULL,
  `metadescription` varchar(180) DEFAULT NULL,
  `idlang` tinyint(3) NOT NULL DEFAULT '0',
  `idadmin` tinyint(2) NOT NULL,
  `date_home` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idhome`),
  KEY `idlang` (`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Contenu de la table `mc_page_home`
--

INSERT INTO `mc_page_home` (`idhome`, `subject`, `content`, `metatitle`, `metadescription`, `idlang`, `idadmin`, `date_home`) VALUES
(1, 'Magix CMS: Logiciel de gestion de site internet', '', '', '', 1, 1, '2012-08-21 21:07:49');

-- --------------------------------------------------------

--
-- Structure de la table `mc_setting`
--

CREATE TABLE IF NOT EXISTS `mc_setting` (
  `setting_id` varchar(255) NOT NULL,
  `setting_value` text,
  `setting_type` varchar(8) NOT NULL DEFAULT 'string',
  `setting_label` text,
  KEY `setting_id` (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `mc_setting`
--

INSERT INTO `mc_setting` (`setting_id`, `setting_value`, `setting_type`, `setting_label`) VALUES
('theme', 'bootstrap', 'string', 'site theme'),
('microgalery', 'default', 'string', 'micro galery'),
('webmaster', '', 'string', 'google webmasterTools'),
('analytics', '', 'string', 'google analytics'),
('editor', 'pdw_file_browser', 'string', 'tinymce'),
('magix_version', '2.3.5', 'string', 'Version Magix CMS');

--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `mc_catalog_img`
--
ALTER TABLE `mc_catalog_img`
  ADD CONSTRAINT `mc_catalog_img_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`);

--
-- Contraintes pour la table `mc_catalog_product`
--
ALTER TABLE `mc_catalog_product`
  ADD CONSTRAINT `mc_catalog_product_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`),
  ADD CONSTRAINT `mc_catalog_product_ibfk_2` FOREIGN KEY (`idclc`) REFERENCES `mc_catalog_c` (`idclc`);

--
-- Contraintes pour la table `mc_catalog_rel_product`
--
ALTER TABLE `mc_catalog_rel_product`
  ADD CONSTRAINT `mc_catalog_rel_product_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`),
  ADD CONSTRAINT `mc_catalog_rel_product_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `mc_catalog_product` (`idproduct`) ON DELETE CASCADE;

--
-- Contraintes pour la table `mc_catalog_s`
--
ALTER TABLE `mc_catalog_s`
  ADD CONSTRAINT `mc_catalog_s_ibfk_1` FOREIGN KEY (`idclc`) REFERENCES `mc_catalog_c` (`idclc`);
