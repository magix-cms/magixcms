<?php
/**
 * @category   Controller
 * @package    CMS
 * @copyright  Copyright (c) 2010 - 2011 Dance connexion
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@magix-cms.com>
 * SEO REWRITE METAS
 *
 */
/**
 * Smarty {seo_rewrite module=""} function plugin
 *
 * Type:     function
 * Name:     SEO REWRITE METAS
 * Date:     JUNY 29, 2011
 * Update 		25/07/2011
 * Purpose:  
 * Examples: {seo_rewrite config_param=['level'=>'3','idmetas'=>'1','default'=>''] category="" subcategory="" record=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.1
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_seo_rewrite($params, $template){
	if (!isset($params['config_param'])) {
	 	trigger_error("config_param: missing 'config_param' parameter");
		return;
	}
	if(is_array($params['config_param'])){
		$tabs = $params['config_param'];
	}
	$record = $params['record'];
	$category = $params['category'];
	$subcategory = $params['subcategory'];
	if(isset($_GET['magixmod'])){
		$magixmod = magixcjquery_filter_var::clean($_GET['magixmod']);
	}
	$filename = substr($_SERVER['SCRIPT_NAME'],1);
	$position = strpos($filename, '.');
	$attribute = substr($filename, 0, $position);
	if($attribute == 'plugins'){
		$module = $attribute.':'.$magixmod;
	}else{
		$module = $attribute;
	}
	$iniseo = new frontend_controller_seo($module,$tabs['level'],$tabs['idmetas'],frontend_model_template::current_Language());
	if($iniseo->replace_var_rewrite($record,$category,$subcategory) != null){
		return $iniseo->replace_var_rewrite($record,$category,$subcategory);
	}else{
		if (!isset($tabs['default'])) {
		 	trigger_error("default: missing 'default' parameter");
			return;
		}else{
			return $tabs['default'];
		}
	}
}