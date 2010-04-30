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
class exec_controller_install{
	/**
	 * chemin vers le fichier de base config.in.php
	 * @var void
	 */
	public static $config_in;
	/**
	 * chemin vers le fichier de base config.php
	 * @var void
	 */
	public static $configfile;
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
		/**
		 * path for reading file config.php.in
		 */
		self::$config_in = $_SERVER['DOCUMENT_ROOT'].'/app/config/config.php.in';
		/*
		 * path for create file config.php
		 */
		self::$configfile = $_SERVER['DOCUMENT_ROOT'].'/app/config/config.php';
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
	private function writeConfigFile(){
		if(isset($_POST['M_DBHOST']) && isset($_POST['M_DBUSER']) && isset($_POST['M_DBPASSWORD']) && isset($_POST['M_DBNAME'])){
			//echo dirname(self::$configfile);
			if (!is_writable(dirname(self::$configfile))) {
				throw new Exception(sprintf('Cannot write %s file.',self::$configfile));
			}
			self::config_in_exist();
			try{
				# Creates config.php file
				$full_conf = file_get_contents(self::$config_in);
				$writeconst = new magixcjquery_files_makefiles();
				/**
				 * create constante define in config file
				 */
				$writeconst->writeConstValue('M_DBDRIVER',self::$M_DBDRIVER,$full_conf);
				$writeconst->writeConstValue('M_DBHOST',self::$M_DBHOST,$full_conf);
				$writeconst->writeConstValue('M_DBUSER',self::$M_DBUSER,$full_conf);
				$writeconst->writeConstValue('M_DBPASSWORD',self::$M_DBPASSWORD,$full_conf);
				$writeconst->writeConstValue('M_DBNAME',self::$M_DBNAME,$full_conf);
				switch(self::$M_LOG){
					case 'debug':
						$writeconst->writeConstValue('M_LOG',self::$M_LOG,$full_conf);
					break;
					case 'log':
						$writeconst->writeConstValue('M_LOG',self::$M_LOG,$full_conf);
					break;
					case 'false':
						$writeconst->writeConstValue('M_LOG',self::$M_LOG,$full_conf,false);
				}
				$writeconst->writeConstValue('M_TMP_DIR',self::$M_TMP_DIR,$full_conf);
				$writeconst->writeConstValue('M_FIREPHP',self::$M_FIREPHP,$full_conf,false);
				
				$fp = fopen(self::$configfile,'wb');
				if ($fp === false) {
					throw new Exception(sprintf('Cannot write %s file.',self::$configfile));
				}
				fwrite($fp,$full_conf);
				fclose($fp);
				//chmod(self::$configfile, 0666);
				exec_config_smarty::getInstance()->display('request/success-config.phtml');
			} catch(Exception $e) {
				$log = magixcjquery_error_log::getLog();
	        	$log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        	$log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        	magixcjquery_debug_magixfire::magixFireError($e);
			}
		}
	}
	public function createConfig(){
		self::writeConfigFile();
	}
	public function display_install_page(){
		exec_config_smarty::getInstance()->display('install.phtml');
	}
}