UPDATE `mc_setting` SET `setting_value` = '2.7.0' WHERE `setting_id` = 'magix_version';

CREATE TABLE IF NOT EXISTS `mc_country` (
  `idcountry` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `iso` varchar(5) NOT NULL,
  `country` varchar(125) NOT NULL,
  `order_c` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idcountry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_module` (`id_module` ,`class_name` ,`name` ,`plugins`) VALUES (NULL , 'backend_controller_country', 'country', '0');

ALTER TABLE `mc_catalog` DROP `idadmin` ;

CREATE TABLE IF NOT EXISTS `mc_webservice` (
  `idwskey` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `ws_key` varchar(125) DEFAULT NULL,
  `status_key` smallint(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idwskey`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_setting` VALUES (NULL, 'css_inliner', '1', 'string', 'CSS inliner');

CREATE TABLE IF NOT EXISTS `mc_css_inliner_color` (
  `id_cssi` int(6) unsigned NOT NULL AUTO_INCREMENT,
  `property_cssi` varchar(125) NOT NULL,
  `color_cssi` varchar(50) NOT NULL,
  PRIMARY KEY (`id_cssi`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_css_inliner_color` (`id_cssi`, `property_cssi`, `color_cssi`) VALUES
(NULL, 'header_bg', '#f2f2f2'),
(NULL, 'header_c', '#ffffff'),
(NULL, 'footer_bg', '#333333'),
(NULL, 'footer_c', '#ffffff');

CREATE TABLE IF NOT EXISTS `mc_plugins_contact_config` (
  `idcontact_config` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `address_enabled` smallint(3) unsigned NOT NULL,
  `address_required` smallint(3) unsigned NOT NULL,
  PRIMARY KEY (`idcontact_config`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_plugins_contact_config` (`address_enabled`, `address_required`) VALUES (0, 0);

CREATE TABLE IF NOT EXISTS `mc_plugins_about_data` (
  `iddata` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `idlang` smallint(3) unsigned NOT NULL,
  `info_name` varchar(30) DEFAULT NULL,
  `value` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`iddata`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_plugins_about_data` (`iddata`, `idlang`, `info_name`, `value`) VALUES
(NULL, 1, 'desc', NULL),
(NULL, 1, 'slogan', NULL);