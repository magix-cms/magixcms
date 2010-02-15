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
class backend_model_template extends db_theme{
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static protected $backendtheme;
	/**
	 * 
	 */
	public static function backendTheme(){
        if (!isset(self::$backendtheme)){
         	self::$backendtheme = new backend_model_template();
        }
    	return self::$backendtheme;
    }
	/**
	 * Charge le theme selectionné ou le theme par défaut
	 */
	public function load_theme(){
		// Charge le théme courant dans la base de donnée
		$db = parent::backendDBtheme()->s_current_theme();
		if($db['setting_value'] != null){
			if($db['setting_value'] == 'default'){
				if(file_exists($_SERVER['DOCUMENT_ROOT'].'/skin/default/')){
					$theme =  'default';
				}
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
			if(file_exists($_SERVER['DOCUMENT_ROOT'].'/skin/default/')){
				$theme =  'default';
			}
		}
		return $theme;
	}
	/**
	 * Function load public theme
	 * @see frontend_config_theme
	 */
	public static function themeSelected(){
		if (!self::backendTheme() instanceof backend_model_template){
			throw new Exception('template load is not found');
		}
		return self::backendTheme()->load_theme();
	}
	/**
	 * UpdateTheme
	 * @param string $post
	 */
	public function UpdateTheme($post){
		if(isset($post)){
			if($post != null){
				parent::u_change_theme($post);
			}else{
				throw new Exception('template is null');
			}
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
	static protected $backenddbtheme;
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
	protected static function backendDBtheme(){
        if (!isset(self::$backenddbtheme)){
         	self::$backenddbtheme = new db_theme();
        }
    	return self::$backenddbtheme;
    }
    /**
     * Retourne le theme utilisé
     */
    public function s_current_theme(){
    	$sql = 'SELECT setting_value FROM mc_setting WHERE setting_id = "theme"';
		return $this->layer->selectOne($sql);
    }
    /**
     * Change le theme courant
     * @param $theme
     */
    public function u_change_theme($theme){
    	$sql = 'UPDATE mc_setting SET setting_value = :theme WHERE setting_id = "theme"';
		$this->layer->update($sql,
			array(
				':theme'=>$theme
			)
		);
    }
}
?>