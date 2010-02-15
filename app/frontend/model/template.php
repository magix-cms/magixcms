<?php
/**
 * @category   config theme configuration
 * @package    Magix CMS
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2010-01-25
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
class frontend_model_template extends db_theme{
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static protected $frontendtheme;
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
	 * Charge le theme selectionné ou le theme par défaut
	 */
	public function load_theme(){
		$db = parent::frontendDBtheme()->s_current_theme();
		if($db['setting_value'] != null){
			if($db['setting_value'] == 'default'){
				$theme =  $db['setting_value'];
			}elseif(file_exists($_SERVER['DOCUMENT_ROOT'].'/skin/'.$db['setting_value'].'/')){
				$theme =  $db['setting_value'];
			}else{
				try {
					$theme = 'default';
	        		throw new Exception('template '.$db['setting_value'].' is not found');
				} catch(Exception $e) {
				    $log = magixcjquery_error_log::getLog();
	        		$log->logfile = $_SERVER['DOCUMENT_ROOT'].'/var/report/handlererror.log';
	        		$log->write('An error has occured :'. $e->getMessage(),__FILE__, $e->getLine());
	        		magixcjquery_debug_magixfire::magixFireError($e);
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
}
/**
 * Class db theme
 * Requête SQL pour le chargement du thème approprié au site internet
 * @author Aurelien
 *
 */
class db_theme{
	/**
	 * protected var ini class magixLayer
	 *
	 * @var layer
	 * @access protected
	 */
	private $layer;
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static protected $frontenddbtheme;
	/**
	 * Function construct class
	 *
	 */
	function __construct(){
		$this->layer = new magixcjquery_magixdb_layer();
	}
	/**
	 * instance backend_db_config with singleton
	 */
	protected static function frontendDBtheme(){
        if (!isset(self::$frontenddbtheme)){
         	self::$frontenddbtheme = new db_theme();
        }
    	return self::$frontenddbtheme;
    }
    /**
     * Retourne le theme utilisé
     */
    public function s_current_theme(){
    	$sql = 'SELECT setting_value FROM mc_setting WHERE setting_id = "theme"';
		return $this->layer->selectOne($sql);
    }
}
?>