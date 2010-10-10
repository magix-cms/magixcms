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
}
/**
 * Class db theme
 * Requête SQL pour le chargement du thème approprié au site internet
 * @author Aurelien
 *
 */
class db_theme{
	/**
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static protected $frontenddbtheme;
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
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
}
?>