<?php
/**
 * @category   Controller
 * @package    CMS
 * @copyright  Copyright (c) 2010 - 2011 Dance connexion
 * @license    Proprietary software
 * @version    1.0
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 * SEO REWRITE METAS
 *
 */
/**
 * Smarty {seo_rewrite module=""} function plugin
 *
 * Type:     function
 * Name:     SEO REWRITE METAS
 * Date:     JUNY 29, 2011
 * Purpose:  
 * Examples: {seo_rewrite config_param=['level'=>'3','idmetas'=>'1'] category="" subcategory="" record=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
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
	if(!isset($_GET['strLangue'])){
		$_SESSION['strLangue'] = 'fr';
	}
	if(!empty($_SESSION['strLangue'])){
		$alias_lang = magixcjquery_filter_join::getCleanAlpha($_SESSION['strLangue'],3);
	}else{
		$alias_lang = 'fr';
	}
	$filename = substr($_SERVER['SCRIPT_NAME'],1);
	$position = strpos($filename, '.');
	$attribute = substr($filename, 0, $position);
	if($attribute == 'plugins'){
		$module = $attribute.'_'.$_GET['magixmod'];
	}else{
		$module = $attribute;
	}
	$iniseo = new frontend_controller_seo($module,$tabs['level'],$tabs['idmetas'],$alias_lang);
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