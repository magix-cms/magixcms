CREATE TABLE IF NOT EXISTS `mc_plugins_contact` (
  `idcontact` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
  `idlang` smallint(3) unsigned NOT NULL,
  `mail_contact` varchar(45) NOT NULL,
  PRIMARY KEY (`idcontact`),
  KEY `idadmin` (`idlang`),
  KEY `idlang` (`mail_contact`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;