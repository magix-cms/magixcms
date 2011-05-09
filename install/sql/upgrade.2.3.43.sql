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