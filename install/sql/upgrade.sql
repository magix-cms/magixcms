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
  PRIMARY KEY (`idconfig`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=7 ;

INSERT INTO `mc_config` (`idconfig`, `attr_name`, `status`) VALUES
(1, 'lang', 1),
(2, 'cms', 1),
(3, 'news', 1),
(4, 'catalog', 1),
(5, 'metasrewrite', 1),
(6, 'plugins', 1);

CREATE TABLE IF NOT EXISTS `mc_config_size_img` (
  `id_size_img` tinyint(3) NOT NULL AUTO_INCREMENT,
  `idconfig` tinyint(3) NOT NULL,
  `name_size` varchar(40) NOT NULL,
  `num_size` decimal(4,0) NOT NULL,
  PRIMARY KEY (`id_size_img`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=15 ;

INSERT INTO `mc_config_size_img` VALUES
(1, 4, 'size_w_cat', 120),
(2, 4, 'size_h_cat', 100),
(3, 4, 'size_w_subcat', 120),
(4, 4, 'size_h_subcat', 100),
(5, 4, 'size_w_small_product', 120),
(6, 4, 'size_h_small_product', 100),
(7, 4, 'size_w_medium_product', 350),
(8, 4, 'size_h_medium_product', 250),
(9, 4, 'size_w_large_product', 700),
(10, 4, 'size_h_large_product', 700),
(11, 4, 'size_w_small_microgalery', 120),
(12, 4, 'size_h_small_microgalery', 100),
(13, 4, 'size_w_large_microgalery', 700),
(14, 4, 'size_h_large_microgalery', 700);