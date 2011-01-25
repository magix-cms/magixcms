ALTER TABLE `mc_catalog_c` ADD `c_content` TEXT NULL AFTER `img_c` 
ALTER TABLE `mc_catalog_s` ADD `s_content` TEXT NULL AFTER `img_s` 
INSERT INTO `magixcms`.`mc_setting` (
`setting_id` ,
`setting_value` ,
`setting_type` ,
`setting_label`
)
VALUES (
'magix_version', '2.3.42b', 'string', 'Version Magix CMS'
);