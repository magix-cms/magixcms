UPDATE `mc_setting` SET `setting_value` = '2.6.6' WHERE `setting_id` = 'magix_version';

CREATE TABLE IF NOT EXISTS `mc_country` (
  `idcountry` int(5) unsigned NOT NULL AUTO_INCREMENT,
  `iso` varchar(5) NOT NULL,
  `country` varchar(125) NOT NULL,
  `order` int(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`idcountry`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_module` (`id_module` ,`class_name` ,`name` ,`plugins`)VALUES (NULL , 'backend_controller_country', 'country', '0');
ALTER TABLE `mc_catalog` DROP `idadmin` ;