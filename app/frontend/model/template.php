<?php
/**
 * MAGIX CMS
 * @category   MODEL 
 * @package    frontend
 * @copyright  MAGIX CMS Copyright (c) 2010 Gerits Aurelien, 
 * http://www.magix-cms.com, http://www.logiciel-referencement-professionnel.com http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be> | <gerits.aurelien@gmail.com>
 * @name template
 *
 */
class frontend_model_template extends db_theme{
	/**
	 * Constante pour le chemin vers le dossier de configuration des langues statiques pour le contenu
	 * @var string
	 */
	private static $ConfigFile = 'local';
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static protected $frontendtheme;
	/**
	 * 
	 * Constructor
	 */
    public function __construct(){}
	/**
	 * 
	 */
	public static function frontendTheme(){
        if (!isset(self::$frontendtheme)){
         	self::$frontendtheme = new frontend_model_template();
        }
    	return self::$frontendtheme;
    }
    /**
     * @access public static
     * Paramètre de langue get
     */
	public static function getLanguage(){
		if(magixcjquery_filter_request::isGet('strLangue')){
			return magixcjquery_filter_join::getCleanAlpha($_GET['strLangue'],3);
		}
	}
	/**
	 * Retourne la langue en cours de session sinon retourne fr par défaut
	 * @return string
	 * @access public 
	 * @static
	 */
	public static function current_Language(){
		if(magixcjquery_filter_request::isGet('strLangue')){
			$lang = self::getLanguage();
		}else{
			$db = frontend_db_lang::s_default_language();
			if($db != null){
				$lang = $db['iso'];
			}else{
				if(magixcjquery_filter_request::isSession('strLangue')){
					$lang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
				}
			}
		}
		return $lang;
	}
	/**
	 * @access private
	 * return void
	 * Le chemin du dossier des plugins
	 */
	private function directory_plugins(){
		return magixglobal_model_system::base_path();
	}
	/**
	 * Chargement du fichier de configuration suivant la langue en cours de session.
	 * @access private
	 * return string
	 */
	private function pathConfigLoad($configfile){
		try {
			return $configfile.self::current_Language().'.conf';
		}catch (Exception $e){
			magixglobal_model_system::magixlog('An error has occured :',$e);
		}
	}
	/**
	 * 
	 * Initialise la fonction configLoad de smarty
	 * @param string $section
	 */
	public static function configLoad($section = ''){
		return frontend_config_smarty::getInstance()->configLoad(self::pathConfigLoad(self::$ConfigFile), $section);
	}
	/**
	 * Charge le theme selectionné ou le theme par défaut
	 */
	public function load_theme(){
		$db = parent::s_current_theme();
		if($db['setting_value'] != null){
			if($db['setting_value'] == 'default'){
				$theme =  $db['setting_value'];
			}elseif(file_exists(magixglobal_model_system::base_path().'/skin/'.$db['setting_value'].'/')){
				$theme =  $db['setting_value'];
			}else{
				try {
					$theme = 'default';
	        		throw new Exception('template '.$db['setting_value'].' is not found');
				} catch (Exception $e){
					magixglobal_model_system::magixlog('An error has occured :',$e);
				}
			}
		}else{
			$theme = 'default';
		}
		return $theme;
	}
	/**
	 * Function load public theme
	 * @see frontend_config_theme
	 */
	public static function themeSelected(){
		if (!self::frontendTheme() instanceof frontend_model_template){
			throw new Exception('template load is not found');
		}
		return self::frontendTheme()->load_theme();
	}
	/**
	 * Affiche les pages phtml
	 * @param void $page
	 */
	public static function display($page,$plugin=''){
		return frontend_config_smarty::getInstance()->display($page);
	}
	/**
	 * Affiche les pages phtml supplémentaire
	 * @param void $page
	 */
	public static function fetch($page,$plugin=''){
		return frontend_config_smarty::getInstance()->fetch($page);
	}
	/**
	 * Assign les variables dans les fichiers phtml
	 * @param void $page
	 */
	public static function assign($assign,$fetch){
		return frontend_config_smarty::getInstance()->assign($assign,$fetch);
	}
	/**
	 * Charge les variables du fichier de config dans le site
	 * @param string $varname
	 */
	public static function getConfigVars($varname){
		if($varname != null){
			return frontend_config_smarty::getInstance()->getConfigVars($varname);
		}else{
			throw new Exception("getConfigVars is null");
		}
	}
}
/**
 * Class db theme
 * Requête SQL pour le chargement du thème approprié au site internet
 * @author Aurelien
 *
 */
class db_theme{
    /**
     * Retourne le theme utilisé
     */
    protected function s_current_theme(){
    	$sql = 'SELECT setting_value FROM mc_setting 
    	WHERE setting_id = "theme"';
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
}
?>