<?php
/**
 * @category   Smarty Plugin
 * @package    plugins core
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cms.com)
 * @license    Proprietary software
 * @version    1.0 2009-08-27
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */
/**
 * Smarty {static_metas} function plugin
 *
 * Type:     function
 * Name:     static_metas
 * Date:     January, 2010
 * Purpose:  Ajoute une métas statique
 * Examples: {static_metas param=""}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 */
function smarty_function_static_metas($params, &$smarty){
	$param = $params['param'];
	$dynamic = $params['dynamic'];
	if (!isset($param)) {
	 	$smarty->trigger_error("config: missing 'param' parameter");
		return;
	}
	if($param == null){
		$seo = $dynamic;
	}elseif($param != null){
		$seo = $param;
	}
	return magixcjquery_form_helpersforms::inputClean($seo);
}