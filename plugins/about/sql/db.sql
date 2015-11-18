CREATE TABLE IF NOT EXISTS `mc_plugins_about` (
  `idinfo` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `info_name` varchar(30) NOT NULL,
  `value` varchar(255) default NULL,
  PRIMARY KEY (`idinfo`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_plugins_about` (`idinfo`, `info_name`, `value`) VALUES
(NULL, 'name', NULL),
(NULL, 'type', 'org'),
(NULL, 'eshop', '0'),
(NULL, 'tva', NULL),
(NULL, 'adress', NULL),
(NULL, 'street', NULL),
(NULL, 'postcode', NULL),
(NULL, 'city', NULL),
(NULL, 'mail', NULL),
(NULL, 'click_to_mail', '0'),
(NULL, 'crypt_mail', '1'),
(NULL, 'phone', NULL),
(NULL, 'mobile', NULL),
(NULL, 'fax', NULL),
(NULL, 'languages', 'French'),
(NULL, 'facebook', NULL),
(NULL, 'twitter', NULL),
(NULL, 'google', NULL),
(NULL, 'linkedin', NULL),
(NULL, 'viadeo', NULL),
(NULL, 'openinghours', '0');

CREATE TABLE IF NOT EXISTS `mc_plugins_about_op` (
  `idday` smallint(2) unsigned NOT NULL AUTO_INCREMENT,
  `day_abbr` varchar(2) NOT NULL,
  `open_day` smallint(1) unsigned default 0,
  `noon_time` smallint(1) unsigned default 0,
  `open_time` varchar(5) default NULL,
  `close_time` varchar(5) default NULL,
  `noon_start` varchar(5) default NULL,
  `noon_end` varchar(5) default NULL,
  PRIMARY KEY (`idday`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_plugins_about_op` (`idday`, `day_abbr`, `open_day`, `noon_time`, `open_time`, `close_time`, `noon_start`, `noon_end`) VALUES
(NULL, 'Mo', '0', '0', NULL, NULL, NULL, NULL),
(NULL, 'Tu', '0', '0', NULL, NULL, NULL, NULL),
(NULL, 'We', '0', '0', NULL, NULL, NULL, NULL),
(NULL, 'Th', '0', '0', NULL, NULL, NULL, NULL),
(NULL, 'Fr', '0', '0', NULL, NULL, NULL, NULL),
(NULL, 'Sa', '0', '0', NULL, NULL, NULL, NULL),
(NULL, 'Su', '0', '0', NULL, NULL, NULL, NULL);