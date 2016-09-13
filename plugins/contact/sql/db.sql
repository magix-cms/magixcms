CREATE TABLE IF NOT EXISTS `mc_plugins_contact` (
  `idcontact` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `idlang` smallint(3) unsigned NOT NULL,
  `mail_contact` varchar(45) NOT NULL,
  PRIMARY KEY (`idcontact`),
  KEY `idlang` (`mail_contact`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `mc_plugins_contact_config` (
  `idcontact_config` smallint(3) unsigned NOT NULL AUTO_INCREMENT,
  `address_enabled` smallint(3) unsigned NOT NULL,
  `address_required` smallint(3) unsigned NOT NULL,
  `enable_inliner` smallint(1) unsigned NOT NULL DEFAULT 1,
  PRIMARY KEY (`idcontact_config`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

INSERT INTO `mc_plugins_contact_config` (`address_enabled`, `address_required`) VALUES (0, 0);