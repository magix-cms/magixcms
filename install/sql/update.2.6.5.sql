ALTER TABLE `mc_catalog_galery` ADD `img_order` INT( 6 ) UNSIGNED NOT NULL DEFAULT '0';
UPDATE `mc_setting` SET `setting_value` = '2.6.5' WHERE `setting_id` = 'magix_version';