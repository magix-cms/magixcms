CREATE TABLE IF NOT EXISTS `mc_plugins_contact` (
  `idcontact` tinyint(2) NOT NULL,
  `idadmin` tinyint(2) NOT NULL,
  `idlang` tinyint(4) NOT NULL,
  PRIMARY KEY  (`idcontact`),
  KEY `idadmin` (`idadmin`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `mc_plugins_contact`
  ADD CONSTRAINT `mc_plugins_contact_ibfk_2` FOREIGN KEY (`idlang`) REFERENCES `mc_lang` (`idlang`),
  ADD CONSTRAINT `mc_plugins_contact_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `mc_admin_member` (`idadmin`);