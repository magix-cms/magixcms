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

CREATE TABLE IF NOT EXISTS `mc_admin_access_rel` (
  `id_access_rel` int(7) unsigned NOT NULL AUTO_INCREMENT,
  `id_admin` smallint(5) unsigned NOT NULL,
  `id_role` smallint(5) unsigned NOT NULL,
  PRIMARY KEY (`id_access_rel`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

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

INSERT INTO `mc_admin_access_rel` (`id_access_rel`, `id_admin`, `id_role`) VALUES
(NULL, 1, 1);

TRUNCATE TABLE `mc_admin_session` ;

ALTER TABLE `mc_admin_session` CHANGE `sid` `id_admin_session` VARCHAR(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `userid` `id_admin` SMALLINT(5) UNSIGNED NOT NULL ,
CHANGE `last_modified` `keyuniqid_admin` VARCHAR( 50 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `ip` `ip_session` VARCHAR(25) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `browser` `browser_admin` VARCHAR(50) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `keyuniqid` `last_modified_session` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ;

UPDATE `mc_setting` SET `setting_value` = '2.6.0' WHERE `setting_id` = 'magix_version';