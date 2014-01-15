ALTER TABLE `mc_catalog_rel_product` DROP FOREIGN KEY `mc_catalog_rel_product_ibfk_1` ;

ALTER TABLE `mc_catalog_rel_product` DROP FOREIGN KEY `mc_catalog_rel_product_ibfk_2` ;

ALTER TABLE `mc_catalog_product` DROP FOREIGN KEY `mc_catalog_product_ibfk_1` ;

ALTER TABLE `mc_catalog_product` DROP FOREIGN KEY `mc_catalog_product_ibfk_2` ;

ALTER TABLE `mc_catalog_img` DROP FOREIGN KEY `mc_catalog_img_ibfk_1` ;

ALTER TABLE `mc_catalog_s` DROP FOREIGN KEY `mc_catalog_s_ibfk_1` ;

ALTER TABLE `mc_admin_session` DROP FOREIGN KEY `mc_admin_session_ibfk_1` ;

ALTER TABLE `mc_plugins_contact` DROP FOREIGN KEY `mc_plugins_contact_ibfk_3` ;

ALTER TABLE `mc_page_home` CHANGE `idhome` `idhome` SMALLINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE `subject` `subject` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `content` `content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `metatitle` `metatitle` VARCHAR( 180 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `metadescription` `metadescription` VARCHAR( 180 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `idlang` `idlang` SMALLINT( 3 ) UNSIGNED NOT NULL DEFAULT '1',
CHANGE `idadmin` `idadmin` SMALLINT( 5 ) UNSIGNED NOT NULL ,
CHANGE `date_home` `date_home` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP;

ALTER TABLE `mc_lang` CHANGE `idlang` `idlang` SMALLINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE `iso` `iso` VARCHAR( 10 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `language` `language` VARCHAR( 40 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL ,
CHANGE `default_lang` `default_lang` SMALLINT( 1 ) UNSIGNED NOT NULL DEFAULT '0',
CHANGE `active_lang` `active_lang` SMALLINT( 1 ) UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE `mc_cms_pages` CHANGE `idadmin` `idadmin` SMALLINT( 5 ) UNSIGNED NOT NULL ,
CHANGE `idlang` `idlang` SMALLINT( 3 ) UNSIGNED NOT NULL DEFAULT '1',
CHANGE `title_page` `title_page` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `uri_page` `uri_page` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `seo_title_page` `seo_title_page` VARCHAR( 180 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `seo_desc_page` `seo_desc_page` VARCHAR( 180 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
CHANGE `sidebar_page` `sidebar_page` SMALLINT( 1 ) UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE `mc_news` CHANGE `idadmin` `idadmin` SMALLINT( 5 ) UNSIGNED NOT NULL ,
CHANGE `idlang` `idlang` SMALLINT( 3 ) UNSIGNED NOT NULL DEFAULT '1',
CHANGE `n_content` `n_content` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NULL,
CHANGE `published` `published` SMALLINT( 1 ) UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE `mc_admin_member` CHANGE `idadmin` `idadmin` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `mc_admin_session` CHANGE `sid` `sid` VARCHAR( 150 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
CHANGE `userid` `userid` SMALLINT( 5 ) UNSIGNED NOT NULL;

CREATE TABLE IF NOT EXISTS `mc_admin_role_user` (
  `id_role` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `role_name` varchar(50) NOT NULL,
  PRIMARY KEY (`id_role`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_admin_role_user` VALUES
(NULL, 'administrator'),
(NULL, 'editor'),
(NULL, 'author'),
(NULL, 'contributor');

ALTER TABLE `mc_admin_member` ADD `id_role` SMALLINT( 3 ) UNSIGNED NOT NULL DEFAULT '1' AFTER `idadmin`;

DROP TABLE IF EXISTS `mc_admin_perms`;

ALTER TABLE `mc_catalog_c` CHANGE `idlang` `idlang` SMALLINT( 3 ) UNSIGNED NOT NULL DEFAULT '1';

ALTER TABLE `mc_catalog` CHANGE `idlang` `idlang` SMALLINT( 3 ) UNSIGNED NOT NULL DEFAULT '1',
CHANGE `idadmin` `idadmin` SMALLINT( 5 ) UNSIGNED NOT NULL ,
CHANGE `publish` `publish` SMALLINT( 1 ) UNSIGNED NOT NULL DEFAULT '1';

ALTER TABLE `mc_config` CHANGE `idconfig` `idconfig` SMALLINT( 3 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE `status` `status` SMALLINT( 1 ) UNSIGNED NOT NULL DEFAULT '0';

ALTER TABLE `mc_config` DROP `max_record` ;

ALTER TABLE `mc_config_size_img` CHANGE `idconfig` `idconfig` SMALLINT( 3 ) UNSIGNED NOT NULL;

ALTER TABLE `mc_setting` DROP INDEX `setting_id`;

ALTER TABLE `mc_setting` ADD `id_setting` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT PRIMARY KEY FIRST;

DELETE FROM `mc_setting` WHERE `setting_id` = 'microgalery';

UPDATE `mc_setting` SET `setting_value` = 'openFilemanager' WHERE `setting_id` = 'editor';

UPDATE `mc_setting` SET `setting_value` = '2.4.2' WHERE `setting_id` = 'magix_version';

INSERT INTO `mc_setting` VALUES
(NULL, 'content_css', NULL, 'string', NULL),
(NULL, 'concat', '0' , 'string', NULL),
(NULL, 'cache', 'none' , 'string', NULL),
(NULL, 'googleplus', NULL , 'string', 'Google plus'),
(NULL, 'robots', 'noindex,nofollow', 'string', 'metas robots');

ALTER TABLE `mc_catalog` ADD `imgcatalog` VARCHAR( 125 ) NULL AFTER `titlecatalog`;

ALTER TABLE `mc_catalog` DROP `ordercatalog`;

ALTER TABLE `mc_plugins_contact` CHANGE `idcontact` `idcontact` SMALLINT( 5 ) UNSIGNED NOT NULL AUTO_INCREMENT ,
CHANGE `idadmin` `idlang` SMALLINT( 3 ) UNSIGNED NOT NULL ,
CHANGE `idlang` `mail_contact` VARCHAR( 45 ) NOT NULL;