CREATE TABLE IF NOT EXISTS `mc_admin_employee` (
  `id_admin` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `keyuniqid_admin` varchar(50) NOT NULL,
  `lastname_admin` varchar(50) DEFAULT NULL,
  `firstname_admin` varchar(50) DEFAULT NULL,
  `pseudo_admin` varchar(50) NOT NULL,
  `email_admin` varchar(150) NOT NULL,
  `passwd_admin` varchar(80) NOT NULL,
  `last_change_admin` timestamp NULL DEFAULT NULL,
  `active_admin` smallint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_admin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_admin_role_user` (
  `id_role` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_admin_role_user` VALUES
(NULL, 'administrator'),
(NULL, 'editor'),
(NULL, 'author'),
(NULL, 'contributor');

CREATE TABLE IF NOT EXISTS `mc_admin_access_rel` (
  `id_access_rel` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `id_admin` smallint(5) unsigned NOT NULL,
  `id_role` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id_access_rel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_admin_session` (
  `id_admin_session` varchar(150) NOT NULL,
  `id_admin` smallint(5) unsigned NOT NULL,
  `keyuniqid_admin` varchar(50) NOT NULL,
  `ip_session` varchar(25) NOT NULL,
  `browser_admin` varchar(50) NOT NULL,
  `last_modified_session` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_admin_session`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `mc_module` (
  `id_module` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `class_name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `name` varchar(50) CHARACTER SET utf8 DEFAULT NULL,
  `plugins` smallint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_module`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_module` (`id_module`, `class_name`, `name`, `plugins`) VALUES
  (NULL, 'backend_controller_employee', 'employee', 0),
  (NULL, 'backend_controller_access', 'access', 0),
  (NULL, 'backend_controller_config', 'configuration', 0),
  (NULL, 'backend_controller_lang', 'lang', 0),
  (NULL, 'backend_controller_home', 'home', 0),
  (NULL, 'backend_controller_cms', 'cms', 0),
  (NULL, 'backend_controller_catalog', 'catalog', 0),
  (NULL, 'backend_controller_news', 'new', 0);


CREATE TABLE IF NOT EXISTS `mc_admin_access` (
  `id_access` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `id_role` smallint(5) unsigned NOT NULL,
  `id_module` int(7) unsigned NOT NULL,
  `view_access` smallint(2) unsigned NOT NULL DEFAULT '0',
  `add_access` smallint(2) unsigned NOT NULL DEFAULT '0',
  `edit_access` smallint(2) unsigned NOT NULL DEFAULT '0',
  `delete_access` smallint(2) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_access`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_admin_access` (`id_access`, `id_role`, `id_module`, `view_access`, `add_access`, `edit_access`, `delete_access`) VALUES
  (NULL, 1, 1, 1, 1, 1, 1),
  (NULL, 1, 2, 1, 1, 1, 1),
  (NULL, 1, 3, 1, 1, 1, 1),
  (NULL, 1, 4, 1, 1, 1, 1),
  (NULL, 1, 5, 1, 1, 1, 1),
  (NULL, 1, 6, 1, 1, 1, 1),
  (NULL, 1, 7, 1, 1, 1, 1),
  (NULL, 1, 8, 1, 1, 1, 1);

CREATE TABLE IF NOT EXISTS `mc_lang` (
  `idlang` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `iso` varchar(10) NOT NULL,
  `language` varchar(40) DEFAULT NULL,
  `default_lang` smallint(1) unsigned NOT NULL DEFAULT '0',
  `active_lang` smallint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idlang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_lang` VALUES(1, 'fr', 'francais', 1, 1);

CREATE TABLE IF NOT EXISTS `mc_catalog` (
  `idcatalog` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `idlang` smallint(3) unsigned NOT NULL DEFAULT '1',
  `idadmin` smallint(5) unsigned NOT NULL,
  `urlcatalog` varchar(125) NOT NULL,
  `titlecatalog` varchar(125) NOT NULL,
  `imgcatalog` varchar(125) DEFAULT NULL,
  `desccatalog` text,
  `price` decimal(12,2) DEFAULT NULL,
  `publish` smallint(1) unsigned NOT NULL DEFAULT '1',
  `date_catalog` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idcatalog`),
  KEY `idclc` (`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_catalog_c` (
  `idclc` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `clibelle` varchar(125) NOT NULL,
  `pathclibelle` varchar(125) NOT NULL,
  `img_c` varchar(125) DEFAULT NULL,
  `c_content` text,
  `idlang` smallint(3) unsigned NOT NULL DEFAULT '1',
  `corder` smallint(5) NOT NULL,
  PRIMARY KEY (`idclc`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_catalog_s` (
  `idcls` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `slibelle` varchar(125) NOT NULL,
  `pathslibelle` varchar(125) NOT NULL,
  `img_s` varchar(125) DEFAULT NULL,
  `s_content` text,
  `idclc` smallint(5) unsigned NOT NULL,
  `sorder` smallint(5) NOT NULL,
  PRIMARY KEY (`idcls`),
  KEY `idclc` (`idclc`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_catalog_galery` (
  `idmicro` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) unsigned NOT NULL,
  `imgcatalog` varchar(125) NOT NULL,
  `img_order` int(6) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idmicro`),
  KEY `idcatalog` (`idcatalog`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_catalog_product` (
  `idproduct` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) unsigned NOT NULL,
  `idclc` smallint(5) unsigned NOT NULL,
  `idcls` smallint(5) unsigned NOT NULL DEFAULT '0',
  `orderproduct` int(6) NOT NULL,
  PRIMARY KEY (`idproduct`),
  KEY `idclc` (`idclc`),
  KEY `idcatalog` (`idcatalog`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_catalog_rel_product` (
  `idrelproduct` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `idcatalog` int(6) unsigned NOT NULL,
  `idproduct` int(6) unsigned NOT NULL,
  PRIMARY KEY (`idrelproduct`),
  KEY `idcatalog` (`idcatalog`),
  KEY `idproduct` (`idproduct`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_cms_pages` (
  `idpage` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `idadmin` smallint(5) unsigned NOT NULL,
  `idlang` smallint(3) unsigned NOT NULL DEFAULT '1',
  `idcat_p` int(7) unsigned NOT NULL DEFAULT '0',
  `title_page` varchar(150) NOT NULL,
  `uri_page` varchar(150) NOT NULL,
  `content_page` text,
  `seo_title_page` varchar(180) DEFAULT NULL,
  `seo_desc_page` varchar(180) DEFAULT NULL,
  `order_page` smallint(5) NOT NULL DEFAULT '0',
  `sidebar_page` smallint(1) unsigned NOT NULL DEFAULT '0',
  `date_register` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `last_update` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`idpage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_cms_rel_lang` (
  `idrel_lang` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `idpage` int(7) unsigned NOT NULL,
  `idlang_p` int(7) unsigned NOT NULL,
  PRIMARY KEY (`idrel_lang`),
  KEY `idpage` (`idpage`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_page_home` (
  `idhome` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `subject` varchar(150) NOT NULL,
  `content` text,
  `metatitle` varchar(180) DEFAULT NULL,
  `metadescription` varchar(180) DEFAULT NULL,
  `idlang` smallint(3) unsigned NOT NULL DEFAULT '1',
  `idadmin` smallint(3) unsigned NOT NULL,
  `date_home` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`idhome`),
  KEY `idlang` (`idlang`),
  KEY `idadmin` (`idadmin`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_config` (
  `idconfig` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `attr_name` varchar(20) NOT NULL,
  `status` smallint(1) unsigned NOT NULL DEFAULT '0',
  `max_record` smallint(1) unsigned NOT NULL DEFAULT '0',
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
  `id_size_img` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `idconfig` smallint(3) unsigned NOT NULL,
  `config_size_attr` varchar(40) NOT NULL,
  `width` decimal(4,0) NOT NULL,
  `height` decimal(4,0) NOT NULL,
  `type` enum('small','medium','large') NOT NULL,
  `img_resizing` enum('basic','adaptive') NOT NULL,
  PRIMARY KEY (`id_size_img`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

INSERT INTO `mc_config_size_img` (`id_size_img`, `idconfig`, `config_size_attr`, `width`, `height`, `type`, `img_resizing`) VALUES
(1, 4, 'category', '480', '360', 'small', 'adaptive'),
(2, 4, 'subcategory', '480', '360', 'small', 'adaptive'),
(3, 4, 'product', '360', '270', 'small', 'adaptive'),
(4, 4, 'product', '480', '360', 'medium', 'adaptive'),
(5, 4, 'product', '900', '900', 'large', 'basic'),
(6, 4, 'galery', '360', '270', 'small', 'adaptive'),
(7, 4, 'galery', '700', '700', 'large', 'basic'),
(8, 3, 'news', '360', '270', 'small', 'adaptive'),
(9, 3, 'news', '480', '360', 'medium', 'basic');

CREATE TABLE IF NOT EXISTS `mc_metas_rewrite` (
  `idrewrite` smallint(4) unsigned NOT NULL AUTO_INCREMENT,
  `attribute` varchar(40) NOT NULL,
  `idlang` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `strrewrite` tinytext,
  `idmetas` tinyint(1) NOT NULL,
  `level` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idrewrite`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_news` (
  `idnews` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `keynews` varchar(40) NOT NULL,
  `n_uri` varchar(125) NOT NULL,
  `idadmin` tinyint(1) NOT NULL,
  `idlang` tinyint(3) unsigned NOT NULL DEFAULT '1',
  `n_title` varchar(125) NOT NULL,
  `n_image` varchar(25) DEFAULT NULL,
  `n_content` text NOT NULL,
  `date_register` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `date_publish` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
  `published` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`idnews`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_news_tag` (
  `idnews_tag` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `name_tag` varchar(50) NOT NULL,
  `idnews` int(7) unsigned NOT NULL,
  PRIMARY KEY (`idnews_tag`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_setting` (
  `id_setting` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `setting_id` varchar(255) NOT NULL,
  `setting_value` text,
  `setting_type` varchar(8) NOT NULL DEFAULT 'string',
  `setting_label` text,
  PRIMARY KEY (`id_setting`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_setting` VALUES
(NULL, 'theme', 'default', 'string', 'site theme'),
(NULL, 'webmaster', '', 'string', 'google webmasterTools'),
(NULL, 'analytics', '', 'string', 'google analytics'),
(NULL, 'editor', 'openFilemanager', 'string', 'tinymce'),
(NULL, 'magix_version', '2.6.5', 'string', 'Version Magix CMS'),
(NULL, 'content_css', NULL, 'string', NULL),
(NULL, 'concat', '0' , 'string', NULL),
(NULL, 'cache', 'none' , 'string', NULL),
(NULL, 'googleplus', NULL , 'string', 'Google plus'),
(NULL, 'robots', 'noindex,nofollow', 'string', 'metas robots');