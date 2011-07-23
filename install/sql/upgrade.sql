ALTER TABLE `mc_catalog_c` ADD `c_content` TEXT NULL AFTER `img_c` ;

ALTER TABLE `mc_catalog_s` ADD `s_content` TEXT NULL AFTER `img_s` ;

ALTER TABLE `mc_metas_rewrite` CHANGE `strrewrite` `strrewrite` TINYTEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ;

INSERT INTO `mc_setting` (
`setting_id` ,
`setting_value` ,
`setting_type` ,
`setting_label`
)
VALUES (
'magix_version', '2.3.44', 'string', 'Version Magix CMS'
);

ALTER TABLE `mc_metas_rewrite` DROP FOREIGN KEY `mc_metas_rewrite_ibfk_1` ;

ALTER TABLE `mc_config_limited_module` DROP FOREIGN KEY `mc_config_limited_module_ibfk_1` ;

ALTER TABLE `mc_metas_rewrite` DROP `idconfig` ;

ALTER TABLE `mc_metas_rewrite` ADD `attribute` VARCHAR( 40 ) NOT NULL AFTER `idrewrite` ;

ALTER TABLE `mc_lang` ADD `default` TINYINT( 1 ) NOT NULL DEFAULT '0' ;

ALTER TABLE `mc_config_limited_module` CHANGE `idconfig` `attribute` VARCHAR( 40 ) NOT NULL ;

UPDATE `mc_config_limited_module` SET `attribute` = 'cms' WHERE `mc_config_limited_module`.`attribute` = '1';

DELETE FROM `mc_config_limited_module` WHERE `mc_config_limited_module`.`attribute` = '2';

DELETE FROM `mc_config_limited_module` WHERE `mc_config_limited_module`.`attribute` = '3';

DELETE FROM `mc_config_limited_module` WHERE `mc_config_limited_module`.`attribute` = '4';

DROP TABLE `mc_global_config` ;

CREATE TABLE IF NOT EXISTS `mc_config` (
  `idconfig` tinyint(3) NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  `max_record` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idconfig`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `mc_config` (`idconfig`, `attr_name`, `status`, `max_record`) VALUES
(1, 'lang', 1, 0),
(2, 'cms', 1, 0),
(3, 'news', 1, 0),
(4, 'catalog', 1, 0),
(5, 'metasrewrite', 1, 0),
(6, 'plugins', 1, 0);

CREATE TABLE IF NOT EXISTS `mc_config_size_img` (
  `id_size_img` smallint(5) NOT NULL AUTO_INCREMENT,
  `idconfig` tinyint(3) NOT NULL,
  `config_size_attr` varchar(40) NOT NULL,
  `width` decimal(4,0) NOT NULL,
  `height` decimal(4,0) NOT NULL,
  `type` enum('small','medium','large') NOT NULL,
  `img_resizing` enum('basic','adaptive') NOT NULL,
  PRIMARY KEY (`id_size_img`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

INSERT INTO `mc_config_size_img` (`id_size_img`, `idconfig`, `config_size_attr`, `width`, `height`, `type`, `img_resizing`) VALUES
(1, 4, 'category', '120', '100', 'small', 'basic'),
(2, 4, 'subcategory', '120', '100', 'small', 'basic'),
(3, 4, 'product', '120', '100', 'small', 'basic'),
(4, 4, 'product', '350', '250', 'medium', 'basic'),
(5, 4, 'product', '700', '700', 'large', 'basic'),
(6, 4, 'galery', '120', '100', 'small', 'basic'),
(7, 4, 'galery', '700', '700', 'large', 'basic'),
(8, 3, 'news', '120', '100', 'small', 'basic'),
(9, 3, 'news', '350', '250', 'medium', 'basic');

DROP TABLE `mc_lang`

CREATE TABLE IF NOT EXISTS `mc_lang` (
  `idlang` tinyint(3) NOT NULL AUTO_INCREMENT,
  `iso` varchar(3) NOT NULL,
  `language` varchar(30) NOT NULL,
  `default_lang` tinyint(1) NOT NULL DEFAULT '0',
  `active_lang` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idlang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

INSERT INTO `mc_lang` VALUES(1, 'fr', 'francais', 1, 1);

DROP TABLE `mc_news_publication`;

DROP TABLE `mc_news`;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_news_tag` (
  `idnews_tag` int(7) NOT NULL AUTO_INCREMENT,
  `name_tag` varchar(50) NOT NULL,
  `idnews` int(7) NOT NULL,
  PRIMARY KEY (`idnews_tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;