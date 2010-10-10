CREATE TABLE `mc_plugins_contact` (
  `idcontact` tinyint(2) NOT NULL auto_increment,
  `idadmin` tinyint(2) NOT NULL,
  `idlang` tinyint(4) NOT NULL,
  PRIMARY KEY  (`idcontact`),
  KEY `idadmin` (`idadmin`),
  KEY `idlang` (`idlang`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `mc_plugins_contact`
  ADD CONSTRAINT `mc_plugins_contact_ibfk_3` FOREIGN KEY (`idadmin`) REFERENCES `mc_admin_member` (`idadmin`);