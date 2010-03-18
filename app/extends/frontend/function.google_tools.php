<?php
/**
 * @category   Smarty Plugin
 * @package Smarty
 * @subpackage plugins
 * @copyright  Copyright (c) 2009 - 2010 (http://www.magix-cmsa.com)
 * @license    Proprietary software
 * @version    1.1 2010-03-11
 * @author Gérits Aurélien <aurelien@web-solution-way.be>
 *
 */
/**
 * Smarty {google_tools} function plugin
 *
 * Type:     function
 * Name:     google_tools
 * Date:     Décember 18, 2009
 * Update:   Mars 12, 2010
 * Purpose:  
 * Examples: {google_tools}
 * Output:   
 * @link 
 * @author   Gerits Aurelien
 * @version  1.1
 * @param array
 * @param Smarty
 * @return string
 *
 */
function smarty_function_google_tools($params, &$smarty){
	$type = $params['tools'];
	switch ($type){
		case 'analytics':
		$analyticsdata = frontend_model_setting::select_uniq_setting('analytics');
		$tools = '<script type="text/javascript">
		var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
		document.write(unescape("%3Cscript src=\'" + gaJsHost + "google-analytics.com/ga.js\' type=\'text/javascript\'%3E%3C/script%3E"));
		</script>'.
		'<script type="text/javascript">
		try {
		var pageTracker = _gat._getTracker("'.$analyticsdata['setting_value'].'");
		pageTracker._trackPageview();
		} catch(err) {}</script>';
			break;
		case 'webmaster':
			$webmasterdata = frontend_model_setting::select_uniq_setting('webmaster');
			$tools = $webmasterdata['setting_value'];
			break;
	}
	return $tools;
}