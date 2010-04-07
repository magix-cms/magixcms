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
class install_controller_install{
	/**
	 * chemin vers le fichier de base config.in.php
	 * @var void
	 */
	public static $config_in;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBDRIVER;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBHOST;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBUSER;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBPASSWORD;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_DBNAME;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_LOG;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_TMP_DIR;
	/**
	 * variable pour la constante du fichier de configuration
	 * @var string
	 */
	public static $M_FIREPHP;
	/**
	 * Constructor
	 */
	function __construct(){
		self::$config_in = $_SERVER['DOCUMENT_ROOT'].'/app/conf/config.php.in';
		self::$M_DBDRIVER = !empty($_POST['M_DBDRIVER']) ? $_POST['M_DBDRIVER'] : 'mysql';
		self::$M_DBHOST = !empty($_POST['M_DBHOST']) ? $_POST['M_DBHOST'] : '';
		self::$M_DBUSER = !empty($_POST['M_DBUSER']) ? $_POST['M_DBUSER'] : '';
		self::$M_DBPASSWORD = !empty($_POST['M_DBPASSWORD']) ? $_POST['M_DBPASSWORD'] : '';
		self::$M_DBNAME = !empty($_POST['M_DBNAME']) ? $_POST['M_DBNAME'] : '';
		self::$M_LOG = !empty($_POST['M_LOG']) ? $_POST['M_LOG'] : '';
		self::$M_TMP_DIR = !empty($_POST['M_TMP_DIR']) ? $_POST['M_TMP_DIR'] : '';
		self::$M_FIREPHP = !empty($_POST['M_FIREPHP']) ? $_POST['M_FIREPHP'] : '';
	}
	/**
	 * Vérifie si le fichier config.php.in est présent
	 */
	private function config_in_exist(){
		if (!is_file(self::$config_in)) {
			throw new Exception(sprintf('File %s does not exist.',self::$config_in));
		}
		return true;
	}
	public function display_install_page(){
		install_config_smarty::getInstance()->display('install.phtml');
	}
}