<?php
/**
 * @category   Controller
 * @package    install
 * @copyright  Copyright Magix CMS (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name home
 *
 */
class exec_controller_database extends create_database{
	/**
	 * post ctable
	 * @var void
	 */
	public $ctable;
	/**
	 * Constructor
	 */
	function __construct(){
		if(isset($_POST['ctable'])){
			$this->ctable = ($_POST['ctable']);
		}
	}
	/**
	 * Envoi la création de la table des utilisateurs
	 */
	public function c_database_user(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_user()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des permissions utilisateurs
	 */
	public function c_database_perms(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_perms()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des sessions utilisateurs
	 */
	public function c_database_sessions(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_sessions()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des produits du catalogue
	 */
	public function c_database_catalog_product(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_catalog_product()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des catégories du catalogue
	 */
	public function c_database_catalog_category(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_catalog_category()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des catégories du catalogue
	 */
	public function c_database_catalog_subcategory(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_catalog_subcategory()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des images produits du catalogue
	 */
	public function c_database_catalog_img(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_catalog_img()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des micro galeries produits du catalogue
	 */
	public function c_database_catalog_galery(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_catalog_galery()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table catégorie CMS
	 */
	public function c_database_cms_category(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_cms_category()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table page CMS
	 */
	public function c_database_cms_page(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_cms_page()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table de limitation du nombre d'insertion
	 */
	public function c_database_config_limited_module(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_config_limited_module()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des formulaires
	 */
	public function c_database_forms(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_forms()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des champs du module formulaires
	 */
	public function c_database_forms_input(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_forms_input()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table global config
	 */
	public function c_database_global_config(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_global_config()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des langues
	 */
	public function c_database_lang(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_lang()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table de la réécriture des métas
	 */
	public function c_database_metas_rewrite(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_metas_rewrite()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des news(articles)
	 */
	public function c_database_news(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_news()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des news(articles) publiés
	 */
	public function c_database_news_publication(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_news_publication()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table des pages d'accueil
	 */
	public function c_database_home(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_home()){
				parent::cdatabase()->c_table_home_config();
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table de configuration des plugins
	 */
	public function c_database_plugins_module(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_plugins_module()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Envoi la création de la table du settings global
	 */
	public function c_database_settings(){
		if (isset($this->ctable)){
			if(parent::cdatabase()->c_table_settings()){
				exec_config_smarty::getInstance()->display('request/success-table.phtml');
			}else{
				exec_config_smarty::getInstance()->display('request/error-table.phtml');
			}
		}
	}
	/**
	 * Affiche la page de la construction des tables
	 */
	public function display_database_page(){
		exec_config_smarty::getInstance()->display('database.phtml');
	}
}
class create_database{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	protected $layer;
	/**
	 * singleton dbnews
	 * @access public
	 * @var void
	 */
	static public $cdatabase;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
	/**
	 * instance frontend_db_news with singleton
	 */
	public static function cdatabase(){
        if (!isset(self::$cdatabase)){
         	self::$cdatabase = new create_database();
        }
    	return self::$cdatabase;
    }
    /*
     * requête sql pour la création de la table des utilisateurs
     */
	public function c_table_user(){
		$sql = 'CREATE TABLE IF NOT EXISTS `mc_admin_member` (
		  `idadmin` tinyint(2) NOT NULL AUTO_INCREMENT,
		  `pseudo` varchar(20) NOT NULL,
		  `email` varchar(40) NOT NULL,
		  `cryptpass` varchar(50) NOT NULL,
		  PRIMARY KEY (`idadmin`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des permissions utilisateurs
	 */
	public function c_table_perms(){
		$sql = 'CREATE TABLE IF NOT EXISTS `mc_admin_perms` (
		  `idadmin` tinyint(2) NOT NULL AUTO_INCREMENT,
		  `perms` tinyint(1) NOT NULL,
		  KEY `idadmin` (`idadmin`)
		) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;';
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des sessions utilisateurs
	 */
	public function c_table_sessions(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_admin_session` (
			  `sid` tinytext NOT NULL,
			  `userid` tinyint(2) NOT NULL,
			  `last_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
			  `ip` varchar(20) NOT NULL,
			  `browser` varchar(50) DEFAULT NULL,
			  KEY `userid` (`userid`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des sessions utilisateurs';
			ALTER TABLE `mc_admin_session`
			  ADD CONSTRAINT `mc_admin_session_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `mc_admin_member` (`idadmin`);";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des produits du catalogue
	 */
	public function c_table_catalog_product(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_catalog` (
			  `idcatalog` int(6) NOT NULL AUTO_INCREMENT,
			  `idclc` tinyint(3) NOT NULL,
			  `idcls` tinyint(3) NOT NULL DEFAULT '0',
			  `idlang` tinyint(1) NOT NULL DEFAULT '0',
			  `idadmin` tinyint(2) NOT NULL,
			  `urlcatalog` varchar(120) NOT NULL,
			  `titlecatalog` varchar(120) NOT NULL,
			  `desccatalog` text NOT NULL,
			  `price` decimal(12,2) DEFAULT NULL,
			  `ordercatalog` int(6) NOT NULL,
			  `publish` tinyint(1) NOT NULL DEFAULT '1',
			  PRIMARY KEY (`idcatalog`),
			  KEY `idclc` (`idclc`,`idcls`,`idlang`),
			  KEY `idadmin` (`idadmin`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='table du catalogue' AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des catégories du catalogue
	 */
	public function c_table_catalog_category(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_catalog_c` (
			  `idclc` tinyint(3) NOT NULL AUTO_INCREMENT,
			  `clibelle` varchar(100) NOT NULL,
			  `pathclibelle` varchar(100) NOT NULL,
			  `idlang` tinyint(1) NOT NULL DEFAULT '0',
			  `corder` tinyint(3) NOT NULL,
			  PRIMARY KEY (`idclc`),
			  KEY `idlang` (`idlang`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='table des catégories du catalogue' AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des sous catégories du catalogue
	 */
	public function c_table_catalog_subcategory(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_catalog_s` (
			  `idcls` tinyint(3) NOT NULL AUTO_INCREMENT,
			  `slibelle` varchar(100) NOT NULL,
			  `pathslibelle` varchar(100) NOT NULL,
			  `idclc` tinyint(3) NOT NULL,
			  `sorder` tinyint(3) NOT NULL,
			  PRIMARY KEY (`idcls`),
			  KEY `idclc` (`idclc`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des sous catégories du catalogue' AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des images du catalogue
	 */
	public function c_table_catalog_img(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_catalog_img` (
			  `idcatalog` int(6) NOT NULL,
			  `imgcatalog` varchar(120) NOT NULL,
			  PRIMARY KEY (`idcatalog`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des images du catalogue';
			ALTER TABLE `mc_catalog_img`
  			ADD CONSTRAINT `mc_catalog_img_ibfk_1` FOREIGN KEY (`idcatalog`) REFERENCES `mc_catalog` (`idcatalog`);";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des micro galerie du catalogue
	 */
	public function c_table_catalog_galery(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_catalog_galery` (
			  `idmicro` int(6) NOT NULL AUTO_INCREMENT,
			  `idcatalog` int(6) NOT NULL,
			  `imgcatalog` varchar(120) NOT NULL,
			  PRIMARY KEY (`idmicro`),
			  KEY `idcatalog` (`idcatalog`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table pour la génération de micro galerie dans un catalogue' AUTO_INCREMENT=1 ;
		";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des catégories CMS
	 */
	public function c_table_cms_category(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_cms_category` (
			  `idcategory` tinyint(3) NOT NULL AUTO_INCREMENT,
			  `category` varchar(100) DEFAULT NULL,
			  `pathcategory` varchar(100) DEFAULT NULL,
			  `idlang` tinyint(1) NOT NULL DEFAULT '0',
			  `idorder` tinyint(2) NOT NULL,
			  PRIMARY KEY (`idcategory`),
			  KEY `idlang` (`idlang`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='les catégories du cms' AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des pages CMS
	 */
	public function c_table_cms_page(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_cms_page` (
			  `idpage` tinyint(4) NOT NULL AUTO_INCREMENT,
			  `idcategory` tinyint(3) NOT NULL DEFAULT '0',
			  `idlang` tinyint(1) NOT NULL DEFAULT '0',
			  `pathpage` varchar(120) NOT NULL,
			  `subjectpage` varchar(120) NOT NULL,
			  `contentpage` text NOT NULL,
			  `idadmin` tinyint(2) NOT NULL,
			  `metatitle` varchar(150) DEFAULT NULL,
			  `metadescription` varchar(180) DEFAULT NULL,
			  `orderpage` tinyint(4) NOT NULL,
			  `viewpage` tinyint(1) NOT NULL,
			  PRIMARY KEY (`idpage`),
			  KEY `idcategory` (`idcategory`,`idlang`),
			  KEY `idadmin` (`idadmin`)
			) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table de limitation de pages
	 */
	public function c_table_config_limited_module(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_config_limited_module` (
				  `idconfig` tinyint(1) NOT NULL,
				  `number` tinyint(1) NOT NULL,
				  PRIMARY KEY (`idconfig`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Table pour la configuration des modules à limiter';
				INSERT INTO `mc_config_limited_module` (`idconfig`, `number`) VALUES
				(1, 0),
				(2, 0),
				(3, 0),
				(4, 0);
				ALTER TABLE `mc_config_limited_module`
				  ADD CONSTRAINT `mc_config_limited_module_ibfk_1` FOREIGN KEY (`idconfig`) REFERENCES `mc_global_config` (`idconfig`);";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des formulaires dynamique
	 */
	public function c_table_forms(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_forms` (
			  `idforms` tinyint(3) NOT NULL AUTO_INCREMENT,
			  `idlang` tinyint(1) NOT NULL DEFAULT '0',
			  `urlforms` varchar(50) NOT NULL,
			  `titleforms` varchar(50) NOT NULL,
			  PRIMARY KEY (`idforms`),
			  KEY `idlang` (`idlang`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des formulaires dynamique' AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des champs de formulaires dynamique
	 */
	public function c_table_forms_input(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_forms_input` (
			  `idinput` mediumint(7) NOT NULL AUTO_INCREMENT,
			  `idforms` tinyint(3) NOT NULL,
			  `label` varchar(20) NOT NULL,
			  `type` tinyint(1) NOT NULL DEFAULT '1',
			  `nameinput` varchar(20) NOT NULL,
			  `required` tinyint(1) NOT NULL DEFAULT '0',
			  `size` decimal(10,0) DEFAULT NULL,
			  `maxlength` decimal(10,0) DEFAULT NULL,
			  `value` text,
			  PRIMARY KEY (`idinput`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='table des champs du formulaire dynamique' AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des champs de formulaires dynamique
	 */
	public function c_table_global_config(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_global_config` (
				  `idconfig` tinyint(1) NOT NULL AUTO_INCREMENT,
				  `named` varchar(20) NOT NULL,
				  `status` tinyint(1) NOT NULL DEFAULT '0',
				  PRIMARY KEY (`idconfig`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;
				INSERT INTO `mc_global_config` (`idconfig`, `named`, `status`) VALUES
				(1, 'lang', 1),
				(2, 'cms', 1),
				(3, 'news', 1),
				(4, 'catalog', 1),
				(5, 'rewritenews', 1),
				(6, 'rewritecms', 1),
				(7, 'rewritecatalog', 1),
				(8, 'forms', 0),
				(9, 'microgalery', 1);";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des langues
	 */
	public function c_table_lang(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_lang` (
				  `idlang` tinyint(4) NOT NULL AUTO_INCREMENT,
				  `codelang` varchar(2) NOT NULL,
				  `desclang` varchar(20) NOT NULL,
				  PRIMARY KEY (`idlang`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des réécriture des métas
	 */
	public function c_table_metas_rewrite(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_metas_rewrite` (
				  `idrewrite` tinyint(2) NOT NULL AUTO_INCREMENT,
				  `idconfig` tinyint(1) NOT NULL,
				  `idlang` tinyint(1) NOT NULL DEFAULT '0',
				  `strrewrite` varchar(255) DEFAULT NULL,
				  `idmetas` tinyint(1) NOT NULL,
				  `level` tinyint(1) NOT NULL DEFAULT '0',
				  PRIMARY KEY (`idrewrite`),
				  KEY `idlang` (`idlang`),
				  KEY `idconfig` (`idconfig`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des news
	 */
	public function c_table_news(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_news` (
				  `idnews` tinyint(3) NOT NULL AUTO_INCREMENT,
				  `subject` varchar(125) NOT NULL,
				  `rewritelink` varchar(125) NOT NULL,
				  `content` text NOT NULL,
				  `idlang` tinyint(1) NOT NULL,
				  `idadmin` tinyint(2) NOT NULL,
				  `date_sent` date NOT NULL,
				  `postdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
				  PRIMARY KEY (`idnews`),
				  KEY `idlang` (`idlang`),
				  KEY `idadmin` (`idadmin`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;
				ALTER TABLE `mc_news`
  				ADD CONSTRAINT `mc_news_ibfk_1` FOREIGN KEY (`idadmin`) REFERENCES `mc_admin_member` (`idadmin`);";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des publications news
	 */
	public function c_table_news_publication(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_news_publication` (
				  `idnews` tinyint(3) NOT NULL AUTO_INCREMENT,
				  `date_publication` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
				  `publish` tinyint(4) NOT NULL DEFAULT '0',
				  KEY `idnews` (`idnews`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
				ALTER TABLE `mc_news_publication`
  				ADD CONSTRAINT `mc_news_publication_ibfk_1` FOREIGN KEY (`idnews`) REFERENCES `mc_news` (`idnews`);";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des pages d'accueil
	 */
	public function c_table_home(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_page_home` (
				  `idhome` tinyint(1) NOT NULL AUTO_INCREMENT,
				  `subject` varchar(100) NOT NULL,
				  `content` text NOT NULL,
				  `metatitle` varchar(150) DEFAULT NULL,
				  `metadescription` varchar(180) DEFAULT NULL,
				  `idlang` tinyint(1) NOT NULL DEFAULT '0',
				  `idadmin` tinyint(2) NOT NULL,
				  PRIMARY KEY (`idhome`),
				  KEY `idlang` (`idlang`),
				  KEY `idadmin` (`idadmin`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='table pour la page home ou index' AUTO_INCREMENT=2 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des configurations de la page d'accueil
	 */
	public function c_table_home_config(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_page_home_config` (
				  `idhome` tinyint(4) NOT NULL COMMENT 'identifiant de la page home',
				  `slideshow` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'configuration du slideshow sur la page home',
				  `news` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'configuration du module de news sur la page home',
				  KEY `idhome` (`idhome`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des configurations de la page d'accueil
	 */
	public function c_table_plugins_module(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_plugins_module` (
				  `idplugin` tinyint(4) NOT NULL AUTO_INCREMENT,
				  `pname` varchar(20) NOT NULL,
				  `pageadmin` tinyint(1) NOT NULL DEFAULT '0',
				  PRIMARY KEY (`idplugin`)
				) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
		$this->layer->createTable($sql);
		return true;
	}
	/**
	 * requête sql pour la création de la table des settings
	 */
	public function c_table_settings(){
		$sql = "CREATE TABLE IF NOT EXISTS `mc_setting` (
				  `setting_id` varchar(255) NOT NULL,
				  `setting_value` text,
				  `setting_type` varchar(8) NOT NULL DEFAULT 'string',
				  `setting_label` text,
				  KEY `setting_id` (`setting_id`)
				) ENGINE=InnoDB DEFAULT CHARSET=utf8;
				INSERT INTO `mc_setting` (`setting_id`, `setting_value`, `setting_type`, `setting_label`) VALUES
				('theme', 'default', 'string', 'site theme'),
				('microgalery', 'default', 'string', 'micro galery'),
				('sold', 'sold_product', 'string', 'Produit vendu'),
				('webmaster', '', 'string', 'google webmasterTools'),
				('analytics', '', 'string', 'google analytics');";
		$this->layer->createTable($sql);
		return true;
	}
}