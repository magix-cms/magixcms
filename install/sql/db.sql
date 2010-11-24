CREATE TABLE IF NOT EXISTS `mc_admin_member` (
  `idadmin` tinyint(2) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) NOT NULL,
  `email` varchar(40) NOT NULL,
  `cryptpass` varchar(50) NOT NULL,
  PRIMARY KEY (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_admin_perms` (
  `idadmin` tinyint(2) NOT NULL AUTO_INCREMENT,
  `perms` tinyint(1) NOT NULL,
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_admin_session` (
  `sid` tinytext NOT NULL,
  `userid` tinyint(2) NOT NULL,
  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `ip` varchar(20) NOT NULL,
  `browser` varchar(50) DEFAULT NULL,
  KEY `userid` (`userid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog` (
  `idcatalog` int(6) NOT NULL AUTO_INCREMENT,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_c` (
  `idclc` tinyint(3) NOT NULL AUTO_INCREMENT,
  `clibelle` varchar(125) NOT NULL,
  `pathclibelle` varchar(125) NOT NULL,
  `img_c` varchar(125) DEFAULT NULL,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `corder` tinyint(3) NOT NULL,
  PRIMARY KEY (`idclc`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_galery` (
  `idmicro` int(6) NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) NOT NULL,
  `imgcatalog` varchar(125) NOT NULL,
  PRIMARY KEY (`idmicro`),
  KEY `idcatalog` (`idcatalog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_img` (
  `idcatalog` int(6) NOT NULL,
  `imgcatalog` varchar(125) NOT NULL,
  PRIMARY KEY (`idcatalog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_product` (
  `idproduct` int(6) NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) NOT NULL,
  `idclc` tinyint(3) NOT NULL,
  `idcls` tinyint(3) NOT NULL DEFAULT '0',
  `orderproduct` int(6) NOT NULL,
  PRIMARY KEY (`idproduct`),
  KEY `idclc` (`idclc`),
  KEY `idcatalog` (`idcatalog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_rel_product` (
  `idrelproduct` int(6) NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) NOT NULL,
  `idproduct` int(6) NOT NULL,
  PRIMARY KEY (`idrelproduct`),
  KEY `idcatalog` (`idcatalog`),
  KEY `idproduct` (`idproduct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_catalog_s` (
  `idcls` tinyint(3) NOT NULL AUTO_INCREMENT,
  `slibelle` varchar(125) NOT NULL,
  `pathslibelle` varchar(125) NOT NULL,
  `img_s` varchar(125) DEFAULT NULL,
  `idclc` tinyint(3) NOT NULL,
  `sorder` tinyint(3) NOT NULL,
  PRIMARY KEY (`idcls`),
  KEY `idclc` (`idclc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_cms_category` (
  `idcategory` tinyint(3) NOT NULL AUTO_INCREMENT,
  `category` varchar(100) DEFAULT NULL,
  `pathcategory` varchar(100) DEFAULT NULL,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `idorder` tinyint(2) NOT NULL,
  PRIMARY KEY (`idcategory`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_cms_page` (
  `idpage` smallint(6) NOT NULL AUTO_INCREMENT,
  `idcategory` tinyint(3) NOT NULL DEFAULT '0',
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `pathpage` varchar(125) NOT NULL,
  `subjectpage` varchar(125) NOT NULL,
  `contentpage` text,
  `idadmin` tinyint(2) NOT NULL,
  `metatitle` varchar(150) DEFAULT NULL,
  `metadescription` varchar(180) DEFAULT NULL,
  `orderpage` smallint(6) NOT NULL,
  `viewpage` tinyint(1) NOT NULL,
  `date_page` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpage`),
  KEY `idcategory` (`idcategory`,`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_config_limited_module` (
  `idconfig` tinyint(1) NOT NULL,
  `number` tinyint(1) NOT NULL,
  PRIMARY KEY (`idconfig`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mc_config_limited_module` (`idconfig`, `number`) VALUES
(1, 0),
(2, 0),
(3, 0),
(4, 0);

CREATE TABLE IF NOT EXISTS `mc_forms` (
  `idforms` tinyint(3) NOT NULL AUTO_INCREMENT,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `urlforms` varchar(50) NOT NULL,
  `titleforms` varchar(50) NOT NULL,
  PRIMARY KEY (`idforms`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_forms_input` (
  `idinput` mediumint(7) NOT NULL AUTO_INCREMENT,
  `idforms` tinyint(3) NOT NULL,
  `label` varchar(20) NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT '1',
  `nameinput` varchar(20) NOT NULL,
  `required` tinyint(1) NOT NULL DEFAULT '0',
  `size` decimal(10,0) DEFAULT NULL,
  `maxlength` decimal(10,0) DEFAULT NULL,
  `value` text,
  PRIMARY KEY (`idinput`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_global_config` (
  `idconfig` tinyint(1) NOT NULL AUTO_INCREMENT,
  `named` varchar(20) NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idconfig`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

INSERT INTO `mc_global_config` (`idconfig`, `named`, `status`) VALUES
(1, 'lang', 1),
(2, 'cms', 1),
(3, 'news', 1),
(4, 'catalog', 1),
(5, 'rewritenews', 1),
(6, 'rewritecms', 1),
(7, 'rewritecatalog', 1),
(8, 'forms', 0),
(9, 'microgalery', 1);

CREATE TABLE IF NOT EXISTS `mc_lang` (
  `idlang` tinyint(4) NOT NULL AUTO_INCREMENT,
  `codelang` varchar(2) NOT NULL,
  `desclang` varchar(20) NOT NULL,
  PRIMARY KEY (`idlang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_metas_rewrite` (
  `idrewrite` tinyint(2) NOT NULL AUTO_INCREMENT,
  `idconfig` tinyint(1) NOT NULL,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `strrewrite` varchar(255) DEFAULT NULL,
  `idmetas` tinyint(1) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idrewrite`),
  KEY `idlang` (`idlang`),
  KEY `idconfig` (`idconfig`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_news` (
  `idnews` tinyint(3) NOT NULL AUTO_INCREMENT,
  `subject` varchar(125) NOT NULL,
  `rewritelink` varchar(125) NOT NULL,
  `content` text NOT NULL,
  `idlang` tinyint(1) NOT NULL,
  `idadmin` tinyint(2) NOT NULL,
  `date_sent` date NOT NULL,
  `postdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idnews`),
  KEY `idlang` (`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_news_publication` (
  `idnews` tinyint(3) NOT NULL AUTO_INCREMENT,
  `date_publication` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `publish` tinyint(4) NOT NULL DEFAULT '0',
  KEY `idnews` (`idnews`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_page_home` (
  `idhome` tinyint(1) NOT NULL AUTO_INCREMENT,
  `subject` varchar(125) NOT NULL,
  `content` text NOT NULL,
  `metatitle` varchar(150) DEFAULT NULL,
  `metadescription` varchar(180) DEFAULT NULL,
  `idlang` tinyint(1) NOT NULL DEFAULT '0',
  `idadmin` tinyint(2) NOT NULL,
  `date_home` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idhome`),
  KEY `idlang` (`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_page_home_config` (
  `idhome` tinyint(4) NOT NULL,
  `slideshow` tinyint(1) NOT NULL DEFAULT '0',
  `news` tinyint(1) NOT NULL DEFAULT '0',
  KEY `idhome` (`idhome`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_setting` (
  `setting_id` varchar(255) NOT NULL,
  `setting_value` text,
  `setting_type` varchar(8) NOT NULL DEFAULT 'string',
  `setting_label` text,
  KEY `setting_id` (`setting_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

INSERT INTO `mc_setting` (`setting_id`, `setting_value`, `setting_type`, `setting_label`) VALUES
('theme', 'default', 'string', 'site theme'),
('microgalery', 'default', 'string', 'micro galery'),
('sold', 'sold_product', 'string', 'Produit vendu'),
('webmaster', '', 'string', 'google webmasterTools'),
('analytics', '', 'string', 'google analytics'),
('editor', 'pdw_file_browser', 'string', 'tinymce');

ALTER TABLE `mc_admin_session`
  ADD CONSTRAINT `mc_admin_session_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `mc_admin_member` (`idadmin`);

ALTER TABLE `mc_catalog_img`
  ADD CONSTRAINT `mc_catalog_img_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`);

ALTER TABLE `mc_catalog_product`
  ADD CONSTRAINT `mc_catalog_product_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`),
  ADD CONSTRAINT `mc_catalog_product_ibfk_2` FOREIGN KEY (`idclc`) REFERENCES `mc_catalog_c` (`idclc`);

ALTER TABLE `mc_catalog_rel_product`
  ADD CONSTRAINT `mc_catalog_rel_product_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`),
  ADD CONSTRAINT `mc_catalog_rel_product_ibfk_2` FOREIGN KEY (`idproduct`) REFERENCES `mc_catalog_product` (`idproduct`) ON DELETE CASCADE;

ALTER TABLE `mc_catalog_s`
  ADD CONSTRAINT `mc_catalog_s_ibfk_1` FOREIGN KEY (`idclc`) REFERENCES `mc_catalog_c` (`idclc`);

ALTER TABLE `mc_cms_page`
  ADD CONSTRAINT `mc_cms_page_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `mc_admin_member` (`idadmin`);

ALTER TABLE `mc_config_limited_module`
  ADD CONSTRAINT `mc_config_limited_module_ibfk_1` FOREIGN KEY (`idconfig`) REFERENCES `mc_global_config` (`idconfig`);

ALTER TABLE `mc_metas_rewrite`
  ADD CONSTRAINT `mc_metas_rewrite_ibfk_1` FOREIGN KEY (`idconfig`) REFERENCES `mc_global_config` (`idconfig`);

ALTER TABLE `mc_news`
  ADD CONSTRAINT `mc_news_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `mc_admin_member` (`idadmin`);

ALTER TABLE `mc_news_publication`
  ADD CONSTRAINT `mc_news_publication_ibfk_1` FOREIGN KEY (`idnews`) REFERENCES `mc_news` (`idnews`);

ALTER TABLE `mc_page_home_config`
  ADD CONSTRAINT `mc_page_home_config_ibfk_1` FOREIGN KEY (`idhome`) REFERENCES `mc_page_home` (`idhome`);