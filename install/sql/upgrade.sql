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
'magix_version', '2.3.43', 'string', 'Version Magix CMS'
);

DROP TABLE `mc_global_config` ;

ALTER TABLE `mc_metas_rewrite` DROP `idconfig` ;

ALTER TABLE `mc_metas_rewrite` ADD `attribute` VARCHAR( 40 ) NOT NULL AFTER `idrewrite` ;

ALTER TABLE `mc_lang` ADD `default` TINYINT( 1 ) NOT NULL DEFAULT '0' ;

ALTER TABLE `mc_config_limited_module` DROP FOREIGN KEY `mc_config_limited_module_ibfk_1` ;

ALTER TABLE `mc_config_limited_module` CHANGE `idconfig` `attribute` VARCHAR( 40 ) NOT NULL ;

UPDATE `cms`.`mc_config_limited_module` SET `attribute` = 'cms' WHERE `mc_config_limited_module`.`attribute` = '1';

DELETE FROM `cms`.`mc_config_limited_module` WHERE `mc_config_limited_module`.`attribute` = '2';

DELETE FROM `cms`.`mc_config_limited_module` WHERE `mc_config_limited_module`.`attribute` = '3';

DELETE FROM `cms`.`mc_config_limited_module` WHERE `mc_config_limited_module`.`attribute` = '4';