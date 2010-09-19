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
				if(file_exists(magixglobal_model_system::base_path().'/skin/default/')){
					$theme =  'default';
				}
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
			if(file_exists(magixglobal_model_system::base_path().'/skin/default/')){
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
	 * singleton dbconfig
	 * @access public
	 * @var void
	 */
	static protected $backenddbtheme;
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
		return magixglobal_model_db::layerDB()->selectOne($sql);
    }
    /**
     * Change le theme courant
     * @param $theme
     */
    public function u_change_theme($theme){
    	$sql = 'UPDATE mc_setting SET setting_value = :theme WHERE setting_id = "theme"';
		magixglobal_model_db::layerDB()->update($sql,
			array(
				':theme'=>$theme
			)
		);
    }
}
?>